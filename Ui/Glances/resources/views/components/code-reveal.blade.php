@props(['summary','language','path'])
<details class=" ml-3 mt-3">
	<summary class="text-gray-600 cursor-pointer">{{$summary}}</summary>
	<x-grok::tas-sample-from-file language="{{$language}}" path="{!! $path !!}"/>
</details>