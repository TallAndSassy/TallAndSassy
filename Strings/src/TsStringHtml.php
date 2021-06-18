<?php
declare(strict_types=1);

namespace TallAndSassy\Strings;

class TsStringHtml {
    /***************************************************************
     * ADVANCED/Obscure
     * @input:
     * 	 		 $aSourceString = a bunch of html
     * 	 		 $aTagName - tags and blocks you want to remove from the html
     * 	 		@motivation: pinEdit, and rich html editor returns a fully html page, including <html><head><title></titlle></head><body></body>, etc.
     * 	 					if you just want the html that is inside the body, this public static function might be useful, but nixing the head tag.
     * 	 		@example: see 'debug'
     * 	 					$a = removeHTMLblock("<html><head><title>a HW example</title></head><body>Hello World</body></html>","head");
     * 	 					$a  <--- now $a is: <html><body>Hello World</body></html>
     *
     * 	 		@history: snaked from the javascript snippet at: http://www.mikezilla.com/exp0032.html
     * 	 			public static function removeHTMLblock(aSourceString, aTagName){
     * 	 				regexp= new RegExp ("<" + aTagName + "[^.]*\/" + aTagName + ">", "gi");
     * 	 				vStrippedHTML = aSourceString.replace(regexp,"");
     * 	 				alert(vStrippedHTML);
     * 	 			}
     * @warning: probably a smarter w
     */
    public static function RemoveHtmlBlock($aSourceString, $aTagName_no_brackets){
        //---
        $aTagName_no_brackets_can_be_array = $aTagName_no_brackets;
        $arrTageNames = (is_array($aTagName_no_brackets_can_be_array)) ? $aTagName_no_brackets_can_be_array : array($aTagName_no_brackets_can_be_array);
        foreach ($arrTageNames as $tag) {
            $aSourceString = preg_replace("/<" . $tag . ">(.|\s)*?<\/" . $tag . ">/","",$aSourceString);
        }
        //--- wrap-up
        return $aSourceString;
    }
    /**
     * @motivation: clean user input. There is certainly a smarter way, but I'm on a plain.
     */
    public static function ScrubScriptDangers($sourceHtml): string {
        return static::RemoveHtmlBlock($sourceHtml, 'script');
    }

    public static function strip_tags(string $sourceHtml, array|string $allowed_tags = []): string {
        return strip_tags($sourceHtml, $allowed_tags);
    }
}
