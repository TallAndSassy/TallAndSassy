<?php

namespace TallAndSassy\PageGuide\Http\Livewire;

use Livewire\Component;

class TheModalBox extends Component
{
    public $modalTitle = 'Default Title';
    public $loadingHtml = ' <div class="loader"></div>';
    public $innerModalPath = '';
    public $primaryName_elseZeroLength = '';
    protected $listeners = ['innerModalPath'];
    public string $enumCancelOkClose = 'tbd';



    // This is bad, but it is used for text/buttons that invoke modal. It should be some sort of overridable view.
    const modalInnerText_css = " text-sm font-medium text-indigo-600";
    const modalInnerText_style = " border-bottom: 1px dotted; text-shadow: 0.5px 0.5px 1px #64748b";

    const fromModalToModalInnerText_css = " text-sm font-medium text-indigo-600";
    const fromModalToModalInnerText_style = " border-bottom: 1px ; text-shadow: 0.5px 0.5px 1px #64748b";

    const modalInnerButton_css = " relative inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo focus:border-indigo-700 active:bg-indigo-700";
    const modalInnerButton_style = " ";


    // called via javascript from theModal(... resources/views/livewire/the-modal-box.blade.php
    public function innerModalPath($newPath, $newTitle, $enumCancelOkClose, $primaryName_elseZeroLength)
    {
        $sleepSecs = 0;// for simulating slow connections.
        $this->innerModalPath = $newPath;
        $slowImulatorDebug = ($sleepSecs == 0) ? '' : "(Simulating slow: load delay is $sleepSecs sec.  Is it time to develop a loading spinner if slow?)";
        $this->modalTitle = $newTitle . $slowImulatorDebug;
        $this->primaryName_elseZeroLength = $primaryName_elseZeroLength;
        $this->enumCancelOkClose = $enumCancelOkClose;
        sleep($sleepSecs);
    }
//    public function modalTitle($newTitle) {
//        $this->modalTitle = $newTitle;
//    }
    public function render()
    {
        $this->random_number = uniqid();
        if (empty($this->innerModalPath)) {
            $innerHtml = '';
        } else {
            // LeModal means we clicked on something and we want a big chunck to swap out.  Lets get that swap.
            $route = app('router')->getRoutes()->match(app('request')->create($this->innerModalPath, 'GET'));
            $controllerAtMethod_asString = $route->action['controller'];
            // Turn  'App\Http\Controllers\AdminController@showAdminFronts' into 'App\Http\Controllers\AdminController@showAdminBody'
            //  cuz we are livewire here - we already have the body
            $controllerAtMethod_asString = str_replace('Fronts','Body', $controllerAtMethod_asString);
            $innerView = \App::call($controllerAtMethod_asString, ['subLevels'=>implode('/',$route->parameters)]);
            #dd(get_class($innerView));

            // This is dumb flotsam from the past
            if (is_string($innerView)) {
                $innerHtml = $innerView;

            } elseif (get_class($innerView) == 'StWip\Screens\DtoHtml') {
                $innerHtml = $innerView->value;

            } else {
                $innerHtml = $innerView->render();
            }

        }
        #dd($innerHtml);
       # return view('livewire.nothing',['innerHtml'=>$innerHtml]);
       return view('tassy::livewire.the-modal-box',['innerHtml'=>$innerHtml]);
    }

    public static function generateLinkToRaiseModal(string $linkInnerHtml, string $pageRoute, string $modalTitle, string $enumCancelOkClose, ?string $primaryName_elseNull = null )
    {
        $modalInnerText_css = static::modalInnerText_css;
        $modalInnerText_style = static::modalInnerText_style;

        if ($primaryName_elseNull) {
            $primaryName = $primaryName_elseNull;
        } elseif ($enumCancelOkClose == 'Cancel') {
            $primaryName = 'Cancel';
        } elseif ($enumCancelOkClose == 'Ok') {
            $primaryName = 'Ok';
        } elseif ($enumCancelOkClose == 'Close') {
            $primaryName = 'Close';
        } else {
            assert(0,__FILE__.__LINE__);
        }



        // This might be an extra layer of re-direct here.  It feels like we should call the modal via javascript/alpine,
        // and the inner section of the modal is a livewire callback, instead.....
        // Actually  @click = "theOneModal.open
        //      Looks like local alpine....

        $html =<<<EOD
            <button
            x-on:click.prevent="theOneModal.open('{$pageRoute}','{$modalTitle}', '{$enumCancelOkClose}', '{$primaryName}')"
            href = ""
            class = "{$modalInnerText_css} "
            style = "{$modalInnerText_style}"
            >{$linkInnerHtml}</button>
        EOD;
        return $html;
    }

      public static function generateLinkFromModalToModal(string $linkInnerHtml, string $pageRoute, string $modalTitle, string $enumCancelOkClose, ?string $primaryName_elseNull = null )
    {
        $modalInnerText_css = static::fromModalToModalInnerText_css;
        $modalInnerText_style = static::fromModalToModalInnerText_style;

        if ($primaryName_elseNull) {
            $primaryName = $primaryName_elseNull;
        } elseif ($enumCancelOkClose == 'Cancel') {
            $primaryName = 'Cancel';
        } elseif ($enumCancelOkClose == 'Ok') {
            $primaryName = 'Ok';
        } elseif ($enumCancelOkClose == 'Close') {
            $primaryName = 'Close';
        } else {
            assert(0,__FILE__.__LINE__);
        }



        // This might be an extra layer of re-direct here.  It feels like we should call the modal via javascript/alpine,
        // and the inner section of the modal is a livewire callback, instead.....
        // Actually  @click = "theOneModal.open
        //      Looks like local alpine....
        $random_number =uniqid();

//        $html =<<<EOD
//            <button
//            x-on:click.prevent
//            @click = "theOneModal.open('{$pageRoute}','{$modalTitle}', '{$enumCancelOkClose}', '{$primaryName}');"
//            href = "$pageRoute"
//            jroute = "$pageRoute"
//            class = "{$modalInnerText_css} "
//            style = "{$modalInnerText_style}"
//            random_number = "{$random_number}"
//            >{$linkInnerHtml}</button>
//        EOD;
            $html =<<<EOD
            <span>$random_number</span><button
            x-on:click.prevent="alert('$pageRoute from TheModalBox.php. These were not always matching the html.');theOneModal.open('{$pageRoute}','{$modalTitle}', '{$enumCancelOkClose}', '{$primaryName}');"
            href = "$pageRoute"
            jroute = "$pageRoute"
            class = "{$modalInnerText_css} "
            style = "{$modalInnerText_style}"
            random_number = "{$random_number}"
            ><span>{$linkInnerHtml}</span></button>
            EOD;
        return $html;
    }
}
