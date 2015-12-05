#include <mysql/mysql.h>

my_bool processTransfer(int customerId, char* customerName, char* code, int fromAccountId,
		int toAccountId, char* toAccountName, float amount, char* remarks, char *opt_host_name, char *opt_user_name, char *opt_password, char *opt_db_name );