<?php
namespace Controller;
/**
 * User Controller class that handles loading of user-related pages. Gets ServiceContainer injected.
 *
 * @author Vivek Sethia<vivek.sethia@tum.de>
 * @author Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

class UserController extends Controller {

	public function loadOverview ($request) {
        // render the form
        $this->get("templating")->render("account_overview.html.php", array(
            //"form" => $helper
        ));
	}
	public function loadProfile ($request) {
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in user */
        /*Fetch the details of the current user */
        $user = $this->get('user_repository')->get($currentUserId);
        // render the form
        $this->get("templating")->render("profile_view.html.php", array(
            //"form" => $helper,
            "currentUser" => $user
        ));
    }
    public function loadTransactionHistory ($request) {
        $currentUserId = 1; /*TODO needs to be set to the ID of the logged-in user */
        /*Fetch the transaction details for the current user */
        $transactionList = $this->get('transaction_repository')->getTransactionsByCustomerId($currentUserId);
        // render the form
        $this->get("templating")->render("transaction_history.html.php", array(
            //"form" => $helper,
            "transactionList" => $transactionList
        ));
    }
     public function makeTransfer ($request) {
            // render the form
            $this->get("templating")->render("make_transfer.html.php", array(
                //"form" => $helper
            ));
        }
}