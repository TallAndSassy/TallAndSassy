<?php
namespace TallAndSassy\PageGuide;

/* Simple way to construct a menu, from top to bottom.
    Future: Allow for insertion
    Future: Move to overridable components
*/

use JetBrains\PhpStorm\Pure;

class MenuTree # implements #\Iterator
{
    #private $topMenu = [];
    public $asrMenus = [];
    #public $arr = [1,2,3,4,5];
    #private $currentRoute;
    private static array $mes = [];
    #private static string $lastSingletonKey; // ??? needed?
    # private static string $lastTopHandle;
    #private static string $lastChildHandle;
    public string $handle;


    //    public function __construct()
    //    {
    //    }

    public static function singleton(string $handle) : MenuTree
    {
        if (! isset(static::$mes[$handle])) {
            static::$mes[$handle] = new MenuTree();
            static::$mes[$handle]->handle = $handle;
        }

        #static::$lastSingletonKey = $handle;
        return static::$mes[$handle];
    }

    public function pushTop(string $handle, string $Label, ?string $SvgHtml, ?string $IconName, ?string $urlIfNoFurtherChildren_nullIfGroup, ?string $IconSizingClasses = null): MenuTree
    {
        $this->asrMenus[$handle] = [
            'Label' => $Label,
            'SvgHtml' => $SvgHtml,
            'IconName' => $IconName,
            'Url' => $urlIfNoFurtherChildren_nullIfGroup,
            #'Children' => [],
            'Handle' => $handle,
            'EnumType' => 'Top',
            'IconSizingClasses' => $IconSizingClasses,
        ];
        #$this->currentRoute = $currentRoute_short;
        #static::$lastTopHandle = $handle;

        return $this;
    }

    /* if the handle doesn't exist, push it, otherwise, continue on as no-op */
    public function ensureTop(string $handle, string $Label, ?string $SvgHtml, ?string $IconName, ?string $urlIfNoFurtherChildren_nullIfGroup, ?string $IconSizingClasses = null): MenuTree
    {
        if (! isset($this->asrMenus[$handle])) {
            $this->asrMenus[$handle] = [
                'Label' => $Label,
                'SvgHtml' => $SvgHtml,
                'IconName' => $IconName,
                'Url' => $urlIfNoFurtherChildren_nullIfGroup,
                #'Children' => [],
                'Handle' => $handle,
                'EnumType' => 'Top',
                'IconSizingClasses' => $IconSizingClasses,
            ];
            #$this->currentRoute = $currentRoute_short;
            #static::$lastTopHandle = $handle;
        }

        return $this;
    }

    public function pushLinkViaMenuInterface(MenuItem_Vlto $menuish): self {
        return $this->pushLink(handle: $menuish->handle, Label: $menuish->Label, url:$menuish->url);
    }
    public function pushLink(string $handle, string $Label, string $url)
    {
        $this->asrMenus[$handle] = [
            'Label' => $Label,
            'Url' => $url,
            'EnumType' => 'Link',
            'Handle' => $handle,
        ];
        #static::$lastChildHandle = $handle;
        //        $this->asrMenus[] = [
        //            'Label' => $Label,
        //            'Url' => $url,
        //            'EnumType' => 'Link',
        //        ];

        return $this;
    }

    public function pushGroup(string $handle, string $Label)
    {
        #static::$lastChildHandle = $handle;
        $this->asrMenus[$handle] = [
            'Label' => $Label,
            'Url' => null,
            'EnumType' => 'Group',
            'Handle' => $handle,
        ];

        //        $this->asrMenus[] = [
        //            'Label' => $Label,
        //            'EnumType' => 'Group',
        //        ];

        return $this;
    }
    public static function isTop(array $menuEntry) : bool
    {
        return $menuEntry['EnumType'] == 'Top';
    }
    public static function isTopNode(array $menuEntry) : bool
    {
        return ($menuEntry['EnumType'] == 'Top' && is_null($menuEntry['Url']));
    }
    public static function isTopLeaf(array $menuEntry) : bool
    {
        return ($menuEntry['EnumType'] == 'Top' && ! is_null($menuEntry['Url']));
    }
    public static function isLink(array $menuEntry) : bool
    {
        return $menuEntry['EnumType'] == 'Link';
    }
    public static function isGroup(array $menuEntry) : bool
    {
        return $menuEntry['EnumType'] == 'Group';
    }

