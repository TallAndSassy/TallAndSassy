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

    # start the web server
    php artisan serve&

    # visit your page in the browser (maybe change the port, if needed, to match your instance)
    open http://127.0.0.1:8000

# At this point, laravel should be installed and basically working.

# Now, let's get TallAndSassy working so we can see what a minimum installation looks like.
#
## Init Tall & Sassy
#    # Add HQ
## Set up a blank laravel jet with livewire project (no teams)
#    laravel new MyTassyTest --jet --no-interaction --stack=livewire --git
#
## Get basic laravel up and running in standard way
#    cd MyTassyTest
#    npm install && npm run dev
#
## update `.env` so we can talk to the db
#    # make these be appropriate for your system
#    DB_DATABASE=tallandsassyminsample   # <-- Likely change me
#    DB_USERNAME=root                    # <-- Likely change me
#    DB_PASSWORD=ofallevil               # <-- Likely change me
#
#    -- OR, SIMPLY --
#
#
#
## Run the migrations
#    php artisan migrate
#
## Check if we can see this basical laravel.
#1) Start the server
#    `php artisan serve`
#2) visit `http://localhost:8002/` or wherever you are served.
#
## Roadmap
#Right now, this is simple laravel site. Nothing special.
#
#Next up, we will require TallAndSassy as a package, and work through the installation steps.
#I'm afraid a bunch of the steps are still manual. But let's hope we can eventually change that.
#We'll then test that super simple app. It will only do the very, very basics because this checklist is meant
#to just act as a proof of concept.  We'll do a more in-depth demo from a separate Steps-to-Reproduce file.
#
## Include TallAndSassy (dev)
#    # https://stackoverflow.com/a/19917033/93933
#    composer require tallandsassy/tallandsassy:dev-main



