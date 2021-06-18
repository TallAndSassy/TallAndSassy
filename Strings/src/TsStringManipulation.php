<?php
declare(strict_types=1);

namespace TallAndSassy\Strings;

class TsStringManipulation {
    public static function TrimOffFront( string $the_whole_string,string|int $x_characters_or_substring ): string {
        if(is_numeric( $x_characters_or_substring ) )
            return substr( $the_whole_string, $x_characters_or_substring );
        else
            return substr( $the_whole_string, strlen( $x_characters_or_substring ) );
    }

    /***************************************************************
     *
     *
     * trims off x chars from the end of a string
     * or the matching string in $off is trimmed off
     * @returns string
     */
    public static function TrimOffEnd(string $the_whole_string, string|int  $x_characters_or_substring): string {
        if( is_numeric( $x_characters_or_substring ) )
            return substr( $the_whole_string, 0, strlen( $the_whole_string ) - $x_characters_or_substring );
        else
            return substr( $the_whole_string, 0, strlen( $the_whole_string ) - strlen( $x_characters_or_substring ) );
    }

}
