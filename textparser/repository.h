#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <mysql/mysql.h>

MYSQL* initializeDB();
void closeDB(MYSQL *connection);
void connectToDB(MYSQL *connection, char* host, char* user, char* password,
		char* dbName, int port);
MYSQL_STMT* initializeStatement(MYSQL *connection);
my_bool prepareStatement(MYSQL_STMT *statement, char* query, int queryLength);
my_bool bindParameters(MYSQL_STMT *statement, MYSQL_BIND *parameter);
my_bool bindResult(MYSQL_STMT *statement, MYSQL_BIND *result);
my_bool executeStatement(MYSQL_STMT *statement);
my_bool storeResult(MYSQL_STMT *statement);
my_bool freeResult(MYSQL_STMT *statement);
my_bool closeStatement(MYSQL_STMT *statement);
void getCurrentDateTime(int* year, int* month, int* day, int* hour, int* minute, int* second);