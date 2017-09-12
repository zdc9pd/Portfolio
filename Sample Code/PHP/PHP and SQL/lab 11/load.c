//zdc9pd
//14151501
//LAB 11

#include <stdio.h>
#include <sqlite3.h>
#include <string.h>

int main(int argc, char** argv) {
	if(argc != 4) { //check to make sure the right arguements are supplied
	  fprintf(stderr, "USAGE: %s <database file> <table name> <CSV file>\n", argv[0]);
	  return 1;
	}

	FILE * db_file; 
	if ((db_file = fopen(argv[3], "r")) == NULL) {  //open the file
	  printf("Error opening file!\n");
	  return 0;
	}
	
	sqlite3* d_base;
	printf("File Opened!\n");
	if(sqlite3_open(argv[1], &d_base) == SQLITE_OK) { // open the db file
		printf("Database Opened!\n");
	}
	else {
		printf("Error opening database!\n");
	}

	//Create the delete statement
	char statement[100]  = "DELETE FROM ";
	char* table_name = argv[2];
	strcat(statement, table_name);
	
	sqlite3_stmt * prev_stm;
	int control;
	
	if (control = sqlite3_prepare_v2(d_base, statement, -1, &prev_stm, 0)) { //prepare the statement for delete
			printf("Error in prepare 1\n");
	}

	sqlite3_step(prev_stm);
	sqlite3_finalize(prev_stm);
	
	//create the insert statement
	char line [200];
	while(fgets(line, 200, db_file) != NULL) {
		char statement2[250] = "INSERT INTO ";
		strcat(statement2, table_name);
		strcat(statement2, " VALUES (");
		strcat(statement2, line);
		strcat(statement2, ")");
		
		if(control = sqlite3_prepare_v2(d_base, statement2, -1, &prev_stm, 0)) { //prepare the statement for insert
			printf("Error in prepare 2.\n");
			return 0;
		}	
		else {
			int check;	
			if ((check = sqlite3_step(prev_stm)) == 101) {
				printf("Insert Sucess!\n");
			}
			else {
				printf("Insert Error!\n");
			}
			
		}
		sqlite3_finalize(prev_stm);
	}
	//Close the files
	printf("Load Success!\n");
	sqlite3_close(d_base);
	fclose(db_file);
	return 0;
}