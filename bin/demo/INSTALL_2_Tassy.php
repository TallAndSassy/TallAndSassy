<?php

/*
# Now, let's get TallAndSassy working so we can see what a minimum installation looks like.
# Goal: Be able to run this multiple times, within the same Laravel installation.
Goal #2: Make this happen automatically during the package installation. sheesh.
*/
// Init Tall & Sassy

# Add HQ (we need an HQ subdomain) -------------------------------------------------------------------------------------------------------------------------------------------------
$HQ_SUBDOMAIN = getOptionalOption(
    optionName:'HQ_SUBDOMAIN',
    default:'hq',
    doesValidate:fn($passedValueToBeValidated) => strlen($passedValueToBeValidated) < 32,
    transformInputToInternal:fn($passedValidatedValue) => strtolower($passedValidatedValue)
);
// delete if already there
jcmd("sed -i'.orig' '/HQ_SUBDOMAIN=.*$/d' .env");

# add new HQ_SUBDOMAIN to .env
jcmd("sed -i'.orig' '1s/^/HQ_SUBDOMAIN={$HQ_SUBDOMAIN}\\n/' .env");



# Tenant Middleware ----------------------------------------------------------------------------------------------------------------------------------------------------------------

/*
[ ] append to app/Http/Kernel.php' #WIP - was trying to get to autoregister
    protected $routeMiddleware = [...
        'tenancy' => Middleware\SubdomainTenancy::class
*/
$filePath = 'app/Http/Kernel.php';
$asrLines = file($filePath);
$newLineContent = "        'tenancy' => Middleware\SubdomainTenancy::class, // Added programmatically by Tall & Sassy \n";
foreach ($asrLines as $slot=>$lineContent) {
    if (str_contains($lineContent, 'protected $routeMiddleware = [')) {
        array_splice( $asrLines, $slot+1, 0, $newLineContent );
        $ret = file_put_contents($filePath, $asrLines);
        assert($ret);
        break;
    }
}


# Custom Homepage ------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Make homepage for users default to /me instead of /dashboard
$cmd =<<<EOF
sed -i'.orig' 's/\/dashboard/\/me/g' app/Providers/RouteServiceProvider.php
EOF;

jcmd(cmd:$cmd, bForceEcho: true);
/*// Change default home page
    app/Providers/RouteServiceProvider.php
    'str_replace("HOME = '/dashboard';", "HOME = '/me';", $file);
    (this might be better: https://laravel-news.com/override-login-redirects-in-jetstream-fortify)
*/

# Nix jetstreams unwanted UI ------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Keep the old stuff, for reference.  You could safely delete them
jcmd(cmd:'mkdir resources/views/jorig', bForceEcho: true);
jcmd(cmd:'mv resources/views/auth resources/views/jorig', bForceEcho: true);
jcmd(cmd:'mv resources/views/profile resources/views/jorig', bForceEcho: true);
jcmd(cmd:'mv resources/views/teams resources/views/jorig', bForceEcho: true);


jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/auth resources/views', bForceEcho:true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/profile resources/views', bForceEcho:true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/teams resources/views', bForceEcho:true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/layouts/app.blade.php resources/views/layouts', bForceEcho:true);

//[] replace resources/view/auth,profile,team ????
//    mkdir resources/views/jorig
//    mv resources/views/auth resources/views/jorig
//    mv resources/views/profile resources/views/jorig
//    mv resources/views/teams resources/views/jorig
//
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/auth resources/views
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/profile resources/views
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/teams resources/views
//    cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/views/layouts/app.blade.php resources/views/layouts
//


# public/img/logos -----------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/public/img public/img', bForceEcho: true);


# fix tail/jit beta  ---------------------------------------------------------------------------------------------------------------------------------------------------------------
// [ ] This is not compatible with tail/jit Beta (6/30/21')
//    In 'tailwind.config.js' disable jit like this--> // mode: 'jit'
$cmd =<<<EOF
sed -i'.orig' "s/\mode: 'jit'/\/\/mode: 'jit' /" tailwind.config.js
EOF;

jcmd(cmd:$cmd, bForceEcho: true);
jcmd(cmd:'cp -r vendor/tallandsassy/tallandsassy/PageGuide/page-guide/resources/public/img public/img', bForceEcho: true);


// Smoother routing  ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// nix the original
jcmd(cmd:'mv routes/web.php routes/web.php.orig', bForceEcho: true);
// use our own web.php, which has a special web-admin--routes.php --- anything there is force to admin-only
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web.stub routes/web.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web-admin--routes.stub routes/web-admin--routes.php', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/PageGuide/stubs/web-admin-people.stub routes/web-admin-people.php', bForceEcho: true);


