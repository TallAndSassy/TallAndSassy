<?php

namespace TallAndSassy\PageGuideAdmin\Models;

use Illuminate\Database\Eloquent\Model;

class PageGuideAdminModel extends Model
{
    public $gaurded = [];// Defualt to no mass assignements
    public $fillable = ['name'];
    public $table = 'page-guide-admin';

    public function getUpperCasedName() : string
    {
        return strtoupper($this->name);
    }
}
