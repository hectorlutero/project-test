@props([
    'key' => '',
    'selectedOpts' => [],
    'attrs' => '',
    'opts' => []
    ])

<div class="flex">
    <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

        @foreach($opts as $optK => $opt)

            <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                <div class="flex items-center pl-3">
                    <input
                        id="{{$key.$optK}}"
                        type="checkbox"
                        value="{{$optK}}"
                        name="{{$key}}[{{$optK}}]"
                        {{ !empty($selectedOpts) && in_array($opt, $selectedOpts) ? "checked" : "" }}
                        {{$attrs}}
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                    >
                    <label for="{{$key.$optK}}"
                           class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{$opt}}
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
</div>
