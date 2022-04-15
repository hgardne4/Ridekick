Project Ridekick: Henry Gardner, Gabby Novack
CSC261 Final Project Milestone 3
Prof. Zhupa

NOTE: taskB is contained within the src directory

This project is hosted on the following github repository and is up to date:

	github.com/hgardne4/ridekick

How to run:
This project is being locally hosted for ease of development before release. We are hosting with PHP's built-in webserver. First make sure you are in the src directory and then execute the following command:

	php -S 127.0.0.1:8000

After executing this command, something similar to the following will result in the output:
PHP 7.2.24-0ubuntu0.18.04.11 Development Server started at Wed Apr 13 16:31:13 2022
Listening on http://127.0.0.1:8000
Document root is /home/henryg30/Desktop/Ridekick/src
Press Ctrl-C to quit.

The "Listening on http://127.0.0.1:8000" line contains a live link that can then be used to open and run the project. This will open the idex.html or index.php file (in our case it is the index.html file).


DESIGN:
PHP Choices:
When designing the login feature there were several approaches the best being a an object oriented approach. We were then able to make several functions corresponding to specific user inputs on different files. The best approach to discovering and differentiating which HTML files the POST data was coming from was through the HTML hidden tag feature. This way, we were able to use the same PHP file on both the login and signup pages, allowing for input to be differentiated within the backend. This was a super fun approach and made the linking between the front and backend make a lot more sense.  
