#include "repository.h"

my_bool addTransaction(MYSQL *connection, int customerId);
my_bool makeTransfer(MYSQL* connection, int customerId, char* code);