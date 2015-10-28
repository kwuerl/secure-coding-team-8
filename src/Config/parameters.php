<?php
/**
 * Definition of constants used in the application.
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 */

define('_EXAMPLE_PARAM', 'EXAMPLE_VALUE');
define('_DB_SECURE_BANK', 'BANK_DETAILS');

define('_DB_SERVER', 'mysql');
define('_MYSQL_HOST', '127.0.0.1');
define('_MYSQL_USER', 'root');
define('_MYSQL_PASSWORD', 'root');
define('_MYSQL_DATABASE', _DB_SECURE_BANK);

define('_TBL_CUSTOMER', 'TBL_CUSTOMER');
define('_TBL_EMPLOYEE', 'TBL_EMPLOYEE');
define('_TBL_ACCOUNT', 'TBL_ACCOUNT');
define('_TBL_TRANSACTION', 'TBL_TRANSACTION');
define('_TBL_TRANSACTION_CODE', 'TBL_TRANSACTION_CODE');

define('_GROUP_USER', 'USER');
define('_GROUP_EMPLOYEE', 'EMPLOYEE');
define('_GROUP_ADMIN', 'ADMIN');

define('_CLASS_MODEL_USER', "\Model\User");
define('_CLASS_MODEL_CUSTOMER', "\Model\Customer");
define('_CLASS_MODEL_EMPLOYEE', "\Model\Employee");
define('_CLASS_MODEL_ACCOUNT', "\Model\Account");
define('_CLASS_MODEL_TRANSACTION', "\Model\Transaction");
define('_CLASS_MODEL_TRANSACTION_CODE', "\Model\TransactionCode");

define('_LOGIN_ROUTE_NAME', 'login_get');
define('_EMPLOYEE_START_PAGE', 'employee_overview');
define('_CUSTOMER_START_PAGE', 'overview');

define('_EMAIL', 'info@securebank.de');

define('_ACTION_APPROVE_TRANSACTION', 1);
define('_ACTION_REJECT_TRANSACTION', 2);

define('_ERROR_TRANSACTION_CLOSED', 'This transaction is already closed. Refresh the page to view latest data.');