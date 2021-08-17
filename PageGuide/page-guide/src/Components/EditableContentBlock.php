<?php

namespace TallAndSassy\PageGuide\Components;

use App\Http\Controllers\PageController;
use App\Models\Page;
use Livewire\Component;
use TallAndSassy\Strings\TsStringHtml;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
//JJ - you left off eagerly wanting to move this into TallAndSassy/Inputs

class EditableContentBlock extends Component
{
    use AuthorizesRequests;
    public string $content = 'Try starting with a slug';
    public $count_back = 0;
    private Page $thisBlock;
    public bool $isEditing_atServer = false;
    public bool $hasChanges = false;
    /* textarea, html, (future: src, cms, string)
    textarea = standard textarea, but newlines are rendered as <p>. Tags are stripped
    html = Rich Wyiwyg editor
    */
    public string $enumType = '';
//    public ?string $allowedTags = null;// null => All allowed, empty array means nothing allowed. Only smarts
    public ?string $placeholder = null;
    public ?string $class = null;
    public string  $editPermission; // Open Security Question:
                                    // This is set via an attribute on the blade component, like:   <livewire:editable-content-block slug="home" enumType="html" defaultContent=""  editPermission="{{\TallAndSassy\RolesAndPermissions\BaseTassyPermissions::EDIT_HOMEPAGE}}"/>
                                    // If we set this to public, it persists, and works, but 'protected' looses state by the time it gets to the ajax call.
                                    // Is this a hackable setup? 7/21'
    public string $slug;

//    public function ping() {
//
//        $this->hasChanges = true;
//        sleep(2);
//    }

    /* why a function? I wasn't sure about security */
    public function getEditPermission(): string {
        return $this->editPermission;
    }
    public function mount(string $slug, string $enumType, string $editPermission, string $defaultContent)
    {
        $this->slug = $slug;
        $this->enumType = $enumType;
        $this->editPermission = $editPermission;


        $m = \App\Models\Page::findBySlug($slug);
        if (!$m) {
            $m = new \App\Models\Page();
            $m->title = 'TBD'.__FILE__.__LINE__;
            $m->slug = $slug;
            $m->content = "<div class=\"text-gray-400\">$defaultContent</div>";
            $m->save();
            unset($m);
            $m = \App\Models\Page::findBySlugOrFail($this->slug);
        }
        $this->content = $m->content;
        $this->thisBlock = $m;

    }

    public function save($html_untrusted) {
        $this->authorize($this->editPermission);

        // Strip all but UI markup @TODO make better
        $html_more_trusted_but_not_sql_safe = TsStringHtml::ScrubScriptDangers($html_untrusted);
        if ($this->enumType == 'textarea' ) {
            $html_more_trusted_but_not_sql_safe = TsStringHtml::strip_tags($html_untrusted);
        }

        $m = \App\Models\Page::findBySlugOrFail($this->slug);
        $m->content = $html_more_trusted_but_not_sql_safe;
        $r = $m->save();
        #sleep(1);
        $this->content = $m->content;
        $this->hasChanges = false;
        $this->emit('reinit');
    }
    public function render()
    {
        return view('tassy::livewire.editable-content-block');
    }
}
