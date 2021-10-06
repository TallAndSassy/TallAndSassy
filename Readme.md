# A package for apps built around managed communities

## Quick Demo
Want to see a demo? Start by doing this:

    curl -LJO  https://raw.githubusercontent.com/TallAndSassy/TallAndSassy/main/bin/demo/INSTALL_FULL_DEMO.php

    php INSTALL_FULL_DEMO.php --DB_USERNAME=root --DB_PASSWORD=ofallevil  --APP_NAME=TassyTest001


## Quick Install with optional Demo

1. Install Laravel
   1. You can do you normal laravel install, or use this quick helper. Please the [Install Script](./bin/demo/INSTALL_1_Laravel.php) for details on how, precisely the Laravel install needs to look. 


    curl -H 'Authorization: token INSERTACCESSTOKENHERE' -H 'Accept: application/vnd.github.v3.raw' -O -L  https://raw.githubusercontent.com/TallAndSassy/TallAndSassy/v0.1.020wip-InstallStuff/bin/demo/INSTALL_1_Laravel.php
    
    php INSTALL_1_Laravel.php --DB_USERNAME=root --DB_PASSWORD=ofallevil --APP_NAME=MyTassyTest


2. require the `tallandsassy/tallandsassy` package
   1. Note: Instructions printed by the above install script will be considered 'true'. This is just a guide to get you oriented.


    cd MyTassyTest

    composer require tallandsassy/tallandsassy

3. tweak your installation to work nicely with tall and sassy.
   1. This script takes the TASSY_TENANCY_HQSUBDOMAIN and update your .env appropriately. The TASSY_TENANCY_HQSUBDOMAIN is a short field of your choosing for the superadmins
   

    php vendor/tallandsassy/tallandsassy/bin/INSTALL_2_Tassy.php --TASSY_TENANCY_HQSUBDOMAIN=st

4. Apply the demo script.
   1. Note: Instructions printed by the abovescript will be considered 'true'. This is just a guide to get you oriented.


    php vendor/tallandsassy/tallandsassy/bin/demo/INSTALL_3_Demo.php

5. Read the user guide
   1. The user [guide](./USERS_GUIDE.md) gives some directions to get you started.