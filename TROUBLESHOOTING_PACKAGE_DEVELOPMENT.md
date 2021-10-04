You can get into a lot of trouble when doing package development. 

One common error is when you rename a file/class, and laravel seems to barf looking for the old class.
Composer, I think, doesn't regenerate unless there is a version change.  Basically, the `vendor/composer/autoload-...` and/or `vendor/composer/install.json` and/or `bootstrap/cache/packages.php` is whacked
Try forcing a complete reparse like this:

    rm vendor/composer/installed.json
    composer update

This happens when you change the class name of a service provider in you package, and maybe othertimes, too.

You might also want to

    composer dumpautoload -o
    php artisan optimze
    composer update
    composer install
     php artisan migrate:refresh
    
For developing a package, removing the mirror and symlinking to the local install isn't so bad.  
You can also play with local repositories via paths, but I'm convinced this helps much

    "repositories": [
        {
            "type": "path",
            "url": "../TallAndSassy"
        }
    ]