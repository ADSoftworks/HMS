#include "program.h"

void installer () {

	system ("mysql -u root -ptoor -e 'SOURCE db_seed.sql'");
	puts ("##################"
		  "\nINSTALLING IS DONE"
		  "\n##################");

}
