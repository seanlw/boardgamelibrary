BoardGame Library
=================

BoardGame Library is a easy to use system to keep track of people that have borrowed your
game collection. BoardGame Library has an easy to use Check In/Out system that lets
you see who has your games and for how log.

Installation
------------

Requirements:

* Apache or like server
* PHP 5.3+
* Sqlite

1. Clone the BoardGame Library repository into your Apache document root
2. Copy/Rename the database.php.default to database.php. This file is located under {install location}/app/Config/
3. Copy/Rename the bglib.sqlite.default file to bglib.sqlite. This file is located under {install location}/app/Database
4. Make the following directories and their subdirectories writable by Apache
    app/tmp
    app/webroot/img/boardgames/images
    app/webroot/img/boardgames/thumbnails
5. That's it.

Usage
-----

To add games to your library simply click the 'Library' tab and click 'Add' to start adding games to your library.
The identification code can be anything you want it to be to identify that game, like the UPC code.

To checkout a game click the 'Check Out' tab. Input the users unique identification number. If you user doesn't exist
the next screen will ask to input their information. Next give the board games unique identification and confirm the information
is correct. Don't forget to click 'Check Out' button on the confirmation screen to make the check out process complete.

To check in a game click the 'Check In' tab and input the board games unique identification code. Click 'Check In' and that's it,
the game is now checked in.

You can click the 'Users' tab to see all the users that are in the system. You can also click the 'Check Out Game' button to
start checking out a game for that selected user.

Enjoy!

Development
-----------

BoardGame Library uses CakePHP for its backend code. It also uses Grunt to handle CSS and Javascript, in addition to using Bootstrap.
The CSS uses SASS and can be found in {install location}/grunt/sass/. The JS files are in {install location}/grunt/js/.

Requirements

* NodeJS
* Grunt

To install grunt requirements (only needs to be done once) run

    cd {install location}/grunt
    npm install

Run the following command in {install location}/grunt to have Grunt automatically run the grunt processes when the CSS or JS is changed.

    grunt watch
    
You can also run the Grunt process manually with these

    grunt sass:dev
    grunt uglify:dev