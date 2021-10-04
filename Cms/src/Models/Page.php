<?php

namespace App\Models;

use TallAndSassy\Tenancy\Scopes\TenantScope;
use App\Traits\Uuids;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use SluggableScopeHelpers, Sluggable;
    use HasFactory;
    use Uuids;
    //    public $title;
    //    public $content;
    //    public $slug;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function($model){
            if(session()->has('tenant_id')) {
                $model->tenant_id = session()->get('tenant_id');
            }
        });
    }

}