    //    private function isCurrentRouteInThisMainMenu() : bool
    //    {
    //        foreach ($this->asrMenus as $asrMenu) {
    //            $routesMatch = $this->isOnThisRoute($asrMenu);
    //
    //            if ($routesMatch) {
    //                return true;
    //            }
    //        }
    //
    //        return false;
    //    }

    public static function isOnThisRoute(array $asrMenu) : bool
    {
        // request()->getPathInfo(): http://127.0.0.1:8001/admin/about?id=1 ==> "/admin/about"
        if (empty($asrMenu['Url'])) {
            return false;
        }

        return (strpos(request()->getPathInfo(), $asrMenu['Url']) === 0);
    }
    public static function IsSubUrlMeOrBelow(string $suburl) : bool
    {
        return str_starts_with(request()->getPathInfo(), $suburl);
    }

    //--- Brute Force expanding of tree -begin- ------------------------------------------------------------------------
    /* So, This whole menus being dynamic isn't great. This is to help brute create a new menu via simple blade
        But, it needs to know if we are rendering the current menu tree.  This is pretty much going against
        the other menu tree stuff.  But I think this all got too complicated. Many alpine.js v3 is the future?

        Usage: call this in your blade that generates a bunch of menu items. That is where you will know if where
        you are rendering.
        Know/expected limitatin: When you go back to ajax page rendering.. it won't(?) know?  Hmm, livewire maybe?
    */
    static private string $_CurrentMenuHandle_forRouteWeAreVisiting = 'tbd';
    public static function SetMenuHandle_forRouteWeAreVisiting(string $menuHandleForCurrentRoute): void {
        static::$_CurrentMenuHandle_forRouteWeAreVisiting = $menuHandleForCurrentRoute;
    }
    
    #[Pure]
    public static function GetMenuHandle_forRouteWeAreVisiting(): string {
        return static::$_CurrentMenuHandle_forRouteWeAreVisiting;
    }

    #[Pure]
    public static function IsThisTheSameMenuHandle_asRouteWeAreVisiting(string $menuHandleThatWeAreWonderingIfMatchesRouteWeAreVisiting): bool {
        return static::GetMenuHandle_forRouteWeAreVisiting() == $menuHandleThatWeAreWonderingIfMatchesRouteWeAreVisiting;
    }
    //--- Brute Force expanding of tree -END- ------------------------------------------------------------------------


    public function isActiveRouteUnderMe(array $asrMenu) : bool
    {
        assert(static:: isTopNode($asrMenu));
        // walk from me, to next non-top menu item
        $arrKeys = array_keys($this->asrMenus);
        $myKeySlot = array_search($asrMenu['Handle'], $arrKeys, true);
        $lastPossibleKeySlot = count($arrKeys) - 1;
        for ($i = $myKeySlot + 1; $i <= $lastPossibleKeySlot; $i++) {
            $theHandle = $arrKeys[$i];
            $theMenuEntry = $this->asrMenus[$theHandle];
            if (static::isTop($theMenuEntry)) {
                return false;
            }
            if (static::isOnThisRoute($theMenuEntry)) {
                return true;
            }
        }

        return false;
    }
    //    private function getSubMenuExtraClasses(array $asrMenu): string
    //    {
    //        $routesMatch = $this->isOnThisRoute($asrMenu);
    //        if ($routesMatch) {
    //            return 'font-extrabold text-lg';
    //        }
    //
    //        return '';
    //    }

    //    // Walk the menu
    //    public function rewind()
    //    {
    //        echo "rewinding\n";
    //        reset($this->asrMenus);
    //    }
    //
    //    public function current()
    //    {
    //        $var = current($this->asrMenus);
    //        #echo "current: $var\n";
    //        return $var;
    //    }
    //
    //    public function key()
    //    {
    //        $var = key($this->asrMenus);
    //        #dd($var);
    //        #echo "key: $var\n";
    //        return $var;
    //    }
    //
    //    public function next()
    //    {
    //        $var = next($this->asrMenus);
    //        #echo "next: $var\n";
    //        return $var;
    //    }
    //
    //    public function valid()
    //    {
    //        return ! is_null(key($this->asrMenus));
    //        $key = key($this->asrMenus);
    //        $var = ($key !== null && $key !== false);
    //        #echo "valid: $var\n";
    //        return $var;
    //    }

