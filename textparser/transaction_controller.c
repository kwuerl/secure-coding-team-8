/*
 * Transaction Controller
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Performs required operations to process a customer transaction
 */
#include "repository.h"
#include "transaction_repo.h"


static unsigned int opt_port_num = 3306; /*port number*/

static MYSQL *db_connection; /*pointer to the database connection handler*/

my_bool processTransfer(int customerId, char* customerName, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks, char *opt_host_name, char *opt_user_name, char *opt_password, char *opt_db_name) {

	my_bool result;

	/*initialize connection handler*/
	db_connection = initializeDB();

	/*connect to the database*/
	connectToDB(db_connection, opt_host_name, opt_user_name, opt_password,
			opt_db_name, opt_port_num);

	result = makeTransfer(db_connection, customerId, customerName, code, fromAccountId, toAccountId, toAccountName, amount, remarks);

	/*close the database connection*/
	closeDB(db_connection);

	return result;
}