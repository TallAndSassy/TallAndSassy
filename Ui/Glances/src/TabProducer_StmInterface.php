<?php
declare(strict_types=1);

namespace TallAndSassy\Ui\Glances;

interface TabProducer_StmInterface extends SlugProducer_StfInterface {
    public function getTabTitle(): string;
    public function getTabTitleHint(): string;
    public function getTabBadge(): string;
    public function getTabBadgeEnumStyle(): string;
}
