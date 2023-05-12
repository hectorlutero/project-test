@if ($fieldType == 'select')

    <label class="block text-sm w-full">
        <span class="text-gray-700 dark:text-gray-500 {{ $extraClasses }}">{{ __($field) }}</span>

        @php
            $modelName = \App\Helpers\ModelHelper::getModelByPluralName($fieldSubtype);
        @endphp

        <select name="{{ $key }}"
                @if (!empty($attrs)) {{ $attrs }} @endif
                class="block w-full p-4 mt-1 text-sm text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray {{ $extraClasses }}">
            <option value="">Selecione</option>
            @foreach ($modelName as $subtype)
                <option value="{{ $subtype->id }}"
                        @if ($subtype->id == $value) selected @endif>{{ $subtype->name }}</option>
            @endforeach
        </select>
    </label>
@elseif($fieldType == 'input')
    <label class="block text-sm w-full">

        @if ($fieldSubtype != 'hidden')
            <span class="text-gray-700 dark:text-gray-500 {{ $extraClasses }}">{{ __($field) }}</span>
        @endif
        @if (!empty($fieldSubtype) && $fieldSubtype == 'radio' && !empty($radioboxOpts))
            <ul
                class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @foreach ($radioboxOpts as $k => $opt)
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center pl-3">
                            <input id="{{ $key . $k }}"
                                   type="{{ $fieldSubtype }}"
                                   value="{{ $k }}"
                                   @if ($k == $value) checked @endif
                                   name="{{ $key }}"
                                   @if (!empty($attrs)) {{ $attrs }} @endif
                                   class="p-4 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500 {{ $extraClasses }}">
                            <label for="{{ $key . $k }}"
                                   class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                {{ $opt }}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        @elseif(!empty($fieldSubtype) && $fieldSubtype == 'checkbox' && !empty($radioboxOpts))
            <div class="grid w-full gap-6 grid-cols-4">
                @php
                    if (count($radioboxOpts) >= 4) {
                        $radioboxOpts = array_chunk($radioboxOpts, 4, true);
                    }
                @endphp

                @foreach ($radioboxOpts as $optKey => $opt)
                    @php
                        if (is_array($opt)) {
                            $radioBoxTitle = explode(' ', current($opt));
                            array_shift($radioBoxTitle);
                            $radioBoxTitle = implode(' ', $radioBoxTitle);
                        }
                    @endphp

                    <div class="{{ $extraClasses }}">
                        @if (!empty($radioBoxTitle))
                            <h3 class="mb-4 font-semibold text-gray-900">{{ $radioBoxTitle }}</h3>
                        @else
                            <br />
                        @endif
                        <x-checkbox-group :key="$key"
                                          :selectedOpts="$selectedOpts"
                                          :attrs="$attrs"
                                          :opts="is_array($opt) ? $opt : $radioboxOpts" />
                    </div>


                    @break(!is_array($opt))
                @endforeach
            </div>
        @else
            <input name="{{ $key }}"
                   type="{{ $fieldSubtype }}"
                   value="{{ $value }}"
                   @if (!empty($mask)) x-mask="{{ $mask }}" @endif
                   @if (!empty($attrs)) {{ $attrs }} @endif
                   class="p-4 block w-full mt-1 text-sm text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input {{ $extraClasses }}" />
        @endif
    </label>
@elseif($fieldType == 'textarea')
    <label class="text-sm w-full ">
        <span class="text-gray-700 dark:text-gray-500 {{ $extraClasses }}">{{ __($field) }}</span>
        <textarea name="{{ $key }}"
                  @if (!empty($attrs)) {{ $attrs }} @endif
                  rows="4"
                  class="tinymce-textarea block w-full p-4 mt-1 text-sm text-gray-700 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray {{ $extraClasses }}">{{ $value }}</textarea>
    </label>
@endif
