VERSION = 3.02
CC      = gcc
CFLAGS  = $(shell mysql_config --libs)
LDFLAGS = 
OBJ = account_repo.o repository.o  transaction_controller.o  transaction_repo.o transactioncode_repo.o textparser.o

all: clean textparser

textparser:  $(OBJ)
	$(CC) $(CFLAGS) -o textparser $(OBJ) $(LDFLAGS) 

%.o: %.c
	$(CC) $(CFLAGS) -c $<

clean:
	rm -f *.o textparser
