#include "program.h"

int main (int argc, char *argv[]) {

	if (argc != 3) {

		printf ("Please supply the username\n and password of an account from your database.\n");
		return 1;

	}

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
		  "# 2) A copy of HMS.                               #\n"
	      "#                                                 #\n"
		  "###################################################\n");

	puts ("\nPress ENTER to continue or CTRL C to exit..");
	getchar ();

	puts ("\n\nNow running the installer..\n");

	installer (&argv[1], &argv[2]);

	return 0;

}