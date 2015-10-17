<?php
namespace Service;
/**
 * RoutingService is used to route requests to controller functions
 */
class RoutingService {
	private $service_container;
	private $halts = false;
    private $routes = array();
    private $methods = array();
    private $callbacks = array();
    private $patterns = array(
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    );
    private $error_callback;
    public function __construct($service_container) {
    	$this->service_container = $service_container;
    }
    /**
     * Defines a route w/ callback and method
     */
    public function __call($method, $params) 
    {
        $uri = dirname($_SERVER['PHP_SELF']).$params[0];
        $callback = $params[1];
        array_push($this->routes, $uri);
        array_push($this->methods, strtoupper($method));
        array_push($this->callbacks, $callback);
    }
    /**
     * Defines callback if route is not found
    */
    public function error($callback)
    {
        $this->error_callback = $callback;
    }
    
    public function haltOnMatch($flag = true)
    {
        $this->halts = $flag;
    }
    /**
     * Runs the callback for the given request
     */
    public function dispatch()
    {
    	$request = new \Helper\Request();
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];  
        $searches = array_keys($this->patterns);
        $replaces = array_values($this->patterns);
        $found_route = false;
        
        $this->routes = str_replace('//', '/', $this->routes);
        // check if route is defined without regex
        if (in_array($uri, $this->routes)) {
            $route_pos = array_keys($this->routes, $uri);
            foreach ($route_pos as $route) {
                if ($this->methods[$route] == $method) {
                    $found_route = true;
                    //if route is not an object 
                    if(!is_object($this->callbacks[$route])){

                    	$rout_conf = explode(":", $this->callbacks[$route]);

                    	$controller_service = $this->service_container->get($rout_conf[0]);

                    	if(!method_exists($controller_service, $rout_conf[1])) throw new \Exception("Controller ".$rout_conf[0]." does not have method ".$rout_conf[1]."!");

                    	call_user_func_array(array($controller_service, $rout_conf[1]), array($request));
                        
                        if ($this->halts) return;
                        
                    } else {
                        //call closure
                        call_user_func($this->callbacks[$route]);
                        if ($this->halts) return;
                    }
                }
            }
        } else {
            // check if defined with regex
            $pos = 0;
            foreach ($this->routes as $route) {
                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route);
                }
                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if ($this->methods[$pos] == $method) {
                        $found_route = true;
                        array_shift($matched); //remove $matched[0] as [1] is the first parameter.
                        if(!is_object($this->callbacks[$pos])){

                           $rout_conf = explode(":", $this->callbacks[$pos]);

	                    	$controller_service = $this->service_container->get($rout_conf[0]);

	                    	if(!method_exists($controller_service, $rout_conf[1])) throw new \Exception("Controller ".$rout_conf[0]." does not have method ".$rout_conf[1]."!");

	                    	call_user_func_array(array($controller_service, $rout_conf[1]), array_merge(array($request), $matched));
    
                            if ($this->halts) return;
                        } else {
                            call_user_func_array($this->callbacks[$pos], $matched);
                            
                            if ($this->halts) return;
                        }
                        
                    }
                }
            $pos++;
            }
        }
 
        // run the error callback if the route was not found
        if ($found_route == false) {
            if (!$this->error_callback) {
                $this->error_callback = function() {
                    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
                    echo '404';
                };
            }
            call_user_func($this->error_callback);
        }
    }
}