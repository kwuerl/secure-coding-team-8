#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <string.h>
#include <math.h>
#include <stdint.h>
#include "transaction_controller.h"


static short account_id_size = 10;
static short account_name_size = 30;
static short amount_size = 8;
static short remarks_size = 128;

struct transaction_row {
	char *account_id;
	char *account_name;
	char *amount;
	char *remarks;
};

struct transaction_row construct_transaction_row() {
	struct transaction_row ret;
	ret.account_id = malloc(sizeof(char)*(account_id_size+1));
	ret.account_name = malloc(sizeof(char)*(account_name_size+1));
	ret.amount = malloc(sizeof(char)*(amount_size+1));
	ret.remarks = malloc(sizeof(char)*(remarks_size+1));
	return ret;
}

void destruct_transaction_row(struct transaction_row row) {
	free(row.account_id);
	free(row.account_name);
	free(row.amount);
	free(row.remarks);
}

int main(int argc, char **argv) {

	char *input = argv[1];
	FILE *input_file;

	int success = 0;

	input_file = fopen(input, "r");

	if (input_file == NULL) {
		perror("Cannot open input file\n");
        return(-1);
	} else {
		int i = 0;
		int row_count = 0;
		uint32_t j = 0;
		char c = 0;
		char prev_c = 0;
		struct transaction_row current_row = construct_transaction_row();
		do {
			if((c = fgetc(input_file)) == '\n') {
				// close line
				if (processTransfer(atoi(argv[2]), argv[3], argv[5], atoi(argv[4]), atoi(current_row.account_id), current_row.account_name, strtof(current_row.amount, NULL), current_row.remarks, argv[6], argv[7], argv[8], argv[9])) {
					success = 1;
				} else {
					success = 0;
				}
				i = 0;
				row_count++;
			}
			if (c != ';' || prev_c == '\\') {
				if (c != '\\') {
					if (i == 0) {
						if (j < account_id_size) {
							current_row.account_id[j] = c;
							j++;
	                    } else if (j == account_id_size) {
	                        current_row.account_id[j] = 0;
	                        j++;
	                    }
					} else if (i == 1) {
						if (j < account_name_size) {
							current_row.account_name[j] = c;
							j++;
	                    } else if (j == account_name_size) {
	                        current_row.account_name[j] = 0;
	                        j++;
	                    }
					} else if (i == 2) {
						if (j < amount_size) {
							current_row.amount[j] = c;
							j++;
	                    } else if (j == amount_size) {
	                        current_row.amount[j] = 0;
	                        j++;
	                    }
					} else if (i == 3) {
						if (j < remarks_size) {
							current_row.remarks[j] = c;
							j++;
	                    } else if (j == remarks_size) {
	                        current_row.remarks[j] = 0;
	                        j++;
	                    }
					}
				}
				/*Reset j when a newline is encountered*/
				if (c == '\n') {
					j = 0;
				}
			} else {
				if (i == 0) {
					if (j < account_id_size) {
						current_row.account_id[j] = 0;
	                }
				} else if (i == 1) {
					if (j < account_name_size) {
						current_row.account_name[j] = 0;
	                }
				} else if (i == 2) {
					if (j < amount_size) {
						current_row.amount[j] = 0;
	                }
				} else if (i == 3) {
					if (j < remarks_size) {
						current_row.remarks[j] = 0;
	                }
				}
				i++;
				j = 0;
			}
			prev_c = c;

	    } while (c != EOF);

	    if(i != 0 && row_count != 0) {
	    	if (processTransfer(atoi(argv[2]), argv[3], argv[5], atoi(argv[4]), atoi(current_row.account_id), current_row.account_name, strtof(current_row.amount, NULL), current_row.remarks, argv[6], argv[7], argv[8], argv[9])) {
	    		success = 1;
	    	} else {
	    		success = 0;
	    	}
	    }
	    destruct_transaction_row(current_row);
	}
	fclose(input_file);

	if (success == 1) {
		return 0; // everything works
	} else {
		return 1; // there was an error
	}
}