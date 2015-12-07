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

MYSQL_BIND parameters[10], result[1]; /*input & output parameter buffers*/

int int_data[5]; /*input and output values*/
char str_data[3][STRING_SIZE];
float float_data[1];
int result_data[1];
MYSQL_TIME current_time;

unsigned long parameter_length[10], result_length;

my_bool addTransaction(MYSQL *connection, int customerId, char* customerName, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks) {

	char* query;
	MYSQL_STMT *statement;
	my_bool result;

	int is_on_hold = (amount > 10000) ? 1 : 0;
	int is_rejected = 0;
	int is_closed = (amount > 10000) ? 0 : 1;

	query =
			"INSERT INTO `TBL_TRANSACTION`("
					"`TRANSACTION_DATE`, `FROM_ACCOUNT_ID`, `FROM_ACCOUNT_NAME`, `TO_ACCOUNT_ID`, `TO_ACCOUNT_NAME`,"
					"`AMOUNT`, `REMARKS`, `IS_ON_HOLD`, `IS_REJECTED`, `IS_CLOSED`) VALUES("
					"?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	/*initialize the statement*/
	statement = initializeStatement(connection);
	if (statement) {
		/*prepare the statement*/
		result = prepareStatement(statement, query, strlen(query));

		if (result) {
			/*Parameter 1 - TRANSACTION_DATE*/
			parameters[0].buffer_type = MYSQL_TYPE_DATETIME;
			parameters[0].buffer = (char *) &current_time;
			parameters[0].buffer_length = 2;
			parameters[0].is_null = 0;
			parameters[0].length = &parameter_length[0];

			/*Parameter 2 - FROM_ACCOUNT_ID*/
			parameters[1].buffer_type = MYSQL_TYPE_LONG;
			parameters[1].buffer = (char *) &int_data[0];
			parameters[1].buffer_length = 2;
			parameters[1].is_null = 0;
			parameters[1].length = &parameter_length[1];

			/*Parameter 3 - FROM_ACCOUNT_NAME*/
			parameters[2].buffer_type = MYSQL_TYPE_STRING;
			parameters[2].buffer = (char *) str_data[0];
			parameters[2].buffer_length = STRING_SIZE;
			parameters[2].is_null = 0;
			parameters[2].length = &parameter_length[2];

			/*Parameter 4 - TO_ACCOUNT_ID*/
			parameters[3].buffer_type = MYSQL_TYPE_LONG;
			parameters[3].buffer = (char *) &int_data[1];
			parameters[3].buffer_length = 2;
			parameters[3].is_null = 0;
			parameters[3].length = &parameter_length[3];

			/*Parameter 5 - TO_ACCOUNT_NAME*/
			parameters[4].buffer_type = MYSQL_TYPE_STRING;
			parameters[4].buffer = (char *) str_data[1];
			parameters[4].buffer_length = STRING_SIZE;
			parameters[4].is_null = 0;
			parameters[4].length = &parameter_length[4];

			/*Parameter 6 - AMOUNT*/
			parameters[5].buffer_type = MYSQL_TYPE_FLOAT;
			parameters[5].buffer = (char *) &float_data[0];
			parameters[5].buffer_length = 2;
			parameters[5].is_null = 0;
			parameters[5].length = &parameter_length[5];

			/*Parameter 7 - REMARKS*/
			parameters[6].buffer_type = MYSQL_TYPE_STRING;
			parameters[6].buffer = (char *) str_data[2];
			parameters[6].buffer_length = STRING_SIZE;
			parameters[6].is_null = 0;
			parameters[6].length = &parameter_length[6];

			/*Parameter 8 - IS_ON_HOLD*/
			parameters[7].buffer_type = MYSQL_TYPE_TINY;
			parameters[7].buffer = (char *) &int_data[2];
			parameters[7].buffer_length = 2;
			parameters[7].is_null = 0;
			parameters[7].length = &parameter_length[7];

			/*Parameter 9 - IS_REJECTED*/
			parameters[8].buffer_type = MYSQL_TYPE_TINY;
			parameters[8].buffer = (char *) &int_data[3];
			parameters[8].buffer_length = 2;
			parameters[8].is_null = 0;
			parameters[8].length = &parameter_length[8];

			/*Parameter 10 - IS_CLOSED*/
			parameters[9].buffer_type = MYSQL_TYPE_TINY;
			parameters[9].buffer = (char *) &int_data[4];
			parameters[9].buffer_length = 2;
			parameters[9].is_null = 0;
			parameters[9].length = &parameter_length[9];

			/*bind the parameters and result*/
			result = bindParameters(statement, parameters);

			if (result) {
				int_data[0] = fromAccountId;
				int_data[1] = toAccountId;
				int_data[2] = is_on_hold;
				int_data[3] = is_rejected;
				int_data[4] = is_closed;

				strcpy(str_data[0], customerName);
				parameter_length[2] = strlen(str_data[0]);
				strcpy(str_data[1], toAccountName);
				parameter_length[4] = strlen(str_data[1]);
				strcpy(str_data[2], remarks);
				parameter_length[6] = strlen(str_data[2]);
				float_data[0] = amount;

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

my_bool makeTransfer(MYSQL* connection, int customerId, char* customerName, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks) {

	/*Check for valid amount i.e., restrict 0 or negative amounts*/
	if (amount <= 0) {
		printf("Incorrect amount for the transfer.\n");
		return 0;
	}
	/*Check if recipient account is same as own account*/
	if (fromAccountId == toAccountId) {
		printf("Recipient Account same as own account.\n");
		return 0;
	}
	/*Check for non-existent recipient account*/
	if (!isAccount(connection, toAccountId)) {
		printf("Recipient Account does not exist.\n");
		return 0;
	}
	/*Check for insufficient funds*/
	if (!isBalanceSufficient(connection, fromAccountId, amount)) {
		printf("Insufficient funds for the transfer.\n");
		return 0;
	}

	mysql_autocommit(connection, 0);
	if (setIsUsedTransactionCode(connection, customerId, code)) {
		if (addTransaction(connection, customerId, customerName, fromAccountId, toAccountId, toAccountName, amount, remarks)) {
			mysql_commit(connection);
		} else {
			printf("Error in adding transaction.\n");
			mysql_rollback(connection);
			return 0;
		}
	} else {
		printf("Error in updating TAN (transaction code).\n");
		mysql_rollback(connection);
		return 0;
	}
	printf("Transaction was processed successfully. \n");
	return 1;
}