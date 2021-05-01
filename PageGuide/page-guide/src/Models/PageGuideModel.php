<?php

namespace TallAndSassy\PageGuide\Models;

use Illuminate\Database\Eloquent\Model;

class PageGuideModel extends Model
{
    public $gaurded = [];// Defualt to no mass assignements
    public $fillable = ['name'];
    public $table = 'page-guide';

    public function getUpperCasedName() : string
    {
        return strtoupper($this->name);
    }
}
