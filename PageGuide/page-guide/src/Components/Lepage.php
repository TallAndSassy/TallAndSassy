<?php

namespace TallAndSassy\PageGuide\Components;

use Livewire\Component;

class Lepage extends Component
{
    public string $viewRef; // was pageRoute, but misnomer  Need viewRef & url
    protected string $bladeTemplate = 'livewire.lepage'; // motivation: eneble different ways of rendering, namely for tabs
    public string $tab = 'tbd';
    public int $count = 98;
    public string $title = 'Default Title: Override with public static string $title = "My Title";';
    public string $tagline = 'For kids!';
    protected $listeners = ['pageRoute' => 'updateToPage', 'tab' => 'tab',];
    public array $asrParams = [];
    protected bool $justMounted = false;
    protected string $ControllerName;
    protected $controllerObj;
    // TODO: Store oringal url


    protected function FailOnDeadView($view)
    {
        if (! view()->exists($view)) {
            abort(404);
        }
    }


    public function goToTab(string $newTab)
    {
        $this->tab = $newTab;
    }

    public function updateToPage(string $pageRoute)
    {
        #$this->FailOnDeadView($pageRoute);
        $this->pageRoute = $pageRoute;
    }

    public function mount(string $viewRef, array $asrParams)
    {
        #$this->FailOnDeadView($pageRoute);
        $this->viewRef = $viewRef;
        $this->asrParams = $asrParams;
//        $this->ControllerName = $ControllerName;
//        $this->controllerObj = $controllerObj;
        $this->justMounted = true;
    }
    public function render()
    {
        #dd(__FILE__.__LINE__);
        if ($this->justMounted) {
            $request = app('request');
            $route = app('router')->getRoutes()->match($request);
            unset($request);
        } else {
            // We're being called via livewire Livewire.emit('pageRoute','$url');
            // from public static function wireSwaplinkInA(
            //  Which is probably called when making the side menu
            //
            // We want to create a fake route from that suburl so we can devolve to normal routing
            // In pre-tenant days, it was easier

            // Protocal: Hack - not sure how to do this via Laravel... wrote on a plane
            $http_s = 'http';
            if (isset($_SERVER["HTTPS"])) {
                if ($_SERVER["HTTPS"] == "on") {
                    $http_s .= "s";
                }
            }

            // Host
            $host = app('request')->getHost();

            // Route
            $testRoute = $http_s.'://'.$host.$this->pageRoute;  // MaybeTodo: should we save this?

            $route = app('router')->getRoutes()->match(app('request')->create($testRoute, 'GET')); // Maybe be more dynamic about GET vs, say, POST
            //#$route = app('router')->getRoutes()->match(app('request')->create($this->pageRoute, 'GET')); // Maybe be more dynamic about GET vs, say, POST
        }
        # FYI: $tailingUrl = $request->path(); //http://domain.com/foo/bar, the path method will return foo/bar
        // If refreshing, the params need to be put back into the url.  Probably should have just stored it. oh well.
        // what is this, really?  old flotsam?
        $reconstructedUrl = implode('/', $route->parameters);
        foreach ($this->asrParams as $key => $val) {
            $reconstructedUrl .= "/$key/$val";
        }

        if (!isset($route->action['controller'])) {
            // No controller specified.  Maybe just a string or view? ...
            #$bodyView = \App::call($controllerAtMethod_asString, ['subLevels' => $reconstructedUrl]);
            assert($route->action['uses']);
            $closure = $route->action['uses'];
            $bodyView = $closure();
            $fl = __FILE__.__LINE__;
            $bodyView .=<<<EOD
            <div class="text-gray-400 text-sm">(warnings delived by LePage..) <!--
            Rendered via simple closure.
            No controller was specified.
            Logic for route({$route->uri}) at: $fl
            NOTE: This is only useful when swapping (probably debugging your routes?), this page will look bad when refreshing the browser because it would have surrounding shell html
            -->
            </div>
            EOD;

        } else {

            $controllerAtMethod_asString = $route->action['controller'];
            $controllerAtMethod_asString = str_replace('getFrontView', 'getBodyView', $controllerAtMethod_asString);
            $this->ControllerName = substr(
                $controllerAtMethod_asString,
                0,
                strpos($controllerAtMethod_asString, '@')
            );// trim everything before '@'

            $bodyView = \App::call($controllerAtMethod_asString, ['subLevels' => $reconstructedUrl]);

            $this->title = $this->ControllerName::$title; // Error here?...
        }
        // Try, in your body controller, adding
        //      public static string $title = 'My Clever Page Title';
        // (we would have made this an abstract property in PageGuideAdmin, but that isn't a thing.)
        if (is_string($bodyView)){ // I got just html, instead of a full view.  Fine.
            $bodyHtml = $bodyView;
        } else {
            $bodyHtml = $bodyView->render();
        }


        #dd([__FILE__,__LINE__, $bodyHtml]);

        $blade_prefix = \TallAndSassy\PageGuide\PageGuideServiceProvider::$blade_prefix;

         //return view($blade_prefix.'::livewire.lepage', ['bodyHtml' => $bodyHtml, 'title' => 'fromLePageRender']);
        return view($blade_prefix.'::'.$this->bladeTemplate, ['bodyHtml' => $bodyHtml, 'title' => 'fromLePageRender']);

        //        $this->justMounted = false;
        //
        //        // LePage means we clicked on something and we want a big chunck to swap out.  Lets get that swap.
        //
        //
        //        $route = app('router')->getRoutes()->match(app('request')->create($this->pageRoute, 'GET'));
        //        #dd($route);
        //
        //        $controllerAtMethod_asString = $route->action['controller'];
        //        // Turn  'App\Http\Controllers\AdminController@showAdminFronts' into 'App\Http\Controllers\AdminController@showAdminBody'
        //        //  cuz we are livewire here - we already have the shell
        //        $controllerAtMethod_asString = str_replace('Fronts', 'Body', $controllerAtMethod_asString);
        //
        //        // If refreshing, the params need to be put back into the url.  Probably should have just stored it. oh well.
        //        $reconstructedUrl = implode('/', $route->parameters);
        //        foreach ($this->asrParams as $key => $val) {
        //            $reconstructedUrl .= "/$key/$val";
        //        }
        //
        //        $innerView = \App::call($controllerAtMethod_asString, ['subLevels' => $reconstructedUrl]);
        //        $innerHtml = $innerView->getView();
        //        $blade_prefix = \TallAndSassy\PageGuide\PageGuideServiceProvider::$blade_prefix;
        //        $this->justMounted = false;
        //
        //        return view($blade_prefix.'::livewire.lepage', ['innerHtml' => $innerHtml]);
    }

