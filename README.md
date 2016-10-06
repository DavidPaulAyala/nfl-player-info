# _NFL Players_
#### _07 October 2016_

#### By _**David Ayala and Josh Huffman**_

## Description

_This web app allows a user to view football statistics and create a fantasy football team.  Users are able to view statistics for the top 15 performers by fantasy points in a variety of positions and going back to 2009.  Users are able to log in to the site and create a team and add players to their teams._

## Specifications

|Behavior|Input        |Output|
|--------|:-----------:|-----:|
|Obtain Player List from NFL API|www.exampleNFL-API.com|Tom Brady, Andrew Luck, etc.|
|Obtain multiple fields of info for players|www.exampleNFL-API.com|Tom Brady, points=35, td=4, pass yards=303, etc.|
|Arrange in list by position,week,year|QB/Week 3/2016|Tom Brady, points=35, td=4, pass yards=303,Andre Luck, points=25, td=2, pass yards=225, etc.|
|Add User for Fantasy League|new user: Dave|new user: Dave|
|Not allow users with the same name|new user: Dave|Dave taken, please enter new user|
|Add password for new user login|new user: Dave password: 576767|new user created: Dave, password:576767|
|Allow user to create team name|New Team Name: Warriors|New Team Name: Warriors|
|Allow team to add players|Team Warriors add new player Tom Brady|Tom Brady on team Warriors|

## Technologies Used

_HTML,
CSS,
JS,
PHP,
Silex,
Twig,
PHPUnit,
MySQL_

## Setup Instructions

* _Clone the program from its github repository_
* _Navigate to the project directory in a command line software._
* _Type composer install_
* _Type: "cd web" to move into the "web" folder._
* _Type: "php -S localhost:8000" to create a local server for the project_
* _import the included sql.zip database files to MYSQL_
* _Open the browser of your choice and type in this URL to load the project: "localhost:8000"_

## Technologies Used

_HTML,
CSS,
JS,
PHP,
Silex,
Twig,
PHPUnit,
MySQL_

## Licensing

*This product can be used in accordance with the provisions under its MIT license.*

copyright (c) 2016 **_David Ayala and Josh Huffman_**
