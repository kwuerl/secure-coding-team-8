/*
 * Transaction Repository
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Handles database operations on the Transaction table
 */

#include "transaction_repo.h"
#include "transactioncode_repo.h"
#include "account_repo.h"

#define STRING_SIZE 256

MYSQL_BIND parameters[9], result[1]; /*input & output parameter buffers*/

int int_data[5]; /*input and output values*/
char str_data[4][STRING_SIZE];
float float_data[1];
int result_data[1];
MYSQL_TIME current_time;

unsigned long int_length[9], result_length;

my_bool addTransaction(MYSQL *connection, int customerId, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks) {

	char* query;
	MYSQL_STMT *statement;
	my_bool result;

	int is_on_hold = (amount > 10000) ? 1 : 0;
	int is_rejected = 0;
	int is_closed = 0;

	query =
			"INSERT INTO `TBL_TRANSACTION`("
					"`TRANSACTION_DATE`, `FROM_ACCOUNT_ID`, `TO_ACCOUNT_ID`, `TO_ACCOUNT_NAME`,"
					"`AMOUNT`, `REMARKS`, `IS_ON_HOLD`, `IS_REJECTED`, `IS_CLOSED`) VALUES("
					"?, ?, ?, ?, ?, ?, ?, ?, ?)";

	/*initialize the statement*/
	statement = initializeStatement(connection);
	if (statement) {
		/*prepare the statement*/
		result = prepareStatement(statement, query, strlen(query));

		if (result) {
			parameters[0].buffer_type = MYSQL_TYPE_DATETIME;
			parameters[0].buffer = (char *) &current_time;
			parameters[0].buffer_length = 2;
			parameters[0].is_null = 0;
			parameters[0].length = &int_length[1];

			parameters[1].buffer_type = MYSQL_TYPE_LONG;
			parameters[1].buffer = (char *) &int_data[0];
			parameters[1].buffer_length = 2;
			parameters[1].is_null = 0;
			parameters[1].length = &int_length[1];

			parameters[2].buffer_type = MYSQL_TYPE_LONG;
			parameters[2].buffer = (char *) &int_data[1];
			parameters[2].buffer_length = 2;
			parameters[2].is_null = 0;
			parameters[2].length = &int_length[2];

			parameters[3].buffer_type = MYSQL_TYPE_STRING;
			parameters[3].buffer = (char *) str_data[1];
			parameters[3].buffer_length = STRING_SIZE;
			parameters[3].is_null = 0;
			parameters[3].length = &int_length[3];

			parameters[4].buffer_type = MYSQL_TYPE_FLOAT;
			parameters[4].buffer = (char *) &float_data[0];
			parameters[4].buffer_length = 2;
			parameters[4].is_null = 0;
			parameters[4].length = &int_length[4];

			parameters[5].buffer_type = MYSQL_TYPE_STRING;
			parameters[5].buffer = (char *) str_data[3];
			parameters[5].buffer_length = STRING_SIZE;
			parameters[5].is_null = 0;
			parameters[5].length = &int_length[5];

			parameters[6].buffer_type = MYSQL_TYPE_TINY;
			parameters[6].buffer = (char *) &int_data[2];
			parameters[6].buffer_length = 2;
			parameters[6].is_null = 0;
			parameters[6].length = &int_length[6];

			parameters[7].buffer_type = MYSQL_TYPE_TINY;
			parameters[7].buffer = (char *) &int_data[3];
			parameters[7].buffer_length = 2;
			parameters[7].is_null = 0;
			parameters[7].length = &int_length[7];

			parameters[8].buffer_type = MYSQL_TYPE_TINY;
			parameters[8].buffer = (char *) &int_data[4];
			parameters[8].buffer_length = 2;
			parameters[8].is_null = 0;
			parameters[8].length = &int_length[8];

			/*bind the parameters and result*/
			result = bindParameters(statement, parameters);

			if (result) {
				int_data[0] = fromAccountId;
				int_data[1] = toAccountId;
				int_data[2] = is_on_hold;
				int_data[3] = is_rejected;
				int_data[4] = is_closed;

				strcpy(str_data[1], toAccountName);
				int_length[3] = strlen(str_data[1]);
				float_data[0] = amount;
				strcpy(str_data[3], remarks);
				int_length[5] = strlen(str_data[3]);

				/*set the current date-time in the time-stamp structure*/
				getCurrentDateTime(&current_time.year, &current_time.month,
						&current_time.day, &current_time.hour,
						&current_time.minute, &current_time.second);

				/*execute the statement*/
				result = executeStatement(statement);
				if (result) {
					/*deallocate the result set*/
					result = freeResult(statement);
					if (result) {
						/*close the statement*/
						result = closeStatement(statement);
						if (result) {
							if (!is_on_hold) {
								result = updateAccountBalance(connection,
										fromAccountId, amount, "decrement");

								if (result) {
									updateAccountBalance(connection,
											toAccountId, amount, "increment");
								} else {
									printf("Error in adding transaction");
									return result;
								}
							}
						} else {
							printf("Error in adding transaction");
							return result;
						}
					} else {
						printf("Error in adding transaction");
						return result;
					}
				} else {
					printf("Error in adding transaction");
					return result;
				}
			} else {
				printf("Error in adding transaction");
				return result;
			}
		} else {
			printf("Error in adding transaction");
			return result;
		}
	} else {
		printf("Error in adding transaction");
		return 0;
	}
	return 1;
}

my_bool makeTransfer(MYSQL* connection, int customerId, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks) {
	mysql_autocommit(connection, 0);
	if (isValidTransactionCode(connection, customerId, code)) {
		if (setIsUsedTransactionCode(connection, customerId, code)) {
			if (addTransaction(connection, customerId, fromAccountId, toAccountId, toAccountName, amount, remarks)) {
				mysql_commit(connection);
			} else {
				printf("Error in adding transaction.");
				mysql_rollback(connection);
				return 0;
			}
		} else {
			printf("Error in updating transaction code.");
			mysql_rollback(connection);
			return 0;
		}
	} else {
		printf("Incorrect transaction code.");
		mysql_rollback(connection);
		return 0;
	}
	return 1;
}
