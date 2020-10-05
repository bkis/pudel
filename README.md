# Sprudel

> :warning: **Development of this (original) incarnation of Sprudel is discontinued!** [ElTh0r0](https://github.com/ElTh0r0) (a contributor to the Sprudel codebase) and [yours truly](https://github.com/bkis) decided, in mutual agreement, that the project needs a fundamental technical makeover for it's future development to make any sense.  
> For this reason, the project has been ported to CakePHP, so it now uses a proper web framework in the backend. To mark this change and all the great new changes and features to come in the future, it is now called **[PREFERendum](https://github.com/ElTh0r0/preferendum)** (click to get there!) and will be maintained by [ElTh0r0](https://github.com/ElTh0r0) :champagne:

## A flexible, self-hosted webapp for scheduling and polls

- based on **PHP** and **MySql** (so it even runs on most managed hosting plans)
- clean, intuitive interface
- `yes`/`no`/`maybe` options
- answer trend **visualization**
- free entry of arbitrary **answer options or dates** (using the built-in datepicker)
- unique public links for sharing a poll
- optional **poll admin links** to restrict poll management to author
- one-click **clipboard copy** of the poll URL
- **comments** section in every poll
- **Mini View** feature (for very big poll tables)
- **customizable labels**: all the labels and texts can be set to custom strings, so you can even translate the interface to a language of your choice
- **customizable colors**: all the interface colors can easily be set to your preference (system-wide, that is, not for individual polls)
- **cleanup-script** included for deleting polls that have been inactive for more than a certain number of days (can be run via cronjob)
- optional poll **administration interface** for managing all the polls on the server
- optional **anti-spam system** to block requests from IPs that took too many actions (create poll/entry/comment) in fast succession (details in `config/config.features.php`!)

## Have a look!
![Poll screenshot](img/screenshot.png)

## Requirements
- PHP 5.4 or higher
- A MySql database

## Installation
This is fairly easy as long as you know how to create a new MySql-database (e.g. via phpmyadmin) and upload the app's files to your webserver (e.g. via FTP). If you don't, you'll have to find out how this is done on your server beforehand.

1. Create an empty MySql database on your server, note down the DB host address, user name and password
2. Download the Sprudel files as `.zip` archive from this repository
3. Extract the contents of the archive into a new directory (e.g. `sprudel` on your computer)
4. Edit `config/config.db.php` and insert the database's credentials (read comments in the file to understand what is what!)
5. Upload the `sprudel` directory to your web server (root-directory or somewhere else)
6. Access `<your installation folder>/install.php` through your browser (e.g. `yourdomain.com/sprudel/install.php`)
7. If everything is fine, Sprudel will tell you so
8.  Delete `install.php` from your server
9.  Enjoy! :ok_hand:

## Configuration and customization
### Features configuration
You can turn on/off and configure all the available features (like admin interface and anti-spam system) in `config/config.features.php`.
### Texts and labels
In `config/config.texts.php`, you can not only set up the database connection and functional configuration, but also *every text and label string used on the Sprudel website*! This means you could just adjust the texts to your needs or even translate the complete web interface to another language.
### Colors
At the top of the CSS stylesheet (`css/style.css`), you'll find a list of [CSS custom properties](https://developer.mozilla.org/en-US/docs/Web/CSS/--*) you can change to customize colors and some other layout/design related things.

## Administration
### Poll administration interface (off by default)
If you want to use the optional admin interface (to view and delete any polls on your server via a web interface under `/admin`) you have to enable this in `config/config.features.php`!  
In this case, you'll have to **secure the** `admin` **directory, so it cannot be accessed publicly**! This process is different depending on the web server software you use. There are numerous tutorials about this online, e.g. for [Apache](https://www.tecmint.com/password-protect-apache-web-directories-using-htaccess/) or [Nginx](https://www.tecmint.com/password-protect-web-directories-in-nginx/). By the way, it is safe to rename the `admin` directory to anything less obvious!
### Automatic deletion of inactive polls (needs cronjob!)
You can set up a certain number of days in the `config.features.php` to mark the maximum age of an **inactive** poll ( *inactive* as in: no new answers and comments). Sprudel comes with a cleanup script (`cleanup.php`) that you can set up to be executed periodically via a cronjob, e.g.  
`0 0 1 * * /usr/bin/php /var/www/html/sprudel/cleanup.php`  
The cleanup script will then delete all inactive polls that became too old.
### Anti-spam system (off by default)
The comments in `config/config.features.php` should be pretty self-explanatory. Here, you can turn on/off the anti-spam system and set it's parameters like the **number of actions** a user may take in a row without at least **a number of seconds** in between these actions and of course the **block time** in seconds to block a spamming user for a certain amount of time. The default here is a number of `5` such actions in a row with less than `60` seconds in between, which, if exceeded, leads to a block from these actions for `3600` seconds (1 hour).  
Of course the IPs are saved in a hashed form and **not in plain text**!

## Contribution
I don't actually feel at home in PHP, but I chose this language anyway because it's still the most widely used backend scripting language and already installed on most web servers. It's always nice not to have to install an additional backend ecosystem on your server just because you want to try a new web app.  
I tried hard to make this as bulletproof and tidy as possible, but I bet my thumbs on that it doesn't always follow best practice. If you have any suggestions for additional features or run into problems setting up Sprudel, **write an issue**! If you feel like improving the code of this app, send a (well documented) **pull request**! If you just like Sprudel as it is, let me know by donating this repo a star.

## Attribution of used third-party software/media
Sprudel makes use of the following software/media and says **Thank you!** to:
- [/catfan/Medoo](https://github.com/catfan/Medoo)
- [/fengyuanchen/datepicker](https://github.com/fengyuanchen/datepicker)
- [/jquery/jquery](https://github.com/jquery/jquery)
- [/zenorocha/clipboard.js](https://github.com/zenorocha/clipboard.js)
- [Icons from iconmonstr.com](http://www.iconmonstr.com)
