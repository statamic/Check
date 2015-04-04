# Statamic Server

Determine if your server can run Statamic, as well as give you some basic information about your server.

## How to use this

Upload `check.php` to your web server's document root, and then visit `check.php` in a web browser.
This page should tell you everything that you need to know about if you can run Statamic or not. 

*Note: just because your server passes the check doesn't guarantee it will run Statamic, there are always edge cases and oddly configured hosts that may throw a curve ball. Conversely, some things are hard to detect when running PHP as CGI, meaning that a failure also doesn't mean it won't run. This is just a good benchmark.*
