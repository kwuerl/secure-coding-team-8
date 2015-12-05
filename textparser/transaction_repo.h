#include "repository.h"

my_bool addTransaction(MYSQL *connection, int customerId, char* customerName, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks);
my_bool makeTransfer(MYSQL* connection, int customerId, char* customerName, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks);
