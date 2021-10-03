You can get into a lot of trouble when doing package development. 

One common error is when you rename a file/class, and laravel seems to barf looking for the old class.
Composer, I think, doesn't regenerate unluss there is a version change.  Basically, the `vendor/composer/autoload-...` is whacked
Try stuff like this:
    
    composer dumpautoload -o
    php artisan optimze
    composer update
    composer install
     php artisan migrate:refresh
    
