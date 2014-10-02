#include "program.h"

int main () {

	puts ("\n\nThis program is made by Bob Desaunois for HMS.\n"
		  "             Samuel is a sexy beast.\n"
		  "\n"
		  "###################################################\n"
		  "# *              HMS DB Installer               * #\n"
		  "###################################################\n"
		  "#                                                 #\n"
		  "# Welcome.                                        #\n"
		  "# Please make sure you have the following items:  #\n"
		  "#                                                 #\n"
		  "# 1) A MySQL Database.                            #\n"
		  "# 2) The password to your database.               #\n"
	      "# 3) Made sure there's an account named 'root'    #\n"
		  "# 4) A copy of HMS.                               #\n"
	      "#                                                 #\n"
		  "###################################################\n");

	puts ("\nPress ENTER to continue or CTRL C to exit..");
	getchar ();

	puts ("\n\nNow running the installer..\n");

	installer ();

	return 0;

}