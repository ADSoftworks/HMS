#include "program.h"

void installer () {

	puts ("Now attempting to log into MySQL with root.");
	puts ("Please enter it's password.");
	system ("mysql -u root -ptoor -e 'SOURCE db_seed.sql'");
	puts ("##################"
		  "\nINSTALLING IS DONE"
		  "\n##################");

}
