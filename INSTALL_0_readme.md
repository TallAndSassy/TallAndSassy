# Overview 
There are two script files to make it easier and fun(1) to install Tassy locally 
and play around with it. You'll want to run `INSTALL_1_laravel.sh` once to get a fressh 
laravel installed. Or feel free to make your own, standard, virgin laravel installation, but see
the guts of the .sh file to look for specifics.

Do something like this ()


    git clone https://github.com/TallAndSassy/TallAndSassy
    chmod +x TallAndSassy/INSTALL_1_Laravel.sh
    chmod +x TallAndSassy/INSTALL_2_Tassy.sh

    TallAndSassy/INSTALL_1_Laravel.sh

## start the web server (probably in a new tab)
    php artisan serve

## visit your page in the browser (maybe change the port, if needed, to match your instance)
    cd MyTassyTest
    ../TallAndSassy/INSTALL_2_Tassy.sh


(1) citation needed.