    /* Render whole menu
    Future: Build from user-stylable components
    */
    public function getHtml(array $arrAttributes = ['class' => '']) : string
    {

        return view('tassy::admin.menutree', [
            'menutree' => $this,
            'arrAttributes' => $arrAttributes,
            'handle'=>$this->handle
        ])->render();
        //        foreach ($this->topMenu as $top) {
        //            $Label = $top['Label'];
        //            $SvgHtml = $top['SvgHtml'];
        //            $urlIfNoFurtherChildren = $top['Url'];
        //            $extraClassInfo = $this->getSubMenuExtraClasses($top);
        //            if (! $urlIfNoFurtherChildren) {
        //                $t = <<<EOD
        //            <div class="-ml-4 -mt-0">
        //                <h3 class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline $extraClassInfo">
        //                    %s
        //                    <span class="sidebar-label  text-white mt-1 pl-1">
        //                    %s
        //                    </span>
        //                </h3>
        //            </div>
        //            EOD;
        //                $summary = sprintf($t, $SvgHtml, $Label);
        //            } else {
        //                $t = <<<EOD
        //            <div class="-ml-4  -mt-4">
        //                <h3 class="cursor-pointer flex items-center font-normal dim text-white mb-6 text-base no-underline $extraClassInfo">
        //                    <a href="%s" class="no-underline">%s
        //                    <span class="sidebar-label text-white mt-1 pl-1 -ml-3">
        //                    %s
        //                    </a>
        //                    </span>
        //                </h3>
        //            </div>
        //            EOD;
        //                $summary = sprintf($t, $urlIfNoFurtherChildren, $SvgHtml, $Label);
        //            }
        //
        //
        //            $html = <<<EOD
        //        <div class="-ml-3 -mt-3">
        //        EOD;
        //            $html .= <<<EOD
        //        <ul class="list-none -ml-3">
        //        EOD;
        //            #foreach ($this->asrMenus as $slot=>$asrMenu) {
        //            for ($i = 0; $i < count($this->asrMenus); $i++) {
        //                $asrMenu = $this->asrMenus[$i];
        //                $label = $asrMenu['Label'];
        //                $html .= <<<EOD
        //            <li class="-ml-1 leading-wide mb-2 text-sm ">
        //            EOD;
        //
        //                if ($asrMenu['EnumType'] == 'Link') {
        //                    $url = $asrMenu['Url'];
        //                    $extraClassInfo = $this->getSubMenuExtraClasses($asrMenu);
        //                    $t = <<<EOD
        //                    <a href="$url" class="ml-1 text-white no-underline dim block -sidebar-label $extraClassInfo">
        //                        <span class="">$label</span>
        //                    </a>
        //
        //                EOD;
        //                    $html .= $t;
        //                }
        //                if ($asrMenu['EnumType'] == 'Group') {
        //                    $t = <<<EOD
        //                 <span class="ml-1 text-base font-bold text-white-50" style="color:#97a6ba">$label</span>
        //                    <ul class="list-disc -ml-6 mt-2">
        //                EOD;
        //                    for ($j = ($i + 1); $j < count($this->asrMenus); $j++) {
        //                        $asrMenu = $this->asrMenus[$j];
        //
        //                        $label = $asrMenu['Label'];
        //                        $EnumType = $asrMenu['EnumType'];
        //                        if ($EnumType == 'Link') {
        //                            $extraClassInfo = $this->getSubMenuExtraClasses($asrMenu);
        //                            $t .= <<<EOD
        //                        <li class="  leading-wide mb-2 text-sm">
        //                            <a href="" class="text-white -ml-1 no-underline dim block sidebar-label $extraClassInfo">
        //                            $label
        //                            </a>
        //                        </li>
        //                        EOD;
        //                        } else {
        //                            $i = $j - 1;
        //
        //                            break;
        //                        }
        //                        $i = $j;
        //                    }
        //
        //                    $t .= "
        //                    </ul>";
        //                    $html .= $t;
        //                }
        //                $html .= "
        //            </li>";
        //            }
        //            $html .= "
        //        </ul>";
        //            $html .= "
        //        </div>";
        //
        //
        //            $idWHole = uniqid();
        //            if (! $urlIfNoFurtherChildren) {
        //                $attrOpenOrNot = $this->isCurrentRouteInThisMainMenu() ? " open " : '';
        //                $html = "<details $attrOpenOrNot id='$idWHole' class='jMenu'><summary >$summary</summary>$html</details>";
        //            } else {
        //                $html = $summary;
        //            }
        //        }
        //
        //        return $html;
    }
}
