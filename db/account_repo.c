/*
 * Account Repository
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Handles database operations on the Account table
 */

#include "account_repo.h"

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
							printf("Error in updating account balance");
						}
						return result;
					} else {
						printf("Error in updating account balance");
						return 0;
					}
				} else {
					printf("Error in updating account balance");
					return 0;
				}
			} else {
				printf("Error in updating account balance");
				return 0;
			}
		} else {
			printf("Error in updating account balance");
			return 0;
		}
	} else {
		printf("Error in updating account balance");
		return 0;
	}
	return 1;
}