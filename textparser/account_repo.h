#include "repository.h"

my_bool isAccount(MYSQL* connection, int accountId);
my_bool isBalanceSufficient(MYSQL* connection, int accountId, float amount);
my_bool updateAccountBalance(MYSQL* connection, int accountId, float amount, char* operation);