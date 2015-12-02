/*
 * Transaction Code Repository
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Handles database operations on the Transaction Code table
 */

#include "transactioncode_repo.h"
#define STRING_SIZE 256

MYSQL_BIND parameters[3], result[1]; /*input & output parameter buffers*/

int int_data[2]; /*input and output values*/
char str_data[STRING_SIZE];
int result_data[1];

unsigned long int_length[2];
unsigned long str_length;
unsigned long result_length;

my_bool isValidTransactionCode(MYSQL *connection, int customerId, char* code) {

	char* query;
	MYSQL_STMT *statement;
	int is_valid;

	query = "SELECT `ID` FROM `TBL_TRANSACTION_CODE` "
			"WHERE `CUSTOMER_ID` = ? AND `CODE` = ? AND `IS_USED` = ?";

	/*initialize the statement*/
	statement = initializeStatement(connection);

	/*prepare the statement*/
	prepareStatement(statement, query, strlen(query));

	/*parameter 1 - CUSTOMER_ID*/
	parameters[0].buffer_type = MYSQL_TYPE_LONG;
	parameters[0].buffer = (char *) &int_data[0];
	parameters[0].buffer_length = 2;
	parameters[0].is_null = 0;
	parameters[0].length = &int_length[0];

	/*parameter 2 - CODE*/
	parameters[1].buffer_type = MYSQL_TYPE_STRING;
	parameters[1].buffer = (char *) str_data;
	parameters[1].buffer_length = STRING_SIZE;
	parameters[1].is_null = 0;
	parameters[1].length = &str_length;

	/*parameter 3 - IS_USED*/
	parameters[2].buffer_type = MYSQL_TYPE_LONG;
	parameters[2].buffer = (char *) &int_data[1];
	parameters[2].buffer_length = 2;
	parameters[2].is_null = 0;
	parameters[2].length = &int_length[1];

	/*assign appropriate values to the result properties*/
	result[0].buffer_type = MYSQL_TYPE_LONG;
	result[0].buffer = result_data;
	result[0].buffer_length = 2;
	result[0].is_null = 0;
	result[0].length = &result_length;

	/*bind the parameters and result*/
	bindParameters(statement, parameters);
	bindResult(statement, result);

	/*assign values to the parameters*/
	int_data[0] = customerId;
	strncpy(str_data, code, STRING_SIZE);
	str_length = strlen(str_data);
	int_data[1] = 0;

	/*execute the statement*/
	executeStatement(statement);

	/*Check if the Transaction code exists*/
	if (mysql_stmt_fetch(statement) == 0) {
		is_valid = 1;
	} else {
		is_valid = 0;
	}

	/*deallocate the result set*/
	freeResult(statement);

	/*close the statement*/
	closeStatement(statement);

	return is_valid;
}

my_bool setIsUsedTransactionCode(MYSQL *connection, int customerId, char* code) {
	char* query;
	MYSQL_STMT *statement;
	my_bool result;

	query = "UPDATE `TBL_TRANSACTION_CODE` "
			"SET IS_USED = ? "
			"WHERE `CUSTOMER_ID` = ? AND `CODE` = ?";

	/*initialize the statement*/
	statement = initializeStatement(connection);

	if (statement) {
		/*prepare the statement*/
		result = prepareStatement(statement, query, strlen(query));

		if (result) {
			/*assign appropriate values to the parameter properties*/
			/*parameter 1 - IS_USED*/
			parameters[0].buffer_type = MYSQL_TYPE_LONG;
			parameters[0].buffer = (char *) &int_data[0];
			parameters[0].buffer_length = 2;
			parameters[0].is_null = 0;
			parameters[0].length = &int_length[0];

			/*parameter 2 - CUSTOMER_ID*/
			parameters[1].buffer_type = MYSQL_TYPE_LONG;
			parameters[1].buffer = (char *) &int_data[1];
			parameters[1].buffer_length = 2;
			parameters[1].is_null = 0;
			parameters[1].length = &int_length[1];

			/*parameter 3 - CODE*/
			parameters[2].buffer_type = MYSQL_TYPE_STRING;
			parameters[2].buffer = (char *) str_data;
			parameters[2].buffer_length = STRING_SIZE;
			parameters[2].is_null = 0;
			parameters[2].length = &str_length;

			/*bind the parameters and result*/
			result = bindParameters(statement, parameters);

			if (result) {
				/*assign values to the parameters*/
				int_data[0] = 1;
				strncpy(str_data, code, STRING_SIZE);
				str_length = strlen(str_data);
				int_data[1] = customerId;

				/*execute the statement*/
				result = executeStatement(statement);

				if (result) {

					/*deallocate the result set*/
					result = freeResult(statement);

					if (result) {
						/*close the statement*/
						result = closeStatement(statement);
						if (!result) {
							printf("Error in updating transaction code\n");
						}
						return result;
					} else {
						printf("Error in updating transaction code\n");
						return result;
					}
				} else {
					printf("Error in updating transaction code\n");
					return result;
				}
			} else {
				printf("Error in updating transaction code\n");
				return result;
			}
		} else {
			printf("Error in updating transaction code\n");
			return result;
		}
	} else {
		printf("Error in updating transaction code\n");
		return 0;
	}
}