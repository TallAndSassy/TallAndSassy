<?php
/* ------- WIP -------- */

namespace TallAndSassy\PageGuide\Components;

use Livewire\Component;

abstract class LeSwappableChunk extends Component
{
    protected static string $chunkKey; // Override this if you want a default key. Leave unset if always dynamic
    public string $enumUrlType; // override this

    public function doSwap(string $chunkValue, string $chunkKey) // override and call me.
    {
JJ - you left off trying to understand the flow - I either want asrParams passed or derive them.
    You were working on the dev tabs and wanting the Summary tab to work
        assert(
            isset($this->pageRoute),
            " Ensure to set this->pageRoute when calling " . get_called_class() . " " . __FILE__ . __LINE__
        );

        if (!$this->justMounted) {
            $this->dispatchBrowserEvent(
                'le-swappable-chunk-swapped',
                [
                    'enumUrlType' => $this->enumUrlType,
                    'chunkKey' => $chunkKey,
                    'chunkValue' => $chunkValue,
                ]
            );
        }
        $this->didCallParent_updateLePageChunkRoute = true;
    }

    // --- Internal junk after this...
    public bool $justMounted = false;
    public string $pageRoute;# was public string $viewRef; // was pageRoute, but misnomer  Need viewRef & url
    public array $asrParams = [];// for the body - not used

    protected string $bladeTemplate = 'livewire.le-swappable-chunk';
    protected $bodyView;
    protected string $controllerName; // for the body - not used
    protected const  enumUrlType_allowedOptions = ['none', 'updateOrAdd'];

    /* Override if, and only if, you aren't specifying the key here
     {!! \App\Http\Livewire\TabPlayground\Breadcrumbs::wireSwaplinkInA('about')!!}
    -- you could instead do this if one controller is handling lots of chunks
    {!! \App\Http\Livewire\TabPlayground\Breadcrumbs::wireSwaplinkInA('about', 'preview')!!}
    {!! \App\Http\Livewire\TabPlayground\Breadcrumbs::wireSwaplinkInA('help', 'preview')!!}
    ...
    {!! \App\Http\Livewire\TabPlayground\Breadcrumbs::wireSwaplinkInA('hammer', 'tools')!!}
    {!! \App\Http\Livewire\TabPlayground\Breadcrumbs::wireSwaplinkInA('wrench', 'tools')!!}
    */
    public string $myKey; // hmmm, how is different from above?
    private bool $didCallParent_updateLePageChunkRoute = false;


    protected $listeners = [
        'LeSwappableChunk_doSwap' => 'doSwap',
    ];


    public function mount(string $defaultChunkValue, array $asrParams = [], ?string $chunkKey = null)
    {
        dd([__FILE__,__LINE__,__METHOD__,get_defined_vars()]);
        $this->asrParams = $asrParams;
        assert(
            isset($this->enumUrlType),
            "We are mounting " . get_called_class() . " but \$this->enumUrlType isn't set"
        );
        assert(in_array($this->enumUrlType, static::enumUrlType_allowedOptions));


        // If we are a solo chunk controller with a default - store t
        if ($chunkKey) {
            $this->myKey = $chunkKey;
        } else {
            assert(
                !empty(static::$chunkKey),
                __FILE__ . __LINE__ . " please set protected static string \$keyForThisChunk = 'crumb'; to something"
            );
            $this->myKey = static::$chunkKey;
        }

        // bookkeeping (might be useful to someone)
        $this->justMounted = true;


        // Load initial chunk (either the default, or the one set in the url)
        $isDirectLoad = isset($_SERVER['PATH_INFO']);// Warning: not sure this is trustworthy
        // if(app('request')->ajax())... this is not relevant here... Always shows 'not ajax'

        if ($isDirectLoad) {
            $asrUrlKeyVals = static::subLevels2asrParams($_SERVER['PATH_INFO']);
            if (isset($asrUrlKeyVals[$this->myKey])) {
                $this->doSwap($asrUrlKeyVals[$this->myKey], $this->myKey);
            } else {
                $this->doSwap($defaultChunkValue, $this->myKey);
            }
        } else {
            $this->doSwap($defaultChunkValue, $this->myKey);
        }
        assert(
            isset($this->pageRoute),
            "We initialized " . get_called_class(
            ) . "::doSwap but \$this->pageRoute didn't get set as expected. " . __FILE__ . __LINE__
        );
    }


    protected function FailOnDeadView($view)
    {
        if (!view()->exists($view)) {
            abort(404);
        }
    }


    protected function produceBodyView_fromRoute($route)
    {
        # FYI: $tailingUrl = $request->path(); //http://domain.com/foo/bar, the path method will return foo/bar
        // If refreshing, the params need to be put back into the url.  Probably should have just stored it. oh well.
        // what is this, really?  old flotsam?
        $reconstructedUrl = implode('/', $route->parameters);
        foreach ($this->asrParams as $key => $val) {
            $reconstructedUrl .= "/$key/$val";
        }

        $controllerAtMethod_asString = $route->action['controller'];
        $controllerAtMethod_asString = str_replace('getFrontView', 'getBodyView', $controllerAtMethod_asString);
        $this->controllerName = substr(
            $controllerAtMethod_asString,
            0,
            strpos($controllerAtMethod_asString, '@')
        );// trim everything before '@'  // 11/20' not used yet

        $this->bodyView = \App::call(
            $controllerAtMethod_asString,
            [
                'subLevels' => $reconstructedUrl,
                'LePageChunkKey' => $this->myKey,
                'LePageChunkValue' => $route,
                'asrParams'=>$this->asrParams,
            ]
        );
    }