    public static function wireSwaplinkInA(string $url, bool $includeHref = true, bool $closeModal = false)
    {
        // Note: close(); is there to force closing of any open modal
        // 8/20' Known Issue: Calls close() twice.  Everything is always getting closed twice.
        # wire:click="\$emit('pageRoute','$url')"
        # Livewire.emit('universalHandle_butActuallyForPollingCard','10')
        $h = '';
        if(config('tassy.admin.DoAjaxAdminPages')) {
            $DoAjaxAdminPages = config('tassy.admin.DoAjaxAdminPages') ? 1 : 0;
            $cm = $closeModal ? " close(); " : '';  // this closes the modal (twice, for some reason). which, for some reason calls resources/views/livewire/the-modal-box.blade.php theModal.close().  Not sure why
            $h = <<<EOD
            x-on:click.prevent="
                maybeCloseAdminMenu();
                $cm

                urlChange('$url');
                Livewire.emit('pageRoute','$url');
                //TODO: De-Activiate any previous page, activate this page
                "
            EOD;
        } else {
            $h = <<<EOD
            
            EOD;
        }
        if ($includeHref) {
            $h .=<<< EOD
            href="{$url}"
            EOD;
        }
        return $h;
    }

    public static function SelfRegister(): void {
        \Livewire\Livewire::component('tassy::livewire.lepage',  self::class);
    }

}
