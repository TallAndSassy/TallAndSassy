<?php

namespace App\Http\Livewire\TabPlayground;

use Livewire\Component;

class Breadcrumbs extends \TallAndSassy\PageGuide\Components\LeSwappableChunk
{
    protected static string $chunkKey = 'crumb';
    public string $enumUrlType = 'updateOrAdd';

    public function doSwap(string $chunkValue, string $chunkKey)
    {
        if ($chunkValue == 'home') {
            $this->pageRoute = 'admin/dashboard';
        } elseif ($chunkValue == 'about') {
            $this->pageRoute = 'admin/about';
        } elseif ($chunkValue == 'help') {
            $this->pageRoute = 'admin/help';
        } else {
            assert(0, "chunkValue($chunkValue) " . __FILE__ . __LINE__);
        }
        parent::doSwap($chunkValue, $chunkKey);
    }



    static function getAsrTabs(): array
    {
        $numUsers = \App\Models\User::count();
        return $asrAsrNavTabs = [
            'home' => [
                'title' => 'Home',
                'classes' => [],
                'href' => 'home',
                'hint' => 'Back to front page',
                'badge' => $numUsers.'',
                'badgeClasses' => null,
            ],
            'about' => [
                'title' => 'About',
                'classes' => [],
                'href' => 'about',
                'hint' => null,
                'badge' => '2',
                'badgeClasses' => null,
            ],
            'help' => [
                'title' => 'Help',
                'classes' => [],
                'href' => 'help',
                'hint' => '',
                'badge' => '',
                'badgeClasses' => null,
            ],
        ];
    }

}
