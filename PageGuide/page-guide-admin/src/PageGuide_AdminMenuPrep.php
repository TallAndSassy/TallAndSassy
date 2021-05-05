<?php
declare(strict_types=1);

namespace TallAndSassy\PageGuideAdmin;
use Livewire\Livewire;
use TallAndSassy\PageGuide\MenuTree;
use TallAndSassy\PageGuideAdmin\Components\PollingCard;
use TallAndSassy\PageGuideAdmin\Http\Livewire\Cards\SimpleStat;

final class PageGuide_AdminMenuPrep
{
    public static function RegisterAdminMenus()
    {
        if (config('tassy.admin.DoSampleDashboard')) {
            self::InjectSampleDashboardMenu();
        }

        if (config('tassy.admin.DoSampleLibraryMaybePremature')) {
            self::InjectSampleLibraryMenu();
        }

        if (config('tassy.admin.DoSamples')) {
            self::InjectSampleMenus();
        }
        if (config('tassy.admin.DoHelp')) {
            self::InjectHelpMenu();
        }

        // ------- Default lower menus items
        if (config('tassy.admin.DoConfig')) {
            self::InjectConfigMenu();
        }
        if (config('tassy.admin.DoConfig')) {
            self::InjectAboutMenu();
        }


    }

    private static function InjectSampleLibraryMenu(): void
    {
        MenuTree::singleton('upper')->pushTop(
            'admin.libary',
            'Library',
            null,
            'heroicon-o-pencil',
            null
        )
            ->pushLink('admin.media', 'Media', '/admin/media');
    }

    private static function InjectSampleDashboardMenu(): void
    {
        MenuTree::singleton('upper')->pushTop(
            'admin.dashboard',
            'Dashboard',
            null,
            'heroicon-o-home',
            '/admin/dashboard'
        );

        // Temp
        Livewire::component('tassy::livewire.polling-card', PollingCard::class);

        // Dashboard
        Livewire::component('tassy::cards.simple-stat', SimpleStat::class);

    }

    private static function InjectSampleMenus(): void
    {
        MenuTree::singleton('upper')->pushTop(
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

        MenuTree::singleton('upper')->pushTop(
            'admin.bob',
            'Bob',
            null,
            'heroicon-o-question-mark-circle',
            '/admin/bob'
        );
        MenuTree::singleton('upper')->pushTop(
            'admin.bobby',
            'Bobby',
            null,
            'heroicon-o-question-mark-circle',
            '/admin/bobby'
        );

    }

    private static function InjectHelpMenu(): void
    {
        MenuTree::singleton('upper')->pushTop(
            'admin.help',
            'Help',
            null,
            'heroicon-o-question-mark-circle',
            '/admin/help'
        );
    }

    private static function InjectConfigMenu(): void
    {
        MenuTree::singleton('lower')->pushTop(
            'admin.config',
            'Config',
            null,
            'heroicon-o-cog',
            '/admin/config'
        );

    }

    private static function InjectAboutMenu(): void
    {
        MenuTree::singleton('lower')->pushTop(
            'admin.about',
            'About',
            null,
            'fas-info',
            '/admin/about',
            'w-4 h-5 mx-auto'
        );
    }

}
