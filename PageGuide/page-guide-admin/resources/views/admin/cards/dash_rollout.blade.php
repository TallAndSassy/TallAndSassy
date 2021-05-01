<?php 
  $arrAsrTempRollout = [
    [
      "title" => "Draft",
      "count" => "1"
    ],
    [
      "title" => "Sneak Peack",
      "count" => "0"
    ],
    [
      "title" => "Public Registration",
      "count" => "23"
    ],
    [
      "title" => "Registration Closed",
      "count" => "21"
    ],
    [
      "title" => "Current",
      "count" => "0"
    ],
    [
      "title" => "Archives",
      "count" => "0"
    ],
    [
      "title" => "Trash",
      "count" => "12"
    ],
  ]
?>


<div class="mt-4 flex flex-col">
  	<h3 class="text-lg leading-6 font-medium text-gray-900 my-2">
    	Class Rollout
  	</h3>
  	<div>
      <ul class="mt-3 grid grid-cols-1 gap-5 sm:gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($arrAsrTempRollout as $listing)
          <li class="col-span-1 flex items-center bg-white border border-gray-200 rounded-md shadow-sm overflow-hidden">
            <div class="flex-shrink-0 flex items-center justify-center w-16 h-16 text-white text-center text-sm leading-5 font-medium bg-pink-600">
              AA
            </div>
            <div class="flex-1 px-4 py-2 truncate">
              <a href="#" class="text-gray-900 text-sm leading-5 font-medium hover:text-gray-600 transition ease-in-out duration-150">{{ $listing["title"] }}</a>
              <p class="text-sm leading-5 text-gray-500">{{$listing["count"]}} Classes</p>
            </div>
            <div class="flex-shrink-0 pr-2">
              <button class="w-8 h-8 inline-flex items-center justify-center text-gray-400 rounded-full bg-transparent hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition ease-in-out duration-150">
                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                </svg>
              </button>
            </div>
          </li>
        @endforeach
        
      </ul>
    </div>
</div>