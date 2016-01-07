#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <mysql/mysql.h>

int read_line(char **arg1, FILE *arg2) {
	size_t n = 0;
	return getline(arg1, &n, arg2);
}

int mysql_initialization(MYSQL *connection) {
	connection = mysql_init(NULL);
	if (connection == NULL) {
		printf("Could not establish connection to database\n");
		return 1;
	}
	mysql_real_connect(connection, "localhost", "root", "samurai", "TumBank", 0, NULL, 0);
	return 0;
}

int mysql_delete(MYSQL *connection) {
	mysql_close(connection);
	return 0;
}

int mysql_query_function(MYSQL *mysql_connection, char *payer_id, void *receiver_name, char *amount, void *comment, char *code) {
	double amount_double = strtod(amount, NULL);
	double cmp1 = 0.0001;
	if(amount_double < cmp1) {
		printf("Negative transactions not allowed");
		return 1;
	} else {
		char *query_balance = "SELECT balance FROM user WHERE id = ";
		int int0 = 0;
		int0 += strlen(payer_id);
		int0 += strlen(query_balance);
		int0 += 5;
		char *query_balance_final = (char*) malloc(int0);
		strcpy(query_balance_final, query_balance);
		strcat(query_balance_final, payer_id);
		mysql_query(mysql_connection, query_balance_final);
		MYSQL_RES *result_balance = mysql_store_result(mysql_connection);
		MYSQL_ROW balance_row = mysql_fetch_row(result_balance);
		char* balance_field = balance_row[0];
		double cmp2 = strtod(balance_field, NULL);
		if(cmp2<amount_double) {
			printf("Not enough money in your account");
			return 1;
		} else {
			char *select_code_query_1 = "SELECT code FROM trancode WHERE clientid = ";
			char *select_code_query_2 = " AND code = \"";
			int0 = 0;
			int0 += strlen(payer_id);
			int0 += strlen(select_code_query_1);
			int0 += strlen(select_code_query_2);
			int0 += strlen(code);
			int0 += 50;
			char *select_code_query_final = (char*) malloc(int0);
			strcpy(select_code_query_final, select_code_query_1);
			strcat(select_code_query_final, payer_id);
			strcat(select_code_query_final, select_code_query_2);
			strcat(select_code_query_final, code);
			strcat(select_code_query_final, "\"");
			mysql_query(mysql_connection, select_code_query_final);
			MYSQL_RES *result_code = mysql_store_result(mysql_connection);
			MYSQL_ROW row_code = mysql_fetch_row(result_code);
			if (row_code == NULL) {
				printf("TAN not found: %s", code);
				return 1;
			} else {
				char* code1;
				strcpy(code1,(char *) row_code[0]);
				mysql_free_result(result_code);
				char *select_payment_by_code = (char*) malloc(128);
				sprintf(select_payment_by_code,"SELECT id FROM payment WHERE trancode = '%s';",code1);
				mysql_query(mysql_connection, select_payment_by_code);
				result_code = mysql_store_result(mysql_connection);
				row_code = mysql_fetch_row(result_code);
				if (row_code != NULL) {
					printf("TAN Invalid: %s", code);
					return 1;
				} else {
					mysql_free_result(result_code);
					free(select_payment_by_code);
					char *select_paymentrequest_by_code = (char*) malloc(128);
					sprintf(select_paymentrequest_by_code, "SELECT id FROM paymentrequest WHERE trancode = '%s';",code1);
					mysql_query(mysql_connection, select_paymentrequest_by_code);
					result_code = mysql_store_result(mysql_connection);
					row_code = mysql_fetch_row(result_code);
					if (row_code != NULL) {
						printf("TAN Invalid: %s", code);
						return 1;
					} else {
						mysql_free_result(result_code);
						free(select_paymentrequest_by_code);
						char *select_balance_receiver_query = "SELECT balance FROM user WHERE username = \"";
						int0 = 0;
						int0 += strlen(select_balance_receiver_query);
						int0 += strlen(receiver_name);
						int0 += 5;
						char *select_balance_receiver_query_final = (char*) malloc(int0);
						strcpy(select_balance_receiver_query_final, select_balance_receiver_query);
						strcat(select_balance_receiver_query_final, receiver_name);
						strcat(select_balance_receiver_query_final, "\"");
						mysql_query(mysql_connection, select_balance_receiver_query_final);
						MYSQL_RES *result_balance_receiver = mysql_store_result(mysql_connection);
						MYSQL_ROW balance_receiver_row = mysql_fetch_row(result_balance_receiver);
						if (balance_receiver_row == NULL) {
							printf("Receiver not found: %s", receiver_name);
							return 1;
						} else {
							if (amount_double < 10000) {
								double balance_receiver = strtod(balance_receiver_row[0],NULL);
								char *receiver_new_balance;
								sprintf(receiver_new_balance,"%.2lf", amount_double + balance_receiver);
								char *update_receiver_balance_query_1 = "UPDATE user SET balance = ";
								char *update_receiver_balance_query_2 = " WHERE username = \"";
								int0 = 0;
								int0 += strlen(update_receiver_balance_query_1);
								int0 += strlen(receiver_new_balance);
								int0 += strlen(update_receiver_balance_query_2);
								int0 += strlen(receiver_name);
								int0 += 5;
								char *update_receiver_balance_query_final = (char*) malloc(int0);
								strcpy(update_receiver_balance_query_final, update_receiver_balance_query_1);
								strcat(update_receiver_balance_query_final, receiver_new_balance);
								strcat(update_receiver_balance_query_final, update_receiver_balance_query_2);
								strcat(update_receiver_balance_query_final, receiver_name);
								strcat(update_receiver_balance_query_final, "\"");
								mysql_query(mysql_connection, update_receiver_balance_query_final);

								char *update_payer_balance_query_2 = " WHERE id = ";
								char *payer_new_balance;
								sprintf(payer_new_balance,"%.2lf", cmp2 - amount_double);
								int0 = 0;
								int0 += strlen(update_receiver_balance_query_1);
								int0 += strlen(payer_new_balance);
								int0 += strlen(update_payer_balance_query_2);
								int0 += strlen(payer_id);
								int0 += 5;
								char *update_payer_balance_query_final = (char*) malloc(int0);
								strcpy(update_payer_balance_query_final, update_receiver_balance_query_1);
								strcat(update_payer_balance_query_final, payer_new_balance);
								strcat(update_payer_balance_query_final, update_payer_balance_query_2);
								strcat(update_payer_balance_query_final, payer_id);
								mysql_query(mysql_connection, update_payer_balance_query_final);
								
								char *insert_payment_query = "INSERT INTO payment (trancode, payer, receipt, amount, purpose, createdate) VALUES('";
								int0 = 0;
								int0 += strlen(insert_payment_query);
								int0 += strlen(code1);
								int0 += strlen(payer_id);
								int0 += strlen(receiver_name);
								int0 += strlen(amount);
								int0 += strlen(comment);
								int0 += 50;
								char *insert_payment_query_final = (char*) malloc(int0);
								strcpy(insert_payment_query_final, insert_payment_query);
								strcat(insert_payment_query_final, code1);
								strcat(insert_payment_query_final, "', ");
								strcat(insert_payment_query_final, payer_id);
								strcat(insert_payment_query_final, ", \"");
								strcat(insert_payment_query_final, receiver_name);
								strcat(insert_payment_query_final, "\", ");
								strcat(insert_payment_query_final, amount);
								strcat(insert_payment_query_final, ", \"");
								strcat(insert_payment_query_final, comment);
								strcat(insert_payment_query_final, "\", ");
								strcat(insert_payment_query_final, "NOW())");
								mysql_query(mysql_connection, insert_payment_query_final);
								free(insert_payment_query_final);
								free(update_payer_balance_query_final);
								free(update_receiver_balance_query_final);
							} else {
								char *inser_paymentrequest_query = "INSERT INTO paymentrequest (payer, trancode, receipt, amount, purpose, createdate) VALUES(";
								int0 = 0;
								int0 += strlen(inser_paymentrequest_query);
								int0 += strlen(code1);
								int0 += strlen(payer_id);
								int0 += strlen(receiver_name);
								int0 += strlen(amount);
								int0 += strlen(comment);
								int0 += 50;
								char *inser_paymentrequest_query_final = (char*) malloc(int0);
								strcpy(inser_paymentrequest_query_final, inser_paymentrequest_query);
								strcat(inser_paymentrequest_query_final, payer_id);
								strcat(inser_paymentrequest_query_final, ", '");
								strcat(inser_paymentrequest_query_final, code1);
								strcat(inser_paymentrequest_query_final, "', \"");
								strcat(inser_paymentrequest_query_final, receiver_name);
								strcat(inser_paymentrequest_query_final, "\", ");
								strcat(inser_paymentrequest_query_final, amount);
								strcat(inser_paymentrequest_query_final, ", \"");
								strcat(inser_paymentrequest_query_final, comment);
								strcat(inser_paymentrequest_query_final, "\", ");
								strcat(inser_paymentrequest_query_final, "NOW())");
								mysql_query(mysql_connection, inser_paymentrequest_query_final);
								free(inser_paymentrequest_query_final);
							}
							free(query_balance_final);
							free(select_balance_receiver_query);
							free(select_code_query_final);
							mysql_free_result(result_balance_receiver);
						  
							mysql_free_result(result_balance);
						}
					}
				}
			}
		}
	}
	
}

