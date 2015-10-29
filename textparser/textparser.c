#include <stdio.h>
#include <stdlib.h>
#include <errno.h>
#include <string.h>

int main(int argc, char **argv) {
	int to;
	char to_name[31];
	float amount;
	char code[16];
	char remarks[129];

	char *input = argv[1];
	FILE *input_file;
	char read[129];

	input_file = fopen("test.txt", "r");

	if (input_file == NULL) {
		perror("Canot open input file\n");
        return(-1);
	} else {
		for (int i = 0; i < 5; i++) {
			if (i == 0) {
				if (fgets(read, 12, input_file) != NULL) {
					sscanf(read, "%d", &to);
				}
			} else if (i == 1) {
				if (fgets(read, 32, input_file) != NULL) {
					read[strcspn(read, "\n")] = 0;
					strcpy(to_name, read);
				}
			} else if (i == 2) {
				if (fgets(read, 10, input_file) != NULL) {
					sscanf(read, "%F", &amount);
				}
			} else if (i == 3) {
				if (fgets(read, 17, input_file) != NULL) {
					sscanf(read, "%s", &code);
				}
			} else if (i == 4) {
				if (fgets(read, 130, input_file) != NULL) {
					read[strcspn(read, "\n")] = 0;
					strcpy(remarks, read);
				}
			}
		}
	}
	printf("%d\n", to);
	printf("%s\n", to_name);
	printf("%F\n", amount);
	printf("%s\n", code);
	printf("%s\n", remarks);
	fclose(input_file);

	return 0;
}