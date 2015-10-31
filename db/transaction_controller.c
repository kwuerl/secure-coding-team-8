/*
 * Transaction Controller
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Performs required operations to process a customer transaction
 */
#include "repository.h"

static char *opt_host_name = "127.0.0.1"; /*server host*/
static char *opt_user_name = "root"; /*user name*/
static char *opt_password = "root"; /*password*/
static unsigned int opt_port_num = 3306; /*port number*/
static char *opt_db_name = "BANK_DETAILS"; /*database name*/

static MYSQL *db_connection; /*pointer to the database connection handler*/

int main(int argc, char *argv[]) {

	int customer_id;
	char *code;

	/*initialize connection handler*/
	db_connection = initializeDB();

	/*connect to the database*/
	connectToDB(db_connection, opt_host_name, opt_user_name, opt_password,
			opt_db_name, opt_port_num);

	customer_id = getCustomerId();
	code = getTransactionCode();

	makeTransfer(db_connection, customer_id, code);

	/*close the database connection*/
	closeDB(db_connection);

	/*exit from the program*/
	exit(EXIT_SUCCESS);
}
