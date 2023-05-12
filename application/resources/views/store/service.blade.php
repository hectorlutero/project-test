<x-guest-layout>


    <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    theme: {
      extend: {
        gridTemplateRows: {
          '[auto,auto,1fr]': 'auto auto 1fr',
        },
      },
    },
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
    <div class="bg-white mt-20">
        <div class="pt-6">
            <nav aria-label="Breadcrumb">
                <ol role="list"
                    class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                    <li>
                        <div class="flex items-center">
                            <a href="#"
                               class="mr-2 text-sm font-medium text-gray-900">Serviços</a>
                            <svg width="16"
                                 height="20"
                                 viewBox="0 0 16 20"
                                 fill="currentColor"
                                 aria-hidden="true"
                                 class="h-5 w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <a href="#"
                               class="mr-2 text-sm font-medium text-gray-900">Categoria</a>
                            <svg width="16"
                                 height="20"
                                 viewBox="0 0 16 20"
                                 fill="currentColor"
                                 aria-hidden="true"
                                 class="h-5 w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>

                    <li class="text-sm">
                        <a href="#"
                           aria-current="page"
                           class="font-medium text-gray-500 hover:text-gray-600">{{ $service['item']->name }}</a>
                    </li>
                </ol>
            </nav>

            <!-- Image gallery -->
            <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
                <div class="aspect-h-4 aspect-w-3 hidden overflow-hidden rounded-lg lg:block">
                    <img src="{{ !empty($service['gallery'][0]) ? asset('storage/' . $service['gallery'][0]) : '/images/default.png' }}"
                         alt="Two each of gray, white, and black shirts laying flat."
                         class="h-full w-full object-cover object-center">
                </div>
                <div class="hidden lg:grid lg:grid-cols-1 lg:gap-y-8">
                    <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg">
                        <img src="{{ !empty($service['gallery'][1]) ? asset('storage/' . $service['gallery'][1]) : '/images/default.png' }}"
                             alt="Model wearing plain black basic tee."
                             class="h-full w-full object-cover object-center">
                    </div>
                    <div class="aspect-h-2 aspect-w-3 overflow-hidden rounded-lg">
                        <img src="{{ !empty($service['gallery'][2]) ? asset('storage/' . $service['gallery'][2]) : '/images/default.png' }}"
                             alt="Model wearing plain gray basic tee."
                             class="h-full w-full object-cover object-center">
                    </div>
                </div>
                <div class="aspect-h-5 aspect-w-4 lg:aspect-h-4 lg:aspect-w-3 sm:overflow-hidden sm:rounded-lg">
                    <img src="{{ !empty($service['gallery'][3]) ? asset('storage/' . $service['gallery'][3]) : '/images/default.png' }}"
                         alt="Model wearing plain white basic tee."
                         class="h-full w-full object-cover object-center">
                </div>
            </div>

            <!-- Product info -->
            <div
                 class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ $service['item']->name }}
                    </h1>
                    <a
                       href="{{ route('store.company.show', ['companySlug' => $service['item']->company->slug, 'id' => $service['item']->company->id]) }}">
                        <p class="text-xl tracking-tight text-gray-400">{{ $service['item']->company->name }}</p>
                    </a>
                </div>

                <!-- Options -->
                <div class="mt-4 lg:row-span-3 lg:mt-0">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl tracking-tight text-gray-900">R$ {{ $service['item']->price }}</p>

                    <!-- Reviews -->
                    <div class="mt-6">
                        <h3 class="sr-only">Reviews</h3>
                        <x-store.review-stars />
                    </div>

                    <form class="mt-10 ">
                        <!-- Colors -->
                        <div>
                            <div class="bg-gray-100 p-4">
                                <h2 class="text-lg font-medium text-gray-900">Horário de Serviço:</h2>
                                <h2 class="font-bold text-lg mb-2"></h2>
                                <table class="table w-full">
                                    <tbody>
                                        @if ($service['item']->is24_7 === '1')
                                            Serviço 24hrs.
                                        @else
                                            <tr>
                                                <td class="font-bold text-sm">Dias úteis:</td>
                                                <td class="text-right">
                                                    @if ($service['item']->working_days_start !== null)
                                                        {{ date('H:i', strtotime($service['item']->working_days_start)) }}
                                                        -
                                                        {{ date('H:i', strtotime($service['item']->working_days_end)) }}
                                                    @else
                                                        Fechado
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-bold text-sm">Sábados:</td>
                                                <td class="text-right">
                                                    @if ($service['item']->saturdays_start !== null)
                                                        {{ date('H:i', strtotime($service['item']->saturdays_start)) }}
                                                        -
                                                        {{ date('H:i', strtotime($service['item']->saturdays_end)) }}
                                                    @else
                                                        Fechado
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-bold text-sm">Domingos e Feriados:</td>
                                                <td class="text-right">
                                                    @if ($service['item']->sundays_n_holidays_start !== null)
                                                        {{ date('H:i', strtotime($service['item']->sundays_n_holidays_start)) }}
                                                        -
                                                        {{ date('H:i', strtotime($service['item']->sundays_n_holidays_end)) }}
                                                    @else
                                                        Fechado
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <fieldset class="mt-4 hidden">
                                <legend class="sr-only">Choose a color</legend>
                                <div class="flex items-center space-x-3">
                                    <!--
                                        Active and Checked: "ring ring-offset-1"
                                        Not Active and Checked: "ring-2"
                                    -->
                                    <label
                                           class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-400">
                                        <input type="radio"
                                               name="color-choice"
                                               value="White"
                                               class="sr-only"
                                               aria-labelledby="color-choice-0-label">
                                        <span id="color-choice-0-label"
                                              class="sr-only">White</span>
                                        <span aria-hidden="true"
                                              class="h-8 w-8 bg-white rounded-full border border-black border-opacity-10"></span>
                                    </label>
                                    <!--
                                        Active and Checked: "ring ring-offset-1"
                                        Not Active and Checked: "ring-2"
                                    -->
                                    <label
                                           class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-400">
                                        <input type="radio"
                                               name="color-choice"
                                               value="Gray"
                                               class="sr-only"
                                               aria-labelledby="color-choice-1-label">
                                        <span id="color-choice-1-label"
                                              class="sr-only">Gray</span>
                                        <span aria-hidden="true"
                                              class="h-8 w-8 bg-gray-200 rounded-full border border-black border-opacity-10"></span>
                                    </label>
                                    <!--
                                        Active and Checked: "ring ring-offset-1"
                                        Not Active and Checked: "ring-2"
                                    -->
                                    <label
                                           class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-900">
                                        <input type="radio"
                                               name="color-choice"
                                               value="Black"
                                               class="sr-only"
                                               aria-labelledby="color-choice-2-label">
                                        <span id="color-choice-2-label"
                                              class="sr-only">Black</span>
                                        <span aria-hidden="true"
                                              class="h-8 w-8 bg-gray-900 rounded-full border border-black border-opacity-10"></span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <!-- Sizes -->
                        <div class="mt-10 hidden">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-medium text-gray-900">Size</h3>
                                <a href="#"
                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
                            </div>

                            <fieldset class="mt-4">
                                <legend class="sr-only">Choose a size</legend>
                                <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-not-allowed bg-gray-50 text-gray-200">
                                        <input type="radio"
                                               name="size-choice"
                                               value="XXS"
                                               disabled
                                               class="sr-only"
                                               aria-labelledby="size-choice-0-label">
                                        <span id="size-choice-0-label">XXS</span>
                                        <span aria-hidden="true"
                                              class="pointer-events-none absolute -inset-px rounded-md border-2 border-gray-200">
                                            <svg class="absolute inset-0 h-full w-full stroke-2 text-gray-200"
                                                 viewBox="0 0 100 100"
                                                 preserveAspectRatio="none"
                                                 stroke="currentColor">
                                                <line x1="0"
                                                      y1="100"
                                                      x2="100"
                                                      y2="0"
                                                      vector-effect="non-scaling-stroke" />
                                            </svg>
                                        </span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="XS"
                                               class="sr-only"
                                               aria-labelledby="size-choice-1-label">
                                        <span id="size-choice-1-label">XS</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="S"
                                               class="sr-only"
                                               aria-labelledby="size-choice-2-label">
                                        <span id="size-choice-2-label">S</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="M"
                                               class="sr-only"
                                               aria-labelledby="size-choice-3-label">
                                        <span id="size-choice-3-label">M</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="L"
                                               class="sr-only"
                                               aria-labelledby="size-choice-4-label">
                                        <span id="size-choice-4-label">L</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="XL"
                                               class="sr-only"
                                               aria-labelledby="size-choice-5-label">
                                        <span id="size-choice-5-label">XL</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="2XL"
                                               class="sr-only"
                                               aria-labelledby="size-choice-6-label">
                                        <span id="size-choice-6-label">2XL</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                    <!-- Active: "ring-2 ring-indigo-500" -->
                                    <label
                                           class="group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6 cursor-pointer bg-white text-gray-900 shadow-sm">
                                        <input type="radio"
                                               name="size-choice"
                                               value="3XL"
                                               class="sr-only"
                                               aria-labelledby="size-choice-7-label">
                                        <span id="size-choice-7-label">3XL</span>
                                        <!--
                                            Active: "border", Not Active: "border-2"
                                            Checked: "border-indigo-500", Not Checked: "border-transparent"
                                            -->
                                        <span class="pointer-events-none absolute -inset-px rounded-md"
                                              aria-hidden="true"></span>
                                    </label>
                                </div>
                            </fieldset>
                        </div>

                        <button type="submit"
                                class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Entrar
                            em contato</button>
                    </form>
                </div>

                <div
                     class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                    <!-- Description and details -->
                    <div>
                        <h3 class="sr-only">Descrição</h3>

                        <div class="space-y-6">
                            <p class="text-base text-gray-900">{{ $service['item']->description }}</p>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h3 class="text-sm font-medium text-gray-900">Highlights</h3>

                        <div class="mt-4">
                            <ul role="list"
                                class="list-disc space-y-2 pl-4 text-sm">
                                <li class="text-gray-400"><span class="text-gray-600">Hand cut and sewn locally</span>
                                </li>
                                <li class="text-gray-400"><span class="text-gray-600">Dyed with our proprietary
                                        colors</span></li>
                                <li class="text-gray-400"><span class="text-gray-600">Pre-washed &amp;
                                        pre-shrunk</span></li>
                                <li class="text-gray-400"><span class="text-gray-600">Ultra-soft 100% cotton</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h2 class="text-sm font-medium text-gray-900">Details</h2>

                        <div class="mt-4 space-y-6">
                            <p class="text-sm text-gray-600">The 6-Pack includes two black, two white, and two heather
                                gray Basic Tees. Sign up for our subscription service and be the first to get new,
                                exciting colors, like our upcoming &quot;Charcoal Gray&quot; limited release.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-store.comments />

</x-guest-layout>
