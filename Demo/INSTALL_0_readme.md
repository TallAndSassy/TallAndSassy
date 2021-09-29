# Overview 
There are two script files to make it easier and fun(1) to install Tassy locally 
and play around with it. You'll want to run `INSTALL_1_laravel.sh` once to get a fressh 
laravel installed. Or feel free to make your own, standard, virgin laravel installation, but see
the guts of the .sh file to look for specifics.

# Install baseline Laravel w/ jet, no teams 
If you don't already have this package installed in a simple laravel app, you can quickly do here:
    # get this file locally
    curl -H 'Authorization: token INSERTACCESSTOKENHERE' -H 'Accept: application/vnd.github.v3.raw' -O -L  https://raw.githubusercontent.com/TallAndSassy/TallAndSassy/v0.1.020wip-InstallStuff/bin/demo/INSTALL_1_Laravel.php
    php INSTALL_1_Laravel.php --DB_USERNAME=root --DB_PASSWORD=ofallevil --APP_NAME=MyTassyTest --DO_FORCE_REINSTALL=1



## Is it working?
    
After running the 'INSTALL_1_Laravel', look at the output in the terminal for hints
on how to start your webserver and visit it the browser.  There aren't any tricks there, just
helpful reminders.

## Continue on...
You have a working laravel install ready for Tassy play.  ...
    composer require tallandsassy/tallandsassy:dev-main
    php vendor/tallandsassy/tallandsassy/bin/demo/INSTALL_2_Tassy.php --HQ_SUBDOMAIN=st

(1) citation needed.