// js  ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ToDO: Make better by searching for  webpack.mix.js and seeing how livewire, etc. does this
// [ ] Big webpack.mix.js stuff (TODO)\
jcmd(cmd:'mv webpack.mix.js webpack.mix.js.orig', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Ui/webpack.mix.js webpack.mix.js', bForceEcho: true);
jcmd(cmd:'cp vendor/tallandsassy/tallandsassy/Cms/resources/js/jckeditor.js resources/js/jckeditor.js', bForceEcho: true);

// Nudge the provider  -----------------------------------------------------------------------------------------------------------------------------------------------------------------
jcmd(cmd:'php artisan tassy-cms:install', bForceEcho: true);
jcmd(cmd:'php artisan tassy-page-guide:install', bForceEcho: true);
jcmd(cmd:'npm install', bForceEcho: true);
jcmd(cmd:'npm run dev', bForceEcho: true);




// ------------ After this - it is just some utilities that help us install laravel ------
function getOptionalOption(string $optionName, mixed $default, Closure $doesValidate, Closure $transformInputToInternal): mixed {
    $options = getopt('', ["{$optionName}:"]);
    if (empty($options)) {
        return $default;
    }
    assert(count($options)==1,"You must specify --{$optionName}=blah");
    $input_value = $options[$optionName];
    assert($doesValidate($input_value));
    $native_value = $transformInputToInternal($input_value);
    return $native_value;
}
function getRequiredOption(string $optionName): string {
    $options = getopt('', ["{$optionName}:"]);
    assert(!empty($options),"You must specify --{$optionName}");
    assert(count($options)==1,"You must specify --{$optionName}=blah");
    return $options[$optionName];
}
function getMakeDirCmd(): string
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $mkdirExec = 'mkdir';
    } else {
        $mkdirExec = 'mkdir -p';
    }
    return $mkdirExec;
}

function is_windows() {
    $test_is_windows = getenv( 'WP_CLI_TEST_IS_WINDOWS' );
    return false !== $test_is_windows ? (bool) $test_is_windows : strtoupper( substr( PHP_OS, 0, 3 ) ) === 'WIN';
}

function tempdir(int $mode = 0700, bool $auto_delete = true): string
{
    do {
        $tmp = tempnam(sys_get_temp_dir(), '') . uniqid();
    } while (!mkdir($tmp, $mode));

    if ($auto_delete) {
        register_shutdown_function(function () use ($tmp) {
            destroydir($tmp);
        });
    }
    return $tmp;
}

// Deletes a non-empty directory
function destroydir(string $dir): bool
{
    if (!is_dir($dir)) {
        return false;
    }

    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        if (is_dir("$dir/$file")) {
            destroydir("$dir/$file");
        } else {
            unlink("$dir/$file");
        }
    }
    return rmdir($dir);
}

function jcmd(string $cmd, bool $bForceEcho = false)
{
    exec($cmd, $output, $return);
    if ($bForceEcho) {
        if (!empty($output)) {
            print_r($output);
        } else {
            print "\n--- $cmd";
        }
    }

    if ($return != 0) {
        // an error occurred
        if (is_array($output)) {
            $output = var_export($output, true);
        }

        $s = "
Yikes: an error was generated when running:
$cmd

with error code: $return

and output: $output

";
    }
}
class Colors
{ //http://www.if-not-true-then-false.com/2010/php-class-for-coloring-php-command-line-cli-scripts-output-php-output-colorizing-using-bash-shell-colors/
    private $foreground_colors = array();
    private $background_colors = array();

    public function __construct()
    {
        // Set up shell colors
        $this->foreground_colors['black'] = '0;30';
        $this->foreground_colors['dark_gray'] = '1;30';
        $this->foreground_colors['blue'] = '0;34';
        $this->foreground_colors['light_blue'] = '1;34';
        $this->foreground_colors['green'] = '0;32';
        $this->foreground_colors['light_green'] = '1;32';
        $this->foreground_colors['cyan'] = '0;36';
        $this->foreground_colors['light_cyan'] = '1;36';
        $this->foreground_colors['red'] = '0;31';
        $this->foreground_colors['light_red'] = '1;31';
        $this->foreground_colors['purple'] = '0;35';
        $this->foreground_colors['light_purple'] = '1;35';
        $this->foreground_colors['brown'] = '0;33';
        $this->foreground_colors['yellow'] = '1;33';
        $this->foreground_colors['light_gray'] = '0;37';
        $this->foreground_colors['white'] = '1;37';

        $this->background_colors['black'] = '40';
        $this->background_colors['red'] = '41';
        $this->background_colors['green'] = '42';
        $this->background_colors['yellow'] = '43';
        $this->background_colors['blue'] = '44';
        $this->background_colors['magenta'] = '45';
        $this->background_colors['cyan'] = '46';
        $this->background_colors['light_gray'] = '47';
    }

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null)
    {
        $colored_string = "";

        // Check if given foreground color found
        if (isset($this->foreground_colors[$foreground_color])) {
            $colored_string .= "\033[" . $this->foreground_colors[$foreground_color] . "m";
        }
        // Check if given background color found
        if (isset($this->background_colors[$background_color])) {
            $colored_string .= "\033[" . $this->background_colors[$background_color] . "m";
        }

        // Add string and end coloring
        $colored_string .= $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors()
    {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors()
    {
        return array_keys($this->background_colors);
    }
}