<?php
namespace Controller;
/**
 * User Controller class that handles loading of user-related pages. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 */

class UserController extends Controller {

	public function loadOverview ($request) {
        // render the form
        $this->get("templating")->render("account_overview.html.php", array(
            //"form" => $helper
        ));
	}
	public function loadProfile ($request) {
        // render the form
        $this->get("templating")->render("profile_view.html.php", array(
            //"form" => $helper
        ));
    }
    public function loadTransactionHistory ($request) {
        // render the form
        $this->get("templating")->render("transaction_history.html.php", array(
            //"form" => $helper
        ));
    }
}