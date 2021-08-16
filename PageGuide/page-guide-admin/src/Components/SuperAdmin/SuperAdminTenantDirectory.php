<?php

namespace TallAndSassy\PageGuideAdmin\Components\SuperAdmin;

use TallAndSassy\Tenancy\Models\Tenant;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class SuperAdminTenantDirectory extends Component
{

    public string $newName = "";
    public string $newSlug = "";
    #public bool $showModal = true;
    public string $littleMessage = "";
    public string $modalName = "tenant-create-modal";



    protected $rules = [
        'newName' => 'required|string|min:6|max:64',
        'newSlug' => 'required|string|min:4|max:63', //https://serverfault.com/questions/580249/is-there-a-maximum-subdomain-depth
    ];


    public function updated($propertyName)
    {
        if ($propertyName == 'newSlug') {
            $this->newSlug = strtolower($this->newSlug);
        }
        $this->validateOnly($propertyName);
    }


    private static function is_valid_subdomain_name($subdomain, $trailing_domain_name) // https://stackoverflow.com/a/4694816/93933
    {
        $domain_name = "$subdomain.$trailing_domain_name";
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) //valid chars check
            && preg_match("/^.{1,253}$/", $domain_name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)   ); //length of each label
    }


    private function validate_newSlug() {
        if (! static::is_valid_subdomain_name($this->newSlug,'google.com')) { //https://stackoverflow.com/a/47223679/93933
            throw ValidationException::withMessages(['newSlug' => 'This value is incorrect. It must be short and just letters and numbers. No spaces.']);
        }

        if ( Tenant::where('slug', '=', $this->newSlug)->exists() ) {
            throw ValidationException::withMessages(['newSlug' => 'This slug is already taken. Please chose something else.']);
        }
    }


    public function save() {
        $this->validate();
        $this->validate_newSlug();

        // If you get here, it's valid.
        $this->showModal = false;
        $this->littleMessage = "Saved!";
        $this->dispatchBrowserEvent('modal-did-change',['modalName'=>$this->modalName, 'show'=>false]);

        // Make the new tenant
        $goodData = [
            'name' => $this->newName,
            'slug' => $this->newSlug,
        ];

        $tenant = Tenant::create($goodData);
        $id = $tenant->save();

        // refresh tenant list and highlight with slug
        // tbd

        // wrap-up
        $this->resetCreateTenentDialog();
    }

    private function resetCreateTenentDialog(){
        $this->newName = "";
        $this->newSlug = "";
        $this->littleMessage = "";
    }

    public function render()
    {
        return view('tassy::super-admin.tenant-directory');
    }
}
