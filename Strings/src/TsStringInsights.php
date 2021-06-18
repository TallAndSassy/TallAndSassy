<?php
declare(strict_types=1);

namespace TallAndSassy\Strings;

class TsStringInsights {
    public static function BeginsWith(string  $the_whole_string,  string $the_little_test_string ): bool {
        // use str_starts_with in php 8
        return ( substr( $the_whole_string, 0, strlen( $the_little_test_string ) ) == $the_little_test_string );
    }

    public static function EndsWith(string $the_whole_string, string $the_little_test_string ): bool {
        return ( substr( $the_whole_string, strlen( $the_whole_string ) - strlen( $the_little_test_string ) ) == $the_little_test_string );
    }

}
