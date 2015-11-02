#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <string.h>
#include <math.h>
#include <stdint.h>
#include "../db/transaction_controller.h"

int main(int argc, char **argv) {
    short account_id_size = 10;
	char *account_id = malloc(sizeof(char)*(account_id_size+1));
    short account_name_size = 30;
	char *account_name = malloc(sizeof(char)*(account_name_size+1));
    short amount_size = 8;
	char *amount = malloc(sizeof(char)*(amount_size+1));
    short code_size = 15;
	char *code = malloc(sizeof(char)*(code_size+1));
    short remarks_size = 128;
	char *remarks = malloc(sizeof(char)*(remarks_size+1));

	char *input = argv[1];
	FILE *input_file;

	input_file = fopen(input, "r");

	if (input_file == NULL) {
		perror("Cannot open input file\n");
        return(-1);
	} else {
		int i = 0;
		uint32_t j = 0;
		char c;
		do {
			if ((c = fgetc(input_file)) != '\n') {
				if (i == 0) {
					if (j < account_id_size) {
						account_id[j] = c;
						j++;
                    } else if (j == account_id_size) {
                        account_id[j] = 0;
                        j++;
                    }
				} else if (i == 1) {
					if (j < account_name_size) {
						account_name[j] = c;
						j++;
                    } else if (j == account_id_size) {
                        account_name[j] = 0;
                        j++;
                    }
				} else if (i == 2) {
					if (j < amount_size) {
						amount[j] = c;
						j++;
                    } else if (j == account_id_size) {
                        amount[j] = 0;
                        j++;
                    }
				} else if (i == 3) {
					if (j < code_size) {
						code[j] = c;
						j++;
                    } else if (j == account_id_size) {
                        code[j] = 0;
                        j++;
                    }
				} else if (i == 4) {
					if (j < remarks_size) {
						remarks[j] = c;
						j++;
                    } else if (j == account_id_size) {
                        remarks[j] = 0;
                        j++;
                    }
				}
			} else {
				i++;
				j = 0;
			}

	    } while (c != EOF);
	}
	fclose(input_file);

	/*
	char json[250];
	snprintf(json, sizeof(json), "{from_id:\"%s\",from_account_id:\"%s\",\"to_account_id\":%s,\"account_name\":\"%s\",\"amount\":%.2f,\"code\":\"%s\",\"remarks\":\"%s\"}", argv[2], argv[3], account_id, account_name, strtof(amount, NULL), code, remarks);
	printf("%s", json);
	*/

	processTransfer(atoi(argv[2]), code, atoi(argv[3]), atoi(account_id), account_name, strtof(amount, NULL), remarks);
	/*TODO Need to pass the following values to the function in transaction_controller.c
		int customer_id (Ex: 1)
		int from_account_id (Ex: 1234567890)
		int to_account_id (Ex: 25987456)
		char* to_account_name (Ex: "TUM Admission Office")
		float amount (Ex: 2500.00)
		char* code (Ex: "ebWLgO24z9vY/2K")
		char* remarks (Ex: "Payment of fees") */

	return 0;
}