<?php
declare(strict_types=1);

namespace TallAndSassy\Strings;

class TsStringConvertCase {

    public static function SplitCamelCase($camelCaseStringAndMaybeEvenStartingWithCapital) {
        /*
         * Input:

oneTwoThreeFour
StartsWithCap
hasConsecutiveCAPS
camel_caseRocks -->camel case Rocks

Output:

Word 1 of 4 = "one"
Word 2 of 4 = "Two"
Word 3 of 4 = "Three"
Word 4 of 4 = "Four"

Word 1 of 3 = "Starts"
Word 2 of 3 = "With"
Word 3 of 3 = "Cap"

Word 1 of 3 = "has"
Word 2 of 3 = "Consecutive"
Word 3 of 3 = "CAPS"

        http://stackoverflow.com/a/7729790/93933

         */
        $arrExploded = array();
        $ccWord = $camelCaseStringAndMaybeEvenStartingWithCapital;
        $re = '/# Match position between camelCase "words".
    (?<=[a-z])  # Position is after a lowercase,
    (?=[A-Z])   # and before an uppercase letter.
    /x';
        $a = preg_split($re, $ccWord);
        $count = count($a);
        for ($i = 0; $i < $count; ++$i) {
            $ArrWordsExplodedAtPossible_underscores = explode("_",$a[$i]);
            foreach ($ArrWordsExplodedAtPossible_underscores as $wordsExplodedFurtherExplodedAtUnderscore){
                $arrExploded[] = $wordsExplodedFurtherExplodedAtUnderscore;
            }


            #$arrExploded[] = $a[$i];
//            printf("Word %d of %d = \"%s\"\n",
//                   $i + 1, $count, $a[$i]);
        }

        return $arrExploded;
    }

    /*
     * known limitation: 7/14' - passing etrichplugin to eliminate the prefix EtRichPlug_users (because you want to see 'users') doesn't work.
     */
    public static function CamelCaseToEnglishTypical($camelCaseStringAndMaybeEvenStartingWithCapital, $arrMoreUglyThingsAllInLowerCaseOptional=null) {
        $arrUglyThings = ['cls','class','obj','object'];
        if (!is_null($arrMoreUglyThingsAllInLowerCaseOptional)) {
            $arrUglyThings = array_merge($arrUglyThings,$arrMoreUglyThingsAllInLowerCaseOptional);

        }
        return static::CamelCaseToEnglish($camelCaseStringAndMaybeEvenStartingWithCapital,$arrUglyThings,true);
    }



    static $arrWordsNotTypicallyCapitalizedWhenNotAtFrontOfTitles = [
        'a','an','of','the','and', 'but', 'or', 'for', 'nor','on', 'at', 'to', 'from', 'by',//https://grammar.yourdictionary.com/capitalization/rules-for-capitalization-in-titles.html
    ];
    //    private static function beginsWith( $the_whole_string, $the_little_test_sring ) {
    //        // use str_starts_with in php 8
    //        return ( substr( $the_whole_string, 0, strlen( $the_little_test_sring ) ) == $the_little_test_sring );
    //    }
    //    private static function trimOffFront( $the_whole_string, $x_characters_or_substring ) {
    //        if(is_numeric( $x_characters_or_substring ) )
    //            return substr( $the_whole_string, $x_characters_or_substring );
    //        else
    //            return substr( $the_whole_string, strlen( $x_characters_or_substring ) );
    //    }
    public static function CamelCaseToEnglish($camelCaseStringAndMaybeEvenStartingWithCapital, $arrOfCaseLowerCaseThingsToDeleteLikeClsOrObj=null, $beTitleCaseLikeForBooks = false) {
        /* turn objNominallyScheduledPeriod into Nominally Scheduled Period
        usage:
        $defaultPrettyNameOne = static::CamelCaseToEnglish($nameSpace,['cls','obj']);
        $defaultPrettyNameMany = static::singularToPlural($defaultPrettyNameOne);
        FYI: This deletes leading underscores

        */
        if (is_null($arrOfCaseLowerCaseThingsToDeleteLikeClsOrObj)) {
            $arrOfCaseLowerCaseThingsToDeleteLikeClsOrObj = array();
        }

        $arrParts = static::SplitCamelCase($camelCaseStringAndMaybeEvenStartingWithCapital);

        foreach ($arrParts as $slot=>$part) { // nix leading underscores and make all first letters capital
            if (TsStringInsights::beginsWith($part,'_')) { // use str_starts_with in php 8
                $arrParts[$slot] = TsStringManipulation::trimOffFront($part,'_');
            }
            if (TsStringInsights::beginsWith($part,'__')) {
                $arrParts[$slot] = TsStringManipulation::trimOffFront($part,'__');
            }


            $arrParts[$slot] = ucfirst($arrParts[$slot]);
            if ($slot != 0 && in_array(lcfirst($arrParts[$slot]), static::$arrWordsNotTypicallyCapitalizedWhenNotAtFrontOfTitles))  {
                $arrParts[$slot] = lcfirst($arrParts[$slot]);
            }

        }
        foreach ($arrParts as $slot=>$part) {
            if (in_array(strtolower($arrParts[$slot]), $arrOfCaseLowerCaseThingsToDeleteLikeClsOrObj) ) {
                unset($arrParts[$slot]);
            }

        }
        $defaultPrettyName = implode(" ", $arrParts);
        return $defaultPrettyName;
    }
}
