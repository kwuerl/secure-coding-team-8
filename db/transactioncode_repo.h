#include "repository.h"

int getCustomerId();
char* getTransactionCode();
my_bool isValidTransactionCode(MYSQL *connection, int customerId, char* code);
my_bool setIsUsedTransactionCode(MYSQL *connection, int customerId, char* code);
