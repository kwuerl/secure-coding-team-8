<?php
namespace Controller;
/**
 * Employee Controller class that handles loading of user-related pages. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */

class EmployeeController extends Controller {

	public function loadOverview ($request) {
        // render the form
        $this->get("templating")->render("employee_overview.html.php", array(
            //"form" => $helper
        ));
	}
	public function loadProfile ($request) {
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in user */
        /*Fetch the details of the current user */
        //$user = $this->get('user_repository')->get($currentUserId);
        $this->get("templating")->render("profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $user
        ));
    }
    public function loadCustomersList ($request) {
        // render the form
        $this->get("templating")->render("customers_list.html.php", array(
            //"form" => $helper
        ));
    }
     public function loadCustomerDetails ($request) {
            // render the form
            $this->get("templating")->render("customer_details.html.php", array(
                //"form" => $helper
            ));
        }
    public function approveRegistration ($request) {
                // render the form
                $this->get("templating")->render("approve_registrations.html.php", array(
                    //"form" => $helper
                ));
            }
}