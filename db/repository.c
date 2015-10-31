/*
 * Repository
 *
 * Author: Swathi Shyam Sunder<swathi.ssunder@tum.de>
 */

/*
 * Consists of common functions required to interact with the database.
 */

#include "repository.h"
#define STRING_SIZE 256

MYSQL* initializeDB() {
	MYSQL *connection = mysql_init(NULL);
	if (connection == NULL) {
		fprintf(stderr, "Error in connecting to the database.\n");
		exit(EXIT_FAILURE);
	}
	return connection;
}

void connectToDB(MYSQL *connection, char* host, char* user, char* password,
		char* dbName, int port) {
	/* connect to server */
	if (mysql_real_connect(connection, host, user, password, dbName, port, NULL,
			0) == NULL) {
		fprintf(stderr, "Error in connecting to the database.\n");
		mysql_close(connection);
		exit(EXIT_FAILURE);
	}
}

void closeDB(MYSQL *connection) {
	mysql_close(connection);
}

MYSQL_STMT* initializeStatement(MYSQL *connection) {
	/* Initialize our statement */
	MYSQL_STMT * statement = mysql_stmt_init(connection);
	if (!statement) {
		fprintf(stderr, "Error in initializing the query statement.\n");
		return 0;
	}
	return statement;
}

my_bool prepareStatement(MYSQL_STMT *statement, char* query, int queryLength) {
	if (mysql_stmt_prepare(statement, query, queryLength)) {
		fprintf(stderr, "Error in preparing the query statement.\n");
		fprintf(stderr, " %s\n", mysql_stmt_error(statement));
		return 0;
	}
	return 1;
}

/*TODO Not working as expected when invoked*/
void initializeParameters(char** parameterTypes, MYSQL_BIND* parameter,
		int parameterCount) {
	int i;
	unsigned long parameter_length[parameterCount];

	/*printf("\nin init params");*/
	for (i = 0; i < parameterCount; i++) {

		if (strcmp(parameterTypes[i], "int") == 0) {
			int data;
			parameter[i].buffer_type = MYSQL_TYPE_LONG;
			parameter[i].buffer_length = 2;
			parameter[i].buffer = (char *) &data;
		} else if (strcmp(parameterTypes[i], "string") == 0) {
			char data[STRING_SIZE];
			parameter[i].buffer_type = MYSQL_TYPE_STRING;
			parameter[i].buffer_length = STRING_SIZE;
			parameter[i].buffer = (char *) data;
		}
		parameter[i].is_null = 0;
		parameter[i].length = &parameter_length[i];
	}
}

my_bool bindParameters(MYSQL_STMT *statement, MYSQL_BIND *parameters) {
	/* Bind the parameters buffer */
	if (mysql_stmt_bind_param(statement, parameters)) {
		fprintf(stderr, "Error in binding query parameters.\n");
		fprintf(stderr, " %s\n", mysql_stmt_error(statement));
		return 0;
	}
	return 1;
}

my_bool bindResult(MYSQL_STMT *statement, MYSQL_BIND *result) {
	/* Bind the result buffer */
	if (mysql_stmt_bind_result(statement, result) != 0) {
		fprintf(stderr, "Error in binding query result.\n");
		fprintf(stderr, " %s\n", mysql_stmt_error(statement));
		return 0;
	}
	return 1;
}

my_bool executeStatement(MYSQL_STMT *statement) {
	/* Execute the statement */
	if (mysql_stmt_execute(statement)) {
		fprintf(stderr, "Error in executing query.\n");
		fprintf(stderr, " %s\n", mysql_stmt_error(statement));
		fprintf(stderr, "Error in executing query.\n");
		return 0;
	}
	return 1;
}

my_bool freeResult(MYSQL_STMT *statement) {
	/*Deallocate the result set*/
	if (mysql_stmt_free_result(statement)) {
		fprintf(stderr, "Error in freeing the query result.\n");
		fprintf(stderr, " %s\n", mysql_stmt_error(statement));
		return 0;
	}
	return 1;
}
my_bool closeStatement(MYSQL_STMT *statement) {
	/* Close the statement */
	if (mysql_stmt_close(statement)) {
		fprintf(stderr, "Error in closing the query statement.\n");
		fprintf(stderr, " %s\n", mysql_stmt_error(statement));
		return 0;
	}
	return 1;
}

void getCurrentDateTime(int* year, int* month, int* day, int* hour, int* minute, int* second) {
	struct tm *current;
	time_t timenow;
	time(&timenow);
	current = localtime(&timenow);
	*year = current->tm_year + 1900;
	*month = current->tm_mon + 1;
	*day = current->tm_mday;
	*hour = current->tm_hour;
	*minute = current->tm_min;
	*second = current->tm_sec;
	return;
}
