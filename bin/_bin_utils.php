<?php


// ------------ After this - it is just some utilities that help us install laravel ------
function getOptionalOption(string $optionName, mixed $default, Closure $doesValidate, Closure $transformInputToInternal, bool $doEcho): mixed {
    $options = getopt('', ["{$optionName}:"]);
    $isDefaulting = false;
    if (empty($options)) {
        $native_value = $default;
        $isDefaulting = true;
    } else {
        $isDefaulting = false;
        assert(count($options) == 1, "You must specify --{$optionName}=blah");
        $input_value = $options[$optionName];
        assert($doesValidate($input_value));
        $native_value = $transformInputToInternal($input_value);
    }
    if ($doEcho) {
        if ($isDefaulting) {
            print "\n option --'$optionName' defaulted to '$default'";
        } else {
            print "\n option --'$optionName' set to '$input_value'";
            if ($input_value != $native_value) {
                print " and transformed to: '$native_value";
            }
        }
        print "\n";
    }
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
        print "--- $cmd\n";
        if (!empty($output)) {
            print_r($output);
            print "--- $cmd\n";
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

/* it would be easy to combine these with appendLine, replaceLine enum, but meh */
function commentOutLineWithStuff(string $filePath, string $contentToFindInALine,  bool $doDieOnNoMatch, bool $bForceEcho): bool
{
    $contentToInsertAfterFoundLine = '// '.$contentToFindInALine;
    if ($bForceEcho) {
        print "\ncommentOutLineWithStuff in file '$filePath'";
        print "\n  Looking for '$contentToFindInALine'";

    }
    $asrLines = file($filePath);
    assert($asrLines !== false, "Could not open needed file: $filePath");
    foreach ($asrLines as $slot=>$lineContent) {
        if (str_contains($lineContent, $contentToFindInALine)) {
            // Don't add it twice (maybe make an option if needed in the future)
            $offsetForInsert = $slot + 0;
            if (isset($asrLines[$offsetForInsert]) &&  str_starts_with(trim($asrLines[$offsetForInsert]), '//')) {
                print "\n  Good-Enough: The content already commented out at line $offsetForInsert";
            } else {
                $asrLines[$offsetForInsert] = '// removed by commentOutLineWithStuff '.$asrLines[$offsetForInsert];

                $ret = file_put_contents($filePath, $asrLines);
                assert($ret);
                print "\n  Success: Inserted after line $slot";
            }
            return true;
            break;
        }
    }
    print "\n  FAILED: Did not find the content";
    return false;
}

/*  it won't re-insert if the first line of $contentToInsertAfterFoundLine matches the first line after $contentToFindInALine (trimmed)
    It will trim  $contentToInsertAfterFoundLine cuz it otherwise makes it a hassle to detect duplication
*/
function insertAfter(string $filePath, string $contentToFindInALine, string $contentToInsertAfterFoundLine, bool $bForceEcho): bool {
    $contentToInsertAfterFoundLine = trim($contentToInsertAfterFoundLine);
    $contentToInsertAfterFoundLine_Excerpt = preg_split("/\r\n|\n|\r/", trim($contentToInsertAfterFoundLine))[0];//https://stackoverflow.com/a/11165332/93933
    if ($bForceEcho) {
        print "\ninsertAfter in file '$filePath'";
        print "\n  Looking for '$contentToFindInALine'";
        print "\n  So can add '$contentToInsertAfterFoundLine_Excerpt'...";
    }
    $asrLines = file($filePath);
    $matchAsDuplicate = trim($contentToInsertAfterFoundLine);
    foreach ($asrLines as $slot=>$lineContent) {
        if (str_contains($lineContent, $contentToFindInALine)) {
            // Don't add it twice (maybe make an option if needed in the future)
            $offsetForInsert = $slot + 1;
            $trimmedNextLine = trim($asrLines[$offsetForInsert]);
            if (isset($asrLines[$offsetForInsert]) &&  ($trimmedNextLine != '') && str_starts_with( $matchAsDuplicate, $trimmedNextLine)) {
                print "\n  Good-Enough: The content already existed after line $offsetForInsert. '$contentToInsertAfterFoundLine_Excerpt' starts`$trimmedNextLine` ";
            } else {
                array_splice($asrLines, $offsetForInsert, 0, $contentToInsertAfterFoundLine . "\n");
                $ret = file_put_contents($filePath, $asrLines);
                assert($ret);
                print "\n  Success: Inserted after line $slot. matchAsDuplicate($contentToInsertAfterFoundLine_Excerpt), trimmedNextLine($trimmedNextLine)";
            }
            return true;
            break;
        }
    }
    print "\n  FAILED: Did not find the content";
    return false;
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