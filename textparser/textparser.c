#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <string.h>
#include <math.h>

int main(int argc, char **argv) {
	char account_id[10] = {0};
	char account_name[30] = {0};
	char amount[8] = {0};
	char code[15] = {0};
	char remarks[128] = {0};

	char *input = argv[1];
	FILE *input_file;

	input_file = fopen(input, "r");

	if (input_file == NULL) {
		perror("Cannot open input file\n");
        return(-1);
	} else {
		int i = 0;
		int j = 0;
		char c;
		do {
			if ((c = fgetc(input_file)) != '\n') {
				if (i == 0) {
					if (j < sizeof(account_id)) {
						account_id[j] = c;
						j++;
					}
				} else if (i == 1) {
					if (j < sizeof(account_name)) {
						account_name[j] = c;
						j++;
					}
				} else if (i == 2) {
					if (j < sizeof(amount)) {
						amount[j] = c;
						j++;
					}
				} else if (i == 3) {
					if (j < sizeof(code)) {
						code[j] = c;
						j++;
					}
				} else if (i == 4) {
					if (j < sizeof(remarks)) {
						remarks[j] = c;
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

	char json[250];
	snprintf(json, sizeof(json), "{\"account_id\":%s,\"account_name\":\"%s\",\"amount\":%s,\"code\":\"%s\",\"remarks\":\"%s\"}", account_id, account_name, amount, code, remarks);
	printf("%s", json);

	return 0;
}