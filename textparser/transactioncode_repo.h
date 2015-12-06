#include "repository.h"

my_bool isValidTransactionCode(MYSQL *connection, int customerId, char* code);
my_bool addTransactionCode(MYSQL *connection, int customerId, char* code);
my_bool setIsUsedTransactionCode(MYSQL *connection, int customerId, char* code);