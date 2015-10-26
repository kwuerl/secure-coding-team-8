<?php
namespace Service;
/**
 * RoutingService is used to route requests to controller functions
 *
 * Based on https://github.com/noahbuscher/Macaw
 *
 * @author Korbinian Würl <korbinianwuerl@googlemail.com>
 */
class RoutingService {
	private $service_container;
	private $halts = false;
    private $names = array();
    private $routes = array();
    private $methods = array();
    private $callbacks = array();
    private $patterns = array(
        ':any' => '[^/]+',
        ':num' => '[0-9]+',
        ':all' => '.*'
    );
    private $error_callback;
    private $current_request;
    /**
	 * Constructor
	 */
    public function __construct(ServiceContainer $service_container) {
    	$this->service_container = $service_container;
    }
    /**
     * Defines a route w/ callback and method
     * Possible Methods will be: get, post, put, head, delete
     * Param 1 will be the name of the route.
     * Param 2 will be the route. Example: "/", "/(:any)", "/(:num)" oder any regexp
     * Param 3 will be eiter a lambda function or a string which stands for service and function. Example: "test_controller:class_function"
     * Example: 
     * <code>
     * <?php
     * $routing_service->post("/test/(:any)", "test_controller:class_function");
     * ?>
     * </code>
     */
    public function __call($method, $params) 
    {
        $name = $params[0];
        $uri = dirname($_SERVER['PHP_SELF']).$params[1];
        $callback = $params[2];
        array_push($this->names, $name);
        array_push($this->routes, $uri);
        array_push($this->methods, strtoupper($method));
        array_push($this->callbacks, $callback);
    }
    /**
	 * Defines callback if route is not found
	 *
	 * @param function $callback	Anonymous function to call if a route is not found
	 */
    public function error($callback)
    {
        $this->error_callback = $callback;
    }
    
    /**
	 * Decide if the router should stop if a matching route is found
	 *
	 * @param boolean $flag		true(default): halt on match
	 */
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
        $this->current_request = $request;
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

                        $this->current_request->setRouteName($this->names[$route]);

                    	call_user_func_array(array($controller_service, $rout_conf[1]), array($this->current_request));
                        
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
            foreach ($this->routes as $route_id) {
                if (strpos($route, ':') !== false) {
                    $route = str_replace($searches, $replaces, $route_id);
                }
                if (preg_match('#^' . $route . '$#', $uri, $matched)) {
                    if ($this->methods[$pos] == $method) {
                        $found_route = true;
                        array_shift($matched); //remove $matched[0] as [1] is the first parameter.
                        if(!is_object($this->callbacks[$pos])){

                           $rout_conf = explode(":", $this->callbacks[$pos]);

	                    	$controller_service = $this->service_container->get($rout_conf[0]);

	                    	if(!method_exists($controller_service, $rout_conf[1])) throw new \Exception("Controller ".$rout_conf[0]." does not have method ".$rout_conf[1]."!");

                            $this->current_request->setRouteName($this->names[$route]);
                            $this->current_request->setRouteParams($matched);

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

    /**
     * Defines a redirect to $dest
     *
     * @param string $dest
     * @param array $url_parameters
     */
    public function getRequest() {
        return $this->current_request;
    }

    /**
     * Returns a url for the given route name and params
     *
     * @param string $dest
     * @param array $url_parameters
     */
    public function url($dest, $url_parameters)
    {
        $index = array_search($dest, $this->names);
        if ($index !== false) {
            $searches = array_keys($this->patterns);
            $replaces = array_values($this->patterns);
            $uri = $this->routes[$index];
            $route = str_replace($searches, $replaces, $uri);
            $offset = 1;
            $uri_with_params = $uri;
            foreach ($url_parameters as $url) {
                $start = strpos($uri_with_params, "(", $offset);
                $end = strpos($uri_with_params, ")", $start);
                if ($start !== false) {
                    $uri_with_params = substr_replace($uri_with_params, $url, $start, $end-$start+1);
                    $offset = $start+1;
                }
            }
            if (preg_match("#^".$route.'$#', $uri_with_params)) {
                return $uri_with_params;
            } else {
                throw new \Exception("URL Parameters don't match!");
            }
        } else {
            throw new \Exception("Route for \"".$dest."\" not found!");
        }
    }

    /**
     * Defines a redirect to $dest
     *
     * @param string $dest
     * @param array $url_parameters
     */
    public function redirect($dest, $url_parameters)
    {
         header('Location: '.$this->url($dest, $url_parameters));
    }
}