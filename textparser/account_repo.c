/*
 * Account Repository
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Handles database operations on the Account table
 */

#include "account_repo.h"

my_bool isAccount(MYSQL* connection, int accountId) {
	char* query;
	MYSQL_STMT *statement;
	MYSQL_BIND parameter[1], result[1];
	int int_data;
	unsigned long int_length;
	int result_data[1];
	unsigned long result_length;
	my_bool is_exists;

	query = "SELECT `ID` FROM `TBL_ACCOUNT` "
				"WHERE `ACCOUNT_ID` = ?";

	/*initialize the statement*/
	statement = initializeStatement(connection);

	/*prepare the statement*/
	prepareStatement(statement, query, strlen(query));

	/*parameter 1 - ACCOUNT_ID*/
	parameter[0].buffer_type = MYSQL_TYPE_LONG;
	parameter[0].buffer = (char *) &int_data;
	parameter[0].buffer_length = 2;
	parameter[0].is_null = 0;
	parameter[0].length = &int_length;


	/*assign appropriate values to the result properties*/
	result[0].buffer_type = MYSQL_TYPE_LONG;
	result[0].buffer = result_data;
	result[0].buffer_length = 2;
	result[0].is_null = 0;
	result[0].length = &result_length;

	/*bind the parameters and result*/
	bindParameters(statement, parameter);
	bindResult(statement, result);

	/*assign values to the parameters*/
	int_data = accountId;

	/*execute the statement*/
	executeStatement(statement);

	storeResult(statement);

	/*Check if the account exists*/
	if (mysql_stmt_num_rows(statement) == 0) {
		is_exists = 0;
	} else {
		is_exists = 1;
	}

	/*deallocate the result set*/
	freeResult(statement);

	/*close the statement*/
	closeStatement(statement);

	return is_exists;

}
my_bool isBalanceSufficient(MYSQL* connection, int accountId, float amount) {
	char* query;
	MYSQL_STMT *statement;
	MYSQL_BIND parameter[2], result[2];
	int int_data;
	float float_data;
	unsigned long int_length, float_length, result_length[2];
	int id;
	float balance;
	my_bool is_balance_sufficient;

	query = "SELECT `ID` FROM `TBL_ACCOUNT` "
				"WHERE `ACCOUNT_ID` = ? AND `BALANCE` >= ?";

	/*initialize the statement*/
	statement = initializeStatement(connection);

	/*prepare the statement*/
	prepareStatement(statement, query, strlen(query));

	/*parameter 1 - ACCOUNT_ID*/
	parameter[0].buffer_type = MYSQL_TYPE_LONG;
	parameter[0].buffer = (char *) &int_data;
	parameter[0].buffer_length = 2;
	parameter[0].is_null = 0;
	parameter[0].length = &int_length;

	parameter[1].buffer_type = MYSQL_TYPE_FLOAT;
	parameter[1].buffer = (char *) &float_data;
	parameter[1].buffer_length = 2;
	parameter[1].is_null = 0;
	parameter[1].length = &float_length;

	/*assign appropriate values to the result properties*/
	result[0].buffer_type = MYSQL_TYPE_LONG;
	result[0].buffer = (char *) &id;
	result[0].buffer_length = 2;
	result[0].is_null = 0;
	result[0].length = &result_length;

	/*bind the parameters and result*/
	bindParameters(statement, parameter);
	bindResult(statement, result);

	/*assign values to the parameters*/
	int_data = accountId;
	float_data = amount;

	/*execute the statement*/
	executeStatement(statement);

	/*store the statement result*/
	storeResult(statement);

	/*Check if the account exists*/
	if (mysql_stmt_num_rows(statement) == 0) {
		is_balance_sufficient = 0;
	} else {
		is_balance_sufficient = 1;
	}

	/*deallocate the result set*/
	freeResult(statement);

	/*close the statement*/
	closeStatement(statement);

	return is_balance_sufficient;
}

my_bool updateAccountBalance(MYSQL* connection, int accountId, float amount,
		char* operation) {

	char* query;
	MYSQL_STMT *statement;
	MYSQL_BIND parameter[2];
	int int_data;
	float float_data;
	unsigned long length[2];
	my_bool result;

	if (strcmp(operation, "increment") == 0) {
		query = "UPDATE `TBL_ACCOUNT` "
				"SET BALANCE = BALANCE + ? "
				"WHERE `ACCOUNT_ID` = ?";
	} else if (strcmp(operation, "decrement") == 0) {
		query = "UPDATE `TBL_ACCOUNT` "
				"SET BALANCE = BALANCE - ? "
				"WHERE `ACCOUNT_ID` = ?";
	}

	/*initialize the statement*/
	statement = initializeStatement(connection);
	if (statement) {
		/*prepare the statement*/
		result = prepareStatement(statement, query, strlen(query));
		if (result) {
			/*assign appropriate values to the parameter properties*/
			/*parameter 1 - BALANCE*/
			parameter[0].buffer_type = MYSQL_TYPE_FLOAT;
			parameter[0].buffer = (char *) &float_data;
			parameter[0].buffer_length = 2;
			parameter[0].is_null = 0;
			parameter[0].length = &length[0];

			parameter[1].buffer_type = MYSQL_TYPE_LONG;
			parameter[1].buffer = (char *) &int_data;
			parameter[1].buffer_length = 2;
			parameter[1].is_null = 0;
			parameter[1].length = &length[1];

			/*bind the parameters and result*/
			result = bindParameters(statement, parameter);
			if (result) {
				/*assign values to the parameters*/
				float_data = amount;
				int_data = accountId;

				/*execute the statement*/
				result = executeStatement(statement);
				if (result) {
					/*deallocate the result set*/
					result = freeResult(statement);
					if (result) {
						/*close the statement*/
						result = closeStatement(statement);
						if (!result) {
							printf("Error in updating account balance.\n");
						}
						return result;
					} else {
						printf("Error in updating account balance.\n");
						return 0;
					}
				} else {
					printf("Error in updating account balance.\n");
					return 0;
				}
			} else {
				printf("Error in updating account balance.\n");
				return 0;
			}
		} else {
			printf("Error in updating account balance.\n");
			return 0;
		}
	} else {
		printf("Error in updating account balance.\n");
		return 0;
	}
	return 1;
}