<?php
$c = new Colors();
if (!(isSettableOptionSet('DB_USERNAME') && isSettableOptionSet('DB_PASSWORD') && isSettableOptionSet('APP_NAME'))) {

    echo "\n";
    echo $c->getColoredString("\n\nYou are missing stuff. Try something like this  ", 'red');
    echo $c->getColoredString("\n   php INSTALL_FULL_DEMO.php --DB_USERNAME=root --DB_PASSWORD=ofallevil  --APP_NAME=TassyTest001  ", 'green');
    echo "\n";
    echo "\n";
    exit(-1);
}
$TASSY_TENANCY_HQSUBDOMAIN = 'hq';
$TASSY_TENANCY_ADMINEMAIL = 'bob@gmail.com';

$DB_USERNAME = getRequiredOption(optionName: 'DB_USERNAME');
$DB_PASSWORD = getRequiredOption(optionName: 'DB_PASSWORD');
$APP_NAME = getRequiredOption(optionName: 'APP_NAME');
$DO_FORCE_REINSTALL = getOptionalOption(
    optionName: 'DO_FORCE_REINSTALL',
    default: 0,
    doesValidate: fn($passedValueToBeValidated) => in_array($passedValueToBeValidated, ['0', '1']),
    transformInputToInternal: fn($passedValidatedValue) => $passedValidatedValue,

);
// Get INSTALL_1_Laravel.php (https://stackoverflow.com/a/45514197/93933)
if (! file_exists('INSTALL_1_Laravel.php')) {
    jcmd(cmd: "curl -LJO  https://raw.githubusercontent.com/TallAndSassy/TallAndSassy/main/bin/demo/INSTALL_1_Laravel.php", bForceEcho: true, doDieOnFailure: true);
}
// Install Tassy & Demo & start server
jcmd(cmd: " \
    php INSTALL_1_Laravel.php --DB_USERNAME='{$DB_USERNAME}' --DB_PASSWORD='$DB_PASSWORD' --APP_NAME='{$APP_NAME}' \ 
    && \ 
    cd {$APP_NAME} \ 
    && \ 
    ls -1 \ 
    && \ 
    composer require tallandsassy/tallandsassy:dev-main \ 
    && \ 
    php vendor/tallandsassy/tallandsassy/bin/INSTALL_2_Tassy.php --TASSY_TENANCY_HQSUBDOMAIN={$TASSY_TENANCY_HQSUBDOMAIN} --TASSY_TENANCY_ADMINEMAIL={$TASSY_TENANCY_ADMINEMAIL} \
    && \ 
    php vendor/tallandsassy/tallandsassy/bin/demo/INSTALL_3_Demo.php \
    ", doDieOnFailure: true, bForceEcho: true);


echo "\n";

echo $c->getColoredString("\n\nPlease visit your site. Point to browser to something like  ", 'red');
echo $c->getColoredString("\n    php {$APP_NAME}/artisan serve --host=localhost   ", 'green');
echo "\n";
echo "\n";
echo $c->getColoredString("\n\nPlease visit your site. Point to browser to something like  ", 'red');
echo $c->getColoredString("\n   localhost:8000   ", 'green');
echo " (Your port might change. See the output above.)";
echo "\n";
echo "\n";

# At this point, laravel should be installed and basically working.
# Nothing before this line should be different than a typical laravel project

// ------------ After this - it is just some utilities that help us install laravel ------
function getOptionalOption(string $optionName, mixed $default, Closure $doesValidate, Closure $transformInputToInternal): mixed
{
    $options = getopt('', ["{$optionName}:"]);
    if (empty($options)) {
        return $default;
    }
    assert(count($options) == 1, "You must specify --{$optionName}=blah");
    $input_value = $options[$optionName];
    assert($doesValidate($input_value));
    $native_value = $transformInputToInternal($input_value);
    return $native_value;
}

function isSettableOptionSet(string $optionName): bool
{
    $options = getopt('', ["{$optionName}:"]);
    return (!empty($options) && count($options) == 1);
}

function getRequiredOption(string $optionName): string
{
    $options = getopt('', ["{$optionName}:"]);
    assert(!empty($options), "You must specify --{$optionName}");
    assert(count($options) == 1, "You must specify --{$optionName}=blah");
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

function is_windows()
{
    $test_is_windows = getenv('WP_CLI_TEST_IS_WINDOWS');
    return false !== $test_is_windows ? (bool)$test_is_windows : strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
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

function jcmd(string $cmd, bool $doDieOnFailure,  bool $bForceEcho)
{
    exec($cmd, $output, $return);
    if ($bForceEcho) {
        print_r($output);
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
        exit($return);
    }
    return $return;
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