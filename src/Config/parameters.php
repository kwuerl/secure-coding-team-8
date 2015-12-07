<?php
/**
 * Definition of constants used in the application.
 *
 * @author Swathi Shyam Sunder <swathi.ssunder@tum.de>
 * @author Mai Ton Nu Cam <maitonnucam@googlemail.com>
 * @author Vivek Sethia <vivek.sethia@tum.de>
 */

define('_EXAMPLE_PARAM', 'EXAMPLE_VALUE');
define('_DB_SECURE_BANK', 'BANK_DETAILS');

define('_DB_SERVER', 'mysql');
define('_MYSQL_HOST', '127.0.0.1');
define('_MYSQL_USER', 'root');
define('_MYSQL_PASSWORD', 'samurai');
define('_MYSQL_DATABASE', _DB_SECURE_BANK);

define('_TBL_CUSTOMER', 'TBL_CUSTOMER');
define('_TBL_EMPLOYEE', 'TBL_EMPLOYEE');
define('_TBL_ACCOUNT', 'TBL_ACCOUNT');
define('_TBL_TRANSACTION', 'TBL_TRANSACTION');
define('_TBL_TRANSACTION_CODE', 'TBL_TRANSACTION_CODE');
define('_TBL_SCS', 'TBL_SCS');

define('_GROUP_USER', 'USER');
define('_GROUP_EMPLOYEE', 'EMPLOYEE');
define('_GROUP_ADMIN', 'ADMIN');

define('_CLASS_MODEL_USER', "\Model\User");
define('_CLASS_MODEL_CUSTOMER', "\Model\Customer");
define('_CLASS_MODEL_EMPLOYEE', "\Model\Employee");
define('_CLASS_MODEL_ACCOUNT', "\Model\Account");
define('_CLASS_MODEL_TRANSACTION', "\Model\Transaction");
define('_CLASS_MODEL_TRANSACTION_CODE', "\Model\TransactionCode");
define('_CLASS_MODEL_SCS', "\Model\SCS");

define('_LOGIN_ROUTE_NAME', 'login_get');
define('_EMPLOYEE_START_PAGE', 'employee_overview');
define('_CUSTOMER_START_PAGE', 'overview');

define('_EMAIL', 'securebank15@gmail.com');

define('_ACTION_APPROVE', 1);
define('_ACTION_REJECT', 2);
define('_ACTION_SET_BALANCE', 3);

define('_OPERATION_SUCCESS', 'Operation successful');
define('_OPERATION_FAILURE', 'Operation failed!');

define('_ERROR_TRANSACTION_CLOSED', 'This transaction is already closed.');
define('_ERROR_REGISTRATION_CLOSED', 'This registration is already closed.');

define('_TRANSFER_LIMIT_FOR_AUTO_APPROVAL', 10000);
define('_MAX_ALLOWED_BALANCE_INITIALIZATION', 50000);

define('_TRANSACTIONS_PER_PAGE', 5);
define('_NO_LIMIT', 0);
define('_TRANSACTION_HISTORY', 100);
define('_STATEMENT', 101);
define('_CUSTOMER_DETAILS_PENDING_TRANSACTION', 102);
define('_CUSTOMER_DETAILS_COMPLETED_TRANSACTION', 103);
define('_PENDING_TRANSACTIONS', 104);
define('_COMPLETED_TRANSACTIONS', 105);


define('ACCOUNT_ID_PREFIX', 1000000000);

define('_TOKEN_VALID_TIME', 30);
define('_LOCKED_TIME', 60);

define('_TAN_METHOD_EMAIL', 1);
define('_TAN_METHOD_SCS', 2);
