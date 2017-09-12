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

FILE *file = fopen(argv[3], "w+");
sqlite3* db;
printf("Starting CSV creation.\n");
    	if(sqlite3_open(argv[1], &db) == SQLITE_OK)
	{	
		//printf("it might have worked");
	}	
	else
	{
		printf("Unable to open database.\n");
	}

char stm[100]  = "SELECT * FROM ";
char* tName = argv[2];
strcat(stm, tName);
sqlite3_stmt * pstm;;
int k;

//printf("this is stm %s\n", stm);

k = sqlite3_prepare_v2(db, stm, -1, &pstm, 0);
	if (k)
	{
		printf("prepare broke\n");
	}
	else
	{
		//printf("prepare works\n");
	}

int cols = sqlite3_column_count(pstm);

while (1) 
{
	k = sqlite3_step(pstm);
	if(k == SQLITE_ROW) 
	{
		int i = 0;
		for(i=0; i<cols; i++) 
		{
			if(i != 0)
			{
				fprintf(file, ",");
			}
			int dtype =  sqlite3_column_type(pstm,i);
			//printf("count is %i", count);
			const char * txt = (const char*) sqlite3_column_text(pstm, i);
			//printf("dtype = %i\n", dtype);
			if(dtype == 1 || dtype ==3)
			{
			//	printf("Writing data to file...\n")
					if(dtype == 1)
                                         {
                                                fprintf(file, "%s",txt);
                                         }
                                         else
                                         {
                                                 fprintf(file, "'%s'",txt);
                                         }

			}
			else
			{
				printf("Columns are not text or integer. Please change your table and try again.\n");
				return 0;
			}
			
		}
		fprintf(file,"\n");
	}
	else if (k == SQLITE_DONE) 
	{
		printf("Finished getting rows\n");
		break;
	}
	else
	{
		printf("An error occured. Please try again.\n");
		return 0;
	}
}
  printf("File created.\n");
  sqlite3_close(db);
  fclose(file);
  return 0;
}
