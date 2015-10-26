/*Creation of database.*/
CREATE DATABASE IF NOT EXISTS BANK_DETAILS;

/*Change the working database to the newly created one.*/
USE BANK_DETAILS;

/*Create table TBL_CUSTOMER to store customer details.*/
CREATE TABLE IF NOT EXISTS TBL_CUSTOMER(
	ID INT(6) UNSIGNED PRIMARY KEY,
	FIRST_NAME VARCHAR(20) NOT NULL,
	LAST_NAME VARCHAR(20) NOT NULL,
	EMAIL VARCHAR(40) NOT NULL,
	PASSWORD VARCHAR(30) NOT NULL,
	IS_ACTIVE BIT
);
 
/*Create table TBL_EMPLOYEE to store employee details.*/
CREATE TABLE IF NOT EXISTS TBL_EMPLOYEE (
	ID INT(6) UNSIGNED PRIMARY KEY,
	FIRST_NAME VARCHAR(20) NOT NULL,
	LAST_NAME VARCHAR(20) NOT NULL,
	EMAIL VARCHAR(40) NOT NULL,
	PASSWORD VARCHAR(30) NOT NULL,
	IS_ACTIVE BIT,
	IS_AUTHORIZED BIT
);
  
/*Create table TBL_ACCOUNT to store account details for the customers.*/
CREATE TABLE IF NOT EXISTS TBL_ACCOUNT(
	ID INT(10) UNSIGNED PRIMARY KEY,
	ACCOUNT_ID INT(10) NOT NULL UNIQUE,
	CUSTOMER_ID INT(6) UNSIGNED NOT NULL,
	IS_ACTIVE BIT,
	FOREIGN KEY (CUSTOMER_ID) REFERENCES TBL_CUSTOMER(ID) ON DELETE CASCADE
);

/*Create table TBL_TRANSACTION to store transaction details for customer accounts.*/
CREATE TABLE IF NOT EXISTS TBL_TRANSACTION(
	ID INT(6) UNSIGNED PRIMARY KEY,
	TRANSACTION_DATE DATETIME NOT NULL,
	FROM_ACCOUNT_ID INT(10) NOT NULL,
	TO_ACCOUNT_ID INT(10) NOT NULL,
	TO_ACCOUNT_NAME VARCHAR(30) NOT NULL,
	AMOUNT FLOAT(7,2) NOT NULL,
	REMARKS VARCHAR(128),
	IS_ON_HOLD BIT,
	FOREIGN KEY (FROM_ACCOUNT_ID) REFERENCES TBL_ACCOUNT(ACCOUNT_ID) ON DELETE CASCADE
);

/*Create table TBL_TRANSACTION_CODE to store the transaction codes for customers.*/
CREATE TABLE IF NOT EXISTS TBL_TRANSACTION_CODE( 
	ID INT(10) UNSIGNED PRIMARY KEY,
	CUSTOMER_ID INT(6) UNSIGNED NOT NULL,
	CODE VARCHAR(15) NOT NULL,
	FOREIGN KEY (CUSTOMER_ID) REFERENCES TBL_CUSTOMER(ID) ON DELETE CASCADE
);