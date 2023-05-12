<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ $form['title'] }}
        </h2>
    </x-slot>

    <div class="px-6 mx-auto">
        <h2 class="my-6 text-2xl font-semibold text-slate-700 dark:text-slate-700 ">
            {{ $form['title'] }}
        </h2>

        <div class="overflow-hidden rounded-lg shadow-xs">
            <div>
                <form action="{{ $form['action'] }}"
                      method="POST"
                      class="flex flex-col md:min-h-[80vh]"
                      enctype="multipart/form-data">

                    @csrf
                    @if (!empty($form['company_id']))
                        <input type="hidden"
                               name="company_id"
                               value="{{ $form['company_id'] }}">
                    @endif
                    <div class="grid grid-cols-2 mb-6 gap-4 p-4">
                        @if ($form['model'] === 'partner.businesses' || $form['model'] === 'admin.companies')
                            <div class="">
                                <img class="mx-auto h-[250px] w-[250px] object-cover rounded-full"
                                     src="{{ !empty($form['logo']) ? asset('storage/' . $form['logo']) : '/images/default.png' }}">
                            </div>
                        @endif
                        <div class="grid  gap-4 ">

                            @foreach ($form['fields'] as $key => $field)
                                @php
                                    $inputType = explode(':', $field)[0];
                                    $fieldSubtype = explode('|', explode(':', $field)[1])[0];
                                    $size = '';
                                    $mask = '';
                                    $attrs = '';
                                    $extraClasses = '';
                                    $radioboxOpts = [];
                                    $selectedOpts = [];
                                    
                                    if (str_contains($field, '|')) {
                                        $fieldWidth = explode('|', $field)[1];
                                        $opts = !empty(explode('|', $field)[2]) ? explode('|', $field)[2] : null;
                                        if (!empty($opts)) {
                                            $opts = explode(':', $opts)[1];
                                            if (str_contains($opts, ',')) {
                                                $array = explode(',', str_replace(['[', ']'], '', $opts));
                                                foreach ($array as $element) {
                                                    $item = explode('=', $element);
                                                    $radioboxOpts[$item[0]] = $item[1];
                                                }
                                            } else {
                                                $modelName = \App\Helpers\ModelHelper::getModelByPluralName($opts);
                                                if (!empty($modelName)) {
                                                    foreach ($modelName as $model) {
                                                        $radioboxOpts[$model->name] = $model->readable_name ?? $model->name;
                                                    }
                                                }
                                            }
                                        }
                                    
                                        if (str_contains($fieldWidth, ',')) {
                                            $separatedAttrs = explode(',', $fieldWidth);
                                            foreach ($separatedAttrs as $attr) {
                                                if (str_contains($attr, 'size')) {
                                                    $sizes = explode(':', $attr)[1];
                                                    $size = "col-span-$sizes";
                                                }
                                    
                                                if (str_contains($attr, 'mask')) {
                                                    $mask = explode(':', $attr)[1];
                                                }
                                    
                                                if (str_contains($attr, 'attrs')) {
                                                    $attrs = explode(':', $attr)[1];
                                                    $attrs = implode(' ', explode(',', $attrs));
                                                    if (str_contains($attrs, 'permissions') && !empty($radioboxOpts) && $form['entry']->id != 'new') {
                                                        foreach ($radioboxOpts as $keyOpt => $rdbOpt) {
                                                            if (\Spatie\Permission\Models\Role::findByName($form['entry']->name, 'web')->hasPermissionTo($keyOpt)) {
                                                                $selectedOpts[] = $rdbOpt;
                                                            }
                                                        }
                                                        $attrs = str_replace('permissions', '', $attrs);
                                                    }
                                                    if (str_contains($attrs, 'invisible')) {
                                                        $extraClasses = "hidden $key";
                                                        $attrs = str_replace('invisible', '', $attrs);
                                                    }
                                                }
                                            }
                                        } else {
                                            if (str_contains($fieldWidth, 'size')) {
                                                $sizes = explode(':', $fieldWidth)[1];
                                                $size = "col-span-$sizes";
                                            }
                                    
                                            if (str_contains($fieldWidth, 'mask')) {
                                                $mask = explode(':', $fieldWidth)[1];
                                            }
                                    
                                            if (str_contains($fieldWidth, 'attrs')) {
                                                $attrs = explode(':', $fieldWidth)[1];
                                                $attrs = implode(' ', explode(',', $attrs));
                                            }
                                        }
                                    }
                                    
                                    if ($fieldSubtype == 'password' && !request()->is('*new')) {
                                        continue;
                                    }
                                    
                                    $fieldName = \Illuminate\Support\Str::contains($form['model'], '.') ? explode('.', $form['model'])[1] : $form['model'];
                                    
                                @endphp


                                @include('helpers.inputs-builder', [
                                    'field' => 'model_attributes.' . $fieldName . ".$key",
                                    'fieldType' => $inputType,
                                    'fieldSubtype' => $fieldSubtype,
                                    'key' => $key,
                                    'value' => @$form['entry']->{$key},
                                    'mask' => $mask,
                                    'attrs' => $attrs,
                                    'radioboxOpts' => $radioboxOpts,
                                    'selectedOpts' => $selectedOpts,
                                    'extraClasses' => $extraClasses,
                                ])
                            @endforeach
                        </div>


                    </div>

                    <footer class="z-10 py-4 bg-white shadow-md dark:bg-gray-800 mt-auto">
                        <div class="flex justify-between h-full w-full text-indigo-600 dark:text-indigo-300">

                            <div class="flex pl-6 justify-start flex-1 lg:mr-32">
                                <button onclick="window.location.href = '{{ route($form['model'] . '.index') }}'"
                                        type="button"
                                        class="px-5 py-3 align-content-start font-medium leading-5 text-white transition-colors duration-150 bg-indigo-500 border border-transparent rounded-lg active:bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo">
                                    ← Voltar
                                </button>
                            </div>

                            <div class="flex pr-6 justify-end flex-1">
                                <button
                                        class="px-5 py-3 align-content-end font-medium leading-5 text-white transition-colors duration-150 bg-indigo-500 border border-transparent rounded-lg active:bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:shadow-outline-indigo">
                                    Salvar ✓
                                </button>
                            </div>

                        </div>

                    </footer>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

@if (!empty($form['js']))
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
    <script src="{{ asset('js/' . $form['js']) }}"></script>
@endif