int main(int argc, char **argv) {
	FILE *fp = fopen(argv[2], "r");
	if (fp == NULL) {
		puts("File not found");
		return 1;
	}

	MYSQL *connection;
	mysql_initialization(connection);

	ssize_t eax;

	while (1) {
		// username
		char *username = NULL;
		eax = read_line(&username, fp);
		if (eax <= 0) {
			puts("Invalid form");
			return 1;
		}
		username[strlen(username) - 1] = '\0';

		// amount
		char *amount = NULL;
		eax = read_line(&amount, fp);
		if (eax <= 0) {
			puts("Invalid form");
			return 1;
		}
		amount[strlen(amount) - 1] = '\0';

		// tancode
		char *tancode = NULL;
		eax = read_line(&tancode, fp);
		if (eax <= 0) {
			puts("Invalid form");
			return 1;
		}
		tancode[strlen(tancode) - 1] = '\0';

		// comment
		char *comment = NULL;
		eax = read_line(&comment, fp);
		if (eax <= 0) {
			puts("Invalid form");
			return 1;
		}
		comment[strlen(comment) - 1] = '\0';

		// empty line for new transaction
		char *emptyline = NULL;
		eax = read_line(&emptyline, fp);
		emptyline[strlen(emptyline) - 1] = '\0';

		int mqf = mysql_query_function(connection, argv[1], username, amount, comment, tancode);
		if (mqf != 0) {
			return 1;
		}

		free(username);
		free(amount);
		free(tancode);
		free(comment);
		free(emptyline);

		if (eax <= 0) {
			break;
		}
	}
	
	printf("Operation successful");
	fclose(fp);
	//mysql_delete(connection);
	return 0;
}