<?php

declare(strict_types=1);

namespace TallAndSassy\Ui\Glances;


trait TabsProducer_SimpleImplementation{
    static string $PAGE_TAB_KEY = 'pageTab';
    public function getCurrentTab(): TabProducer_StmInterface {
        if (isset($_REQUEST[static::$PAGE_TAB_KEY]) && (in_array($_REQUEST[static::$PAGE_TAB_KEY], $this->getAllowedTabSlugs()))) {
            $current_tab_parts_producer = $this->getTabs()[$_REQUEST[static::$PAGE_TAB_KEY]];
        } else {
            $current_tab_parts_producer = $this->getDefaultTab();
        }
        return $current_tab_parts_producer;
    }
    public function getCurrentTabSlug(): string {
        return $this->getCurrentTab()->getSlug();
    }

    private array $_tabs = [];
    private function addTab(TabProducer_StmInterface $aTab): void {
        $this->_tabs[$aTab->getSlug()] = $aTab;
    }

    private TabProducer_StmInterface $_defaultTab;
    public function setDefaultTab(TabProducer_StmInterface $aTab): void {
        $this->_defaultTab = $aTab;
    }
    public function getDefaultTab(): TabProducer_StmInterface {
        assert(isset($this->_defaultTab));
        return  $this->_defaultTab;
    }

    public function getTabs(): array {
        return $this->_tabs;
    }

    public function getAllowedTabSlugs(): array {
        return array_keys($this->_tabs);
    }

    /* usage: $domId = TabsProducer_SimpleImplementation::getTabDomId_ofSlug(SchoolCalendarGrid_Tab::getSlug()); */
    public static function getTabDomId_ofSlug(string $slugOfATab): string {
        return 'TabSlug_'.$slugOfATab;
    }
    public static function getTabBodyWrapperDomId_ofSlug(string $slugOfATab): string {
        return self::getTabBodyWrapperDomPrefix().$slugOfATab;
    }
    public static function getTabBodyWrapperDomPrefix(): string {
        return 'tab_body_';
    }


}
