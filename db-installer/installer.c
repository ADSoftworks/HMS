#include "program.h"

void installer (char *u[], char *p[]) {

	char buffer[255];
	snprintf (buffer, sizeof (buffer), 
		"mysql -u %s -p%s -e 'SOURCE db_seed.sql'", *u, *p);

	system (buffer);
	puts ("\n#####################"
		  "\n# INSTALLER IS DONE #"
		  "\n#####################");

}
