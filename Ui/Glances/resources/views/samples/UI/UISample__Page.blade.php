<div>

@php
$asrLocalSamples = [
    ['filename'=>'ui_looks_title',    'language'=>'html'],
    ['filename'=>'ui_looks_parenthetical',    'language'=>'html'],
    ['filename'=>'list_unordered',    'language'=>'html'],
    ['filename'=>'list_unordered',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_tab',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_outside',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_outside_tab',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_download',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_emailapp',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_anchor',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_noaction',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_impactfulaction',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_modal',    'language'=>'html'],
    ['filename'=>'ui_looks_links_to_back',    'language'=>'html'],
    ['filename'=>'icon',    'language'=>'html'],
    ['filename'=>'hint',    'language'=>'html'],
    ['filename'=>'labeled_values',    'language'=>'html'],
    ['filename'=>'spinner_loading',    'language'=>'html'],
    ['filename'=>'spinner_working',    'language'=>'html'],


    ];
@endphp
    @foreach ($asrLocalSamples as $localSample)
        <div class="p-2 mb-2 rounded bg-gray-200">
        @include('tassy-ui::samples/UI/'.$localSample['filename'])
        <x-tassy-ui::code-reveal summary="Code" language="{{$localSample['language']}}" path="vendor/tallandsassy/tallandsassy/Ui/Glances/resources/views/samples/UI/{{$localSample['filename']}}.blade.php"/>
        </div>
    @endforeach



</div>
