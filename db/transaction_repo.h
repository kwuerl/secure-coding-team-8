#include "repository.h"

my_bool addTransaction(MYSQL *connection, int customerId, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks);
my_bool makeTransfer(MYSQL* connection, int customerId, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks);
