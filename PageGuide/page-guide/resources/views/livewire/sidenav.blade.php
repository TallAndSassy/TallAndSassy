<div>

    {{-- [quote] --}}

    {{-- Access this blade via
        <livewire:tassy::livewire.sidenav/>

        Peers:
        This works closely with TallAndSassy\PageGuide\Components\Sidenav
            vendor/tallandsassy/page-guide/src/Components/Sidenav.php
        See the above file for registration instructions...

        Troubleshooting:
        Q: When using <livewire:tassy::livewire.sidenav/>, I see...
            Livewire\Exceptions\ComponentNotFoundException
            Unable to find component: [tassy::livewire.sidenav]
        A: You probably didn't update src/SkeletonServiceProvider.php/boot to have your component.
            See Components/Blah.php for instructions
    --}}


    <script type="text/javascript">
        // 8/20' SideNav emits x-on:click="urlChange('$url'); prevent(); (via wireSwapLinkViaA)
        //  which mimicks going to different pages, but we're doing livewire swap outs.
        //  We mimick it by pushing the new ajax url onto the browser history stack
        //  The url in the address bar thus changes (but the back button will only change the address bar, and not
        //      the page content.
        //      We reload the location when hitting 'back' to refresh the page.
        //      FYI: If we were more refined, we could reload from ajax, but it seems like 'reload' might
        //          actually be a better defensive-programming strategy.
        // 8/20' i'm not sure if 'on('urlChange' is a dom thing, or custom code
        document.addEventListener('DOMContentLoaded', function () {
            console.log('listening');
            window.livewire.on('urlChange', (url) => {
                history.pushState(null, null, url);
            });
            console.log('done');

        });

        function urlChange(newUrl) {
            console.log('pushing to browser history: ' + newUrl);
            history.pushState(null, null, newUrl);
            console.log(newUrl);
            // alert('you left off want the page to actually swap out.  Also, you need to have the other hierarchy of menus')
        }

        window.onpopstate = function (event) {
            // https://www.quanzhanketang.com/jsref/met_loc_reload.html
            // https://developer.mozilla.org/en-US/docs/Web/API/History_API
            // https://stackoverflow.com/questions/29500484/window-onpopstate-is-not-working-nothing-happens-when-i-navigate-back-to-page
            // alert(`location: ${document.location}, state: ${JSON.stringify(event.state)}`)
            // Fix back button 7/20' https://stackoverflow.com/questions/15394156/back-button-in-browser-not-working-properly-after-using-pushstate-in-chrome
            //
            location.reload();
        }

        // obe 10/21' window.Spruce.store('sprucetest_modal', {
        //     open: 'login',
        // });
    </script>

    @php
    // Goes inside <a > to make it linky'  Doesn't include classes.  I had trouble parameterizing full html link
    /*function fancylinkInA(string $url) {
      return <<<EOD
      wire:click="\$emit('pageRoute','$url')"
      x-on:click="urlChange('$url'); prevent();"
      href="{$url}" x-on:click.prevent
      EOD;

    if (!function_exists('fancylinkInA')) {
     function fancylinkInA(string $url) {
         return \TallAndSassy\PageGuide\Components\Sidenav::wireSwaplinkInA($url);
     }
    }
    }*/

    @endphp
    {!!  \TallAndSassy\PageGuide\MenuTree::singleton('upper')->getHtml();!!}


</div>



