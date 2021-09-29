#bash!

# Quick Start
# Let's assume you have `mysql` and `php` available from the command line.

## Quick Start: Install Laravel
    # install laravel
    laravel new MyTassyTest --jet --no-interaction --stack=livewire --git
    cd MyTassyTest

## Quick Start: Create DB
    # fix up database. Tweak as needed
    mysql -u root -pofallevil -e "DROP DATABASE IF EXISTS MyTassyTest; CREATE DATABASE MyTassyTest;"


## Quick Start: Config base laravel    
    # Which Database: uncomment and modify, if desired 
    # sed -i".orig" 's/DB_DATABASE=MyTassyTest/DB_DATABASE=YourDatabaseName/' .env
    
    # Which DB username: uncomment and modify, if desired
    # sed -i".orig" 's/DB_USERNAME=root/DB_USERNAME=YourDbUserName/' .env

    # DB password: modify 'ofallevil' to your approprite password
    sed -i".orig" 's/DB_PASSWORD=.*$/DB_PASSWORD=ofallevil/' .env   

    # setup the database so far
    php artisan migrate

    # get the javascript all set up
    npm install && npm run dev


# At this point, laravel should be installed and basically working.
# Nothing before this line should be different than a typical laravel project

# Now, please run INSTALL_2_Tassy.sh to make this laravel project be Tassy aware.


