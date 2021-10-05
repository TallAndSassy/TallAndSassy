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

$DB_USERNAME = getRequiredOption(optionName: 'DB_USERNAME');
$DB_PASSWORD = getRequiredOption(optionName: 'DB_PASSWORD');
$APP_NAME = getRequiredOption(optionName: 'APP_NAME');
$DO_FORCE_REINSTALL = getOptionalOption(
    optionName: 'DO_FORCE_REINSTALL',
    default: 0,
    doesValidate: fn($passedValueToBeValidated) => in_array($passedValueToBeValidated, ['0', '1']),
    transformInputToInternal: fn($passedValidatedValue) => $passedValidatedValue,

);
//jcmd(cmd:"php INSTALL_1_Laravel.php --DB_USERNAME='{$DB_USERNAME}' --DB_PASSWORD='$DB_PASSWORD' --APP_NAME='{$APP_NAME}' ", bForceEcho: true);
//jcmd(cmd:"cd $APP_NAME; & php vendor/tallandsassy/tallandsassy/INSTALL_2_Tassy.php & vendor/tallandsassy/tallandsassy/demo/INSTALL_3_Demo.php", bForceEcho: true);
jcmd(cmd:"php INSTALL_1_Laravel.php --DB_USERNAME='{$DB_USERNAME}' --DB_PASSWORD='$DB_PASSWORD' --APP_NAME='{$APP_NAME}' && cd {$APP_NAME} && ls -1 && composer require tallandsassy/tallandsassy:dev-main && php vendor/tallandsassy/tallandsassy/bin/INSTALL_2_Tassy.php && php vendor/tallandsassy/tallandsassy/bin/demo/INSTALL_3_Demo.php && php artisan serve --host=localhost", bForceEcho: true);


echo "\n";
echo $c->getColoredString("\n\nPlease start your web server by running  ", 'red');
echo $c->getColoredString("\n   php {$DIR_NAME}/artisan serve   ", 'green');
echo $c->getColoredString("\nand then visiting, in your browser (but tweak as needed, according the port actually used) ", 'red');
echo $c->getColoredString("\n   http://127.0.0.1:8000", 'green');
echo "\n";
echo "\n";
echo $c->getColoredString("\n  Next steps: Get the Tassy package", 'blue');
echo $c->getColoredString("\n   cd {$DIR_NAME}", 'green');
echo $c->getColoredString("\n   composer require tallandsassy/tallandsassy:dev-main", 'green');
echo "\n";
echo "\n";
echo $c->getColoredString("\n   Now continue with Tall & Sassy installation by running", 'red');
echo $c->getColoredString("\n   php vendor/tallandsassy/tallandsassy/bin/INSTALL_2_Tassy.php --HQ_SUBDOMAIN=st", 'green');
echo "\n";
echo "\n";
echo "\n";
echo $c->getColoredString("\n  Feeling Ambitious?: Try contributing to the project.", 'blue');
echo $c->getColoredString("\n   git clone https://github.com/TallAndSassy/TallAndSassy ", 'green');
echo $c->getColoredString("\n   cd  {$DIR_NAME}/vendor/tallandsassy", 'green');
echo $c->getColoredString("\n   rm -rf tallandsassy", 'green');
echo $c->getColoredString("\n   ln -s ../../../TallAndSassy tallandsassy", 'green');
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

function jcmd(string $cmd, bool $bForceEcho = false)
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