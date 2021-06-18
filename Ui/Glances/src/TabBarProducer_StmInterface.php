<?php
declare(strict_types=1);

namespace TallAndSassy\Ui\Glances;

interface TabBarProducer_StmInterface {
    public function getDefaultTab(): TabProducer_StmInterface;
    public function getTabs(): array;
    public function getCurrentTab(): TabProducer_StmInterface;
    public function getCurrentTabSlug(): string;
    //static public function getDtoTabs(string $currentTab = ''): Pages\DtoNavTabs;
}
