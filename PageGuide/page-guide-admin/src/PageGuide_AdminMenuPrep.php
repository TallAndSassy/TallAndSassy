<?php
declare(strict_types=1);
namespace TallAndSassy\PageGuideAdmin;
class PageGuide_AdminMenuPrep {
    public static function RegisterAdminMenus()
    {
        if (config('tassy.admin.DoDashboard')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.dashboard',
                'Dashboard',
                null,
                'heroicon-o-home',
                '/admin/dashboard'
            );
        }

        if (config('tassy.admin.DoLibrary')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.libary',
                'Library',
                null,
                'heroicon-o-pencil',
                null
            )
                ->pushLink('admin.media', 'Media', '/admin/media');
        }

        if (config('tassy.admin.DoSamples')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.Cafe',
                'Cafe',
                null,
                'heroicon-o-question-mark-circle',
                null
            )
                ->pushLink('admin.salad.fruit' . uniqid(), 'Fruit Salad', '/admin/fruit')
                ->pushLink('admin.salad.leaf' . uniqid(), 'Lettuce Salad', '/admin/leaf')
                ->pushLink('admin.salad.potato' . uniqid(), 'Yucky Salad', '/admin/potato')
                ->pushGroup('condiments' . uniqid(), 'Condiments')
                ->pushLink(
                    'admin.condiments.mustard' . uniqid(),
                    'Hymans Brand Mustard',
                    '/admin/condiment/mustard'
                )
                ->pushLink('admin.condiments.catsup' . uniqid(), 'Ketchup', '/admin/condiment/catsup')
                ->pushGroup('condiments2' . uniqid(), 'Condiments2')
                ->pushLink(
                    'admin.condiments.mustard2' . uniqid(),
                    'Hymans Brand Mustar2d',
                    '/admin/condiment/mustard'
                )
                ->pushLink('admin.condiments.catsup2' . uniqid(), 'Ketchup2', '/admin/condiment/catsup')
                ->pushTop(
                    'admin.postsalaasdf' . uniqid(),
                    'Cafeteria',
                    null,
                    'zondicon-location-food',
                    '/admin/cafeteria'
                )
                ->pushTop('admin.postsala2dfgd' . uniqid(), 'Justice', null, 'heroicon-o-scale', null)
                ->pushLink('admin.condiments.catsup442' . uniqid(), 'Ketchup2', '/admin/condiment/catsup2')
                ->pushLink('admin.condiments.catsup443' . uniqid(), 'Ketchup3', '/admin/condiment/catsup3')
                ->pushLink('admin.condiments.catsup444' . uniqid(), 'Ketchup4', '/admin/condiment/catsup4')
                ->pushTop('admin.postsala444' . uniqid(), 'Trials', null, 'heroicon-o-scale', null)
                ->pushTop(
                    'admin.postsala444' . uniqid(),
                    'Liberty',
                    null,
                    'heroicon-o-scale',
                    '/admin/condiment/postsala444'
                );

            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.bob',
                'Bob',
                null,
                'heroicon-o-question-mark-circle',
                '/admin/bob'
            );
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.bobby',
                'Bobby',
                null,
                'heroicon-o-question-mark-circle',
                '/admin/bobby'
            );
        }
        if (config('tassy.admin.DoHelp')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
                'admin.help',
                'Help',
                null,
                'heroicon-o-question-mark-circle',
                '/admin/help'
            );
        }

        // ------- Default lower menus items
        if (config('tassy.admin.DoConfig')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('lower')->pushTop(
                'admin.config',
                'Config',
                null,
                'heroicon-o-cog',
                '/admin/config'
            );
        }
        if (config('tassy.admin.DoAbout')) {
            \TallAndSassy\PageGuide\MenuTree::singleton('lower')->pushTop(
                'admin.about',
                'About',
                null,
                'fas-info',
                '/admin/about',
                'w-4 h-5 mx-auto'
            );
        }

        // Temp
        \Livewire\Livewire::component('tassy::livewire.polling-card',  \TallAndSassy\PageGuideAdmin\Components\PollingCard::class);

        // Dashboard
        \Livewire\Livewire::component('tassy::cards.simple-stat',  \TallAndSassy\PageGuideAdmin\Http\Livewire\Cards\SimpleStat::class);

    }

//    private static function InjectPlanningMenu(float $position = -1){
//        \TallAndSassy\PageGuide\MenuTree::singleton('upper')->pushTop(
//            handle:'admin.planning',
//            Label:'Planning',
//            SvgHtml:'<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
//              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
//              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
//            </svg>',
//            IconName: null,
//            urlIfNoFurtherChildren_nullIfGroup: null
//        )
//            ->pushLink(handle:'admin.school_calendar', Label: 'School Calendar', url: '/admin/planning/school_calendar')
//            ->pushLink(handle:'admin.seasonal_calendar', Label: 'Seasonal Calendar', url: '/admin/seasonal_calendar');
//    }
}