    /* Future: Flag somehow if this should be re-pulled from server when switching to it.
    We could also pre-load at some point.
     */
    public function render()
    {
        assert(
            $this->didCallParent_updateLePageChunkRoute,
            " Ooops: When overriding _updateLePageChunkRoute, please also call the parent at the end, like this:  parent::updateLePageChunkRoute(\$chunkValue,\$chunkKey);"
        );
        // Get Chunk Html
        $route = app('router')->getRoutes()->match(app('request')->create($this->pageRoute, 'GET'));
        $this->produceBodyView_fromRoute($route);
        $bodyHtml = $this->bodyView->render();


        // Wrap it into me
        // We have out html of the chunk, now just put it into the local body for updating in our containing page
        $blade_prefix = \TallAndSassy\PageGuide\PageGuideServiceProvider::$blade_prefix;
        $this->justMounted = false;
        return view(
            $blade_prefix . '::' . $this->bladeTemplate,
            ['bodyHtml' => $bodyHtml, 'title' => 'fromLePageRender', 'asrParams'=>$this->asrParams]
        );
    }


    public static function wireSwaplinkInA(string $chunkValue, ?string $chunkKey = null)
    {
        # wire:click="\$emit('pageRoute','$url')"
        # Livewire.emit('universalHandle_butActuallyForPollingCard','10')
        # <a {!!LePageChunk::wireSwaplinkInA('/admin/help', 'crumbOrWhatever')!!}> Help </a>
        $manualUrl = '#';
        #$forceRelaod_zo = $forceRelaod_ignored ? 1 : 0;

        if (!$chunkKey) {
            assert(
                !empty(static::$chunkKey),
                __FILE__ . __LINE__ . " please set protected static string \$keyForThisChunk = 'crumb'; to something"
            );
            $chunkKey = static::$chunkKey;
        }

        return <<<EOD
        x-on:click.prevent="
            // maybeCloseAdminMenu();
            //urlChange('$chunkValue');
            Livewire.emit('LeSwappableChunk_doSwap','$chunkValue','$chunkKey');
            //TODO: De-Activiate any previous page, activate this page.. What this mean 11/23/20'
            "
        href="{$manualUrl}
        "
        EOD;
    }

    public static function subLevels2asrParams($subLevels): array
    {
        //fyi: explode('/','')) == [0=>'']
        $subLevels = trim($subLevels, '/');
        $arrParams = explode('/', $subLevels);

        $asrParams = [];
        $numParams = count($arrParams);
        for ($i = 0; $i < $numParams; $i = $i + 2) {
            if (app()->environment('local')) {
                assert(
                    isset($arrParams[$i + 1]),
                    "$subLevels arrParams must be key/value sets at i($i) ->" . implode(
                        '-',
                        $arrParams
                    ) . " count(arrParams):" . count(
                        $arrParams
                    ) . "vs " . $numParams . " (FYI: this only shows in env(local)) " . __FILE__ . __LINE__
                );
            }
            if (!isset($arrParams[$i + 1])) {
                abort('404');// or maybe redirect to home
            }

            $asrParams[$arrParams[$i]] = $arrParams[$i + 1];
        }
        return $asrParams;
    }

    public static function getPillsView(string $extraClasses = '')
    {
        $chunks = <<<EOD
        <div class="flex">
        EOD;
        $asrTabs = static::getAsrTabs();
        foreach ($asrTabs as $key => $asrTab) {
            $key = $asrTab['href'];
            $title = $asrTab['title'];
            $hrefAndValue = static::wireSwaplinkInA($key);

            $chunk = <<<EOD
            <button
                $hrefAndValue
                class="m-2 inline-flex

                py-1 px-2 border rounded border-indigo-500 bg-indigo-300
                text-sm font-medium leading-5 text-gray-900
                focus:border-indigo-700 transition duration-150 ease-in-out
                $extraClasses">
                $title
            </button>
            EOD;
            $chunks .= $chunk;
        }
        $chunks .= '</div>';

        return $chunks;
    }

    public static function getTabsView(string $extraClasses = '', ?string $defaultTab  = null)
    {
        $pageRoute = 'admin/playground/';

        $asrTabs = static::getAsrTabs();
        $defaultTab = ($defaultTab) ? $defaultTab : array_key_first($asrTabs);
        $currentTab = $defaultTab;

        $asrTabs[$currentTab]['classes'][] = 'active'; // known limiation, only works for named keys for some reason
        $arrDtoNavTabs = [];


        foreach ($asrTabs as $key=>$asrNavTab) {
            #dd($asrTabs);
            $arrDtoNavTabs[$key] =new \StWip\Screens\DtoNavTab($asrNavTab);
        }
        $dtoNavTabs = new \StWip\Screens\DtoNavTabs(['values'=>$arrDtoNavTabs]);

        $asrAsrStuffMostlyForTabs = ['dtoNavTabs'=>$dtoNavTabs, 'defaultTab'=>$defaultTab, 'currentTab'=>$currentTab, 'ownerName'=>static::class];

        #$asrStuffMostlyForTabs = \StWip\Screens\NavTabHelper::prepForInclude($pageRoute, $asrTabs, $defaultTab );
        return view('tassy::tabs.tabs',$asrAsrStuffMostlyForTabs);
    }
}
