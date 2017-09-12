#include <stdio.h>
#include <sqlite3.h>
#include <string.h>

int main(int argc, char** argv)
{
  if(argc != 4)
    {
      fprintf(stderr, "USAGE: %s <database file> <table name> <CSV file>\n", argv[0]);
      return 1;
    }

//  printf("Implement me!\n");
FILE * file; 
if ((file = fopen(argv[3], "r")) == NULL)
   {
      printf("There was a problem opening the file. Please try again.\n");
      return 0;
   }

sqlite3* db;
printf("Startig to read from the file.\n");
        if(sqlite3_open(argv[1], &db) == SQLITE_OK)
        {
		//printf("opened correctly");
        }
        else
        {
                printf("Unable to open database.\n");
        }

char stm[100]  = "DELETE FROM ";
char* tName = argv[2];
strcat(stm, tName);
sqlite3_stmt * pstm;
int k;


k = sqlite3_prepare_v2(db, stm, -1, &pstm, 0);
        if (k)
        {
                printf("prepare broke\n");
        }
        else
        {
		//printf("prepare worked");
        }

sqlite3_step(pstm);
sqlite3_finalize(pstm);
//create the insert statement 
char line [200];
while(fgets(line, 200, file) != NULL)
{
	char stm2[250] = "INSERT INTO ";
	strcat(stm2, tName);
	strcat(stm2, " VALUES (");
	strcat(stm2, line);
	strcat(stm2, ")");
	//printf("stament is %s\n", stm2);
	//printf("line is %s\n", line);
	//char test[250] = "INSERT INTO mytable VALUES (\"1\", \"'this'\",\"'is'\")";	
	//printf("%s\n", test);
	k = sqlite3_prepare_v2(db, stm2, -1, &pstm, 0);
	if(k)
	{
		printf("Unable to execute the prepare statement.\n");
		return 0;
	}	
	else
	{
		//printf("at the else");
		int z = sqlite3_step(pstm);	
		//printf("%i\n", z);
		//printf("%s\n", sqlite3_errmsg(db));
		if (z == 101) 
		{
			printf("insert\n");
		}
		else
		{
			printf("An error has occured. Please try again.\n");
		}
		
	}
	sqlite3_finalize(pstm);
}

//end of app
  printf("Success.\n");
  sqlite3_close(db);
  fclose(file);
  return 0;
}
