//zdc9pd
//14151501
//LAB 11

#include <stdio.h>
#include <sqlite3.h>
#include <string.h>

int main(int argc, char** argv)
{
	if(argc != 4) { //check arguements
	  fprintf(stderr, "USAGE: %s <database file> <table name> <CSV file>\n", argv[0]);
	  return 1;
	}

	FILE *db_file = fopen(argv[3], "w+"); //open file
	sqlite3* d_base;
	printf("Starting CSV creation.\n");
	
	if(sqlite3_open(argv[1], &d_base) == SQLITE_OK) {	//open db file
		printf("Database opened.\n");
	}	
	else {
		printf("Unable to open database.\n");
	}

	char statement[100]  = "SELECT * FROM "; //build the select statement
	char* table_name = argv[2];
	strcat(statement, table_name);
	sqlite3_stmt * prev_stm;;
	int control;
	
	if (control = sqlite3_prepare_v2(d_base, statement, -1, &prev_stm, 0) ) { //prepare the statement
		printf("prepare broke\n");
	}


	int columns = sqlite3_column_count(prev_stm); //grab the column count

	while (1) {
		control = sqlite3_step(prev_stm);
		if(control == SQLITE_ROW) {
			int i = 0;
			for(i=0; i<columns; i++) {
				if(i != 0) { // print the DB file
					fprintf(db_file, ",");
				}
				//Grab the data type of the prev data
				int data_type =  sqlite3_column_type(prev_stm,i);
				//grab the text content of the column
				const char * column_value = (const char*) sqlite3_column_text(prev_stm, i);
				
				if(data_type == 3 || data_type == 1) {
					//	printf("Writing to db file...\n")
					if(data_type == 3) { //used for varchar, add ''
						fprintf(db_file, "'%s'",column_value);
					}
					else { // otherwise its integer
						fprintf(db_file, "%s",column_value);
					}
				}
				else
				{
					printf("Table data is not in correct format! Please update your table\n");
					return 0;
				}
				
			}
			fprintf(db_file,"\n");
		}
		else if (control == SQLITE_DONE) {
			printf("Finished grabbing the rows\n");
			break;
		}
		else {
			printf("Error! Try again.\n");
			return 0;
		}
	}
	printf("Dump File created!\n");
	//close out of the files
	sqlite3_close(d_base);
	fclose(db_file);
	return 0;
}