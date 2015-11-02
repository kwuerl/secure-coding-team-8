#include <mysql/mysql.h>

my_bool processTransfer(int customerId, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks);