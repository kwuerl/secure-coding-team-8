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
		if(cmp2<cmp2) {
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
			mysql_query(mysql_connection, query_select_trancode_final);
			MYSQL_RES *result_code = mysql_store_result(mysql_connection);
			MYSQL_ROW row_code = mysql_fetch_row(result_code);
			if (row_code == NULL) {
				printf("TAN not found: %s", code);
				return 1;
			} else {
				char* code1;
				strcpy(code1,(char *) row_tan[0]);
				mysql_free_result(result_code);
				char *select_payment_by_code = (char*) malloc(128);
				sprintf(select_payment_by_code,"SELECT id FROM payment WHERE trancode = '%s';",code1);
				mysql_query(mysql_connection, select_payment_by_code);
				result_code = mysql_store_result(mysql_connection);
				row_code = mysql_fetch_row(result_tan);
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
						if (row == NULL) {
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
								sprintf(payer_new_balance,"%.2lf", amount_payer - amount_double);
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
								strcpy(query_insert_payment_final, insert_payment_query);
								strcat(query_insert_payment_final, code1);
								strcat(query_insert_payment_final, "', ");
								strcat(query_insert_payment_final, payer_id);
								strcat(query_insert_payment_final, ", \"");
								strcat(query_insert_payment_final, receiver_name);
								strcat(query_insert_payment_final, "\", ");
								strcat(query_insert_payment_final, amount);
								strcat(query_insert_payment_final, ", \"");
								strcat(query_insert_payment_final, comment);
								strcat(query_insert_payment_final, "\", ");
								strcat(query_insert_payment_final, "NOW())");
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
								strcat(inser_paymentrequest_query_final, payer);
								strcat(inser_paymentrequest_query_final, ", '");
								strcat(inser_paymentrequest_query_final, trancode);
								strcat(inser_paymentrequest_query_final, "', \"");
								strcat(inser_paymentrequest_query_final, receipt);
								strcat(inser_paymentrequest_query_final, "\", ");
								strcat(inser_paymentrequest_query_final, amount);
								strcat(inser_paymentrequest_query_final, ", \"");
								strcat(inser_paymentrequest_query_final, comment);
								strcat(inser_paymentrequest_query_final, "\", ");
								strcat(inser_paymentrequest_query_final, "NOW())");
								mysql_query(mysql_connection, inser_paymentrequest_query_final);
								free(inser_paymentrequest_query_final);
							}
							free(query_select_balance_payer);
							free(query_select_balance_username_receipt);
							free(query_select_trancode_final);
							mysql_free_result(result_username);
						  
							mysql_free_result(result_payer);
						}
					}
				}
			}
		}
	}
	
}