<?php
declare(strict_types=1);

namespace TallAndSassy\Ui\Glances\Components;

enum EnumRenderState: string {
    case PLACEHELD = 'Placeheld';
    case RENDERED = 'Rendered';
}