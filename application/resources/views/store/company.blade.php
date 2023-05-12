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
    <div class="mt-20">
        <div class="pt-10">
            <nav aria-label="Breadcrumb">
                <ol role="list"
                    class="mx-auto flex max-w-2xl items-center space-x-2 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                    <li>
                        <div class="flex items-center">
                            <a href="#"
                               class="mr-2 text-sm font-medium text-gray-900">Parceiros</a>
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
                               class="mr-2 text-sm font-medium text-gray-900">{{ $company['item']->name }}</a>
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
                </ol>
            </nav>
            <div class="p-10">

                <div class="container mx-auto p-5">
                    <div class="md:flex no-wrap md:-mx-2 ">
                        <!-- Left Side -->
                        <div class="w-full md:w-3/12 md:mx-2">
                            <!-- Profile Card -->
                            <div class="bg-white p-3 border-t-4 border-green-400">
                                <div class="image overflow-hidden">
                                    <img class="h-16 w-16 rounded-full mx-auto object-cover"
                                         src="{{ !empty($company['gallery'][0]) ? asset('storage/' . $company['gallery'][0]) : '/images/default.png' }}"
                                         alt="">
                                </div>
                                <h1 class="text-gray-900 font-bold text-xl leading-8 my-1">{{ $company['item']->name }}
                                </h1>
                                <h3 class="text-gray-600 font-lg text-semibold leading-6">Owner at Her Company Inc.</h3>
                                <p class="text-sm text-gray-500 hover:text-gray-600 leading-6">
                                    {{ $company['item']->description }}</p>
                                <div class="py-4 flex items-center">
                                    {{-- @if ($company['item']->instagram !== null) --}}
                                    <a class="text-indigo-800 text-2xl mr-4"
                                       href="{{ $company['item']->instagram }}"><i
                                           class="fa-brands fa-square-instagram"></i></a>
                                    {{-- @endif --}}
                                    {{-- @if ($company['item']->facebook !== null) --}}
                                    <a class="text-indigo-800 text-2xl mr-4"
                                       href="{{ $company['item']->facebook }}"><i
                                           class="fa-brands fa-square-facebook"></i></a>
                                    {{-- @endif --}}
                                    {{-- @if ($company['item']->twitter !== null) --}}
                                    <a class="text-indigo-800 text-2xl mr-4"
                                       href="{{ $company['item']->twitter }}"><i
                                           class="fa-brands fa-square-twitter"></i></a>
                                    {{-- @endif --}}
                                    {{-- @if ($company['item']->linkedin !== null) --}}
                                    <a class="text-indigo-800 text-2xl mr-4"
                                       href="{{ $company['item']->linkedin }}"><i class="fa-brands fa-linkedin"></i></a>
                                    {{-- @endif --}}
                                    {{-- @if ($company['item']->youtube !== null) --}}
                                    <a class="text-indigo-800 text-2xl mr-4"
                                       href="{{ $company['item']->youtube }}"><i
                                           class="fa-brands fa-square-youtube"></i></a>
                                    {{-- @endif --}}
                                    {{-- @if ($company['item']->pinterest !== null) --}}
                                    <a class="text-indigo-800 text-2xl mr-4"
                                       href="{{ $company['item']->pinterest }}"><i
                                           class="fa-brands fa-square-pinterest"></i></a>
                                    {{-- @endif --}}
                                </div>
                                {{-- {{ dd($company['item']) }} --}}
                                <ul
                                    class="bg-gray-100 text-gray-600 hover:text-gray-700 hover:shadow py-2 px-3 mt-3 divide-y rounded shadow-sm">
                                    <li class="flex items-center py-3">
                                        <span>Status</span>
                                        <span class="ml-auto"><span
                                                  class="bg-{{ $company['item']->status === 'active' ? 'green' : 'yellow' }}-500 py-1 px-2 rounded text-white text-sm">{{ $company['item']->status }}</span></span>
                                    </li>
                                    <li class="flex items-center py-3">
                                        <span>Membro desde</span>
                                        <span class="ml-auto">{{ $company['item']->created_at->format('F Y') }}</span>
                                    </li>
                                </ul>


                            </div>
                            <!-- End of profile card -->
                            <div class="my-4"></div>
                            <!-- Friends card -->
                            <div class="bg-white p-3 hover:shadow">
                                <div class="flex items-center space-x-3 font-semibold text-gray-900 text-xl leading-8">
                                    <span class="text-green-500">
                                        <svg class="h-5 fill-current"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </span>
                                    <span>Galeria</span>
                                </div>
                                <div class="grid grid-cols-1">
                                    <div class="div">
                                        <style>
                                            swiper-container {
                                                width: 100%;
                                                height: 100%;
                                            }

                                            swiper-slide {
                                                text-align: center;
                                                font-size: 18px;
                                                background: #fff;
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                            }

                                            swiper-slide img {
                                                display: block;
                                                width: 100%;
                                                height: 100%;
                                                object-fit: cover;
                                            }

                                            .mySwiper {
                                                max-height: 55%;
                                                width: 100%;
                                            }

                                            .mySwiper2 {
                                                height: 20%;
                                                box-sizing: border-box;
                                                padding: 10px 0;
                                            }

                                            .mySwiper2 swiper-slide {
                                                width: 25%;
                                                height: 100%;
                                                opacity: 0.4;
                                            }

                                            .mySwiper2 .swiper-slide-thumb-active {
                                                opacity: 1;
                                            }

                                            swiper-slide img {
                                                display: block;
                                                width: 100%;
                                                object-fit: cover;
                                            }

                                            /* LIGHTBOX*/

                                            /* CSS code for the lightbox */
                                            .lightbox {
                                                display: none;
                                                position: fixed;
                                                z-index: 999;
                                                top: 0;
                                                left: 0;
                                                width: 100%;
                                                height: 100%;
                                                background-color: rgba(0, 0, 0, 0.8);
                                            }

                                            .lightbox-content {
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                height: 100%;
                                            }

                                            .lightbox-image {
                                                max-width: 100%;
                                            }

                                            .lightbox-close {
                                                position: absolute;
                                                top: 0;
                                                right: 0;
                                                margin: 10px;
                                                padding: 5px 10px;
                                                border: none;
                                                font-size: 16px;
                                                cursor: pointer;
                                            }

                                            .lightbox-swiper {
                                                max-width: 70%;
                                                max-height: 70%;
                                            }

                                            .lightbox-swiper swiper-slide img {
                                                width: 100%;
                                                height: 100%;
                                            }
                                        </style>
                                        @if (empty($company['item']->gallery))
                                            <div class="mx-auto mt-6 rounded-lg">
                                                <img src="{{ !empty($company['gallery']) ? asset('storage/' . $company['gallery'][0]) : '/images/default.png' }}"
                                                     alt="Nome do Produto"
                                                     class="h-[250px] w-full object-cover rounded-lg lightbox-trigger">
                                            </div>
                                        @else
                                            <swiper-container class="mySwiper"
                                                              navigation="true"
                                                              thumbs-swiper=".mySwiper2">
                                                @foreach ($company['item']->gallery as $picture)
                                                    <swiper-slide>
                                                        <div class="mx-auto mt-6 rounded-lg">
                                                            <img src="{{ !empty($picture->file_location) ? asset('storage/' . $picture->file_location) : '/images/default.png' }}"
                                                                 alt="Nome do Produto"
                                                                 class="h-[250px] w-full object-cover rounded-lg lightbox-trigger">
                                                        </div>
                                                    </swiper-slide>
                                                @endforeach
                                            </swiper-container>

                                            <swiper-container class="mySwiper2 mt-4"
                                                              space-between="10"
                                                              slides-per-view="4"
                                                              free-mode="true"
                                                              watch-slides-progress="true">
                                                @foreach ($company['item']->gallery as $picture)
                                                    <swiper-slide class="rounded-lg object-cover">
                                                        <img src="{{ !empty($picture->file_location) ? asset('storage/' . $picture->file_location) : '/images/default.png' }}"
                                                             alt="Nome do Produto"
                                                             class="rounded-lg">
                                                    </swiper-slide>
                                                @endforeach
                                            </swiper-container>
                                        @endif

                                    </div>
                                    <!-- HTML code for the lightbox -->
                                    <div class="lightbox">
                                        <div class="lightbox-content">
                                            <swiper-container class="lightbox-swiper"
                                                              navigation="false"
                                                              thumbs-swiper=".mySwiper2">
                                                @foreach ($company['item']->gallery as $picture)
                                                    <swiper-slide>
                                                        <img src="{{ !empty($picture->file_location) ? asset('storage/' . $picture->file_location) : '/images/default.png' }}"
                                                             alt="Nome do Produto"
                                                             class="lightbox-image">
                                                    </swiper-slide>
                                                @endforeach
                                            </swiper-container>
                                            <button class="lightbox-close text-gray-50 bg-transparent"><i
                                                   class="fa fa-times text-4xl"></i></button>
                                        </div>
                                    </div>
                                    <script type="module">
                                        $(document).ready(function() {
                                            // Show lightbox when image is clicked
                                            $('.lightbox-trigger').click(function() {
                                                // Get the source of the image that was clicked
                                                var imgSrc = $(this).attr('src');
                                                // Set the source of the lightbox image to the clicked image source
                                                $('.lightbox-image').attr('src', imgSrc);
                                                // Show the lightbox
                                                $('.lightbox').fadeIn();
                                            });
                                            // Close lightbox when close button is clicked
                                            $('.lightbox-close').click(function() {
                                                // Hide the lightbox
                                                $('.lightbox').fadeOut();
                                            }); 
                                        });
                                    </script>
                                </div>
                            </div>
                            <!-- End of friends card -->
                        </div>
                        <!-- Right Side -->
                        <div class="w-full md:w-9/12 mx-2 h-64">
                            <!-- Profile tab -->
                            <!-- About Section -->
                            <div class="bg-white p-3 shadow-sm rounded-sm">
                                <div class="flex items-center space-x-2 font-semibold text-gray-900 leading-8">
                                    <span clas="text-green-500">
                                        <svg class="h-5"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </span>
                                    <span class="tracking-wide">Informações da Empresa</span>
                                </div>
                                {{-- {{ dd($company['item']) }} --}}
                                <div class="text-gray-700">
                                    <div class="grid md:grid-cols-2 text-sm">
                                        <div class="grid grid-cols-2">
                                            <div class="px-4 py-2 font-semibold">Nome fantasia</div>
                                            <div class="px-4 py-2">{{ $company['item']->name }}</div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="px-4 py-2 font-semibold">CNPJ</div>
                                            <div class="px-4 py-2">{{ $company['item']->document }}</div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="px-4 py-2 font-semibold">Telefone</div>
                                            <div class="px-4 py-2">{{ $company['item']->phone }}</div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="px-4 py-2 font-semibold">Endereço</div>
                                            <div class="px-4 py-2">{{ $company['item']->location }} -
                                                {{ $company['item']->zip_code }} - </div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="px-4 py-2 font-semibold">Email.</div>
                                            <div class="px-4 py-2">
                                                <a class="text-blue-800"
                                                   href="mailto:{{ $company['item']->mail }}">{{ $company['item']->email }}</a>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2">
                                            <div class="px-4 py-2 font-semibold">Web Site.</div>
                                            <div class="px-4 py-2">
                                                <a class="text-blue-800"
                                                   href="{{ $company['item']->website }}">{{ $company['item']->website }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <button
                                        class="block w-full text-blue-800 text-sm font-semibold rounded-lg hover:bg-gray-100 focus:outline-none focus:shadow-outline focus:bg-gray-100 hover:shadow-xs p-3 my-4">V</button> --}}
                            </div>
                            <!-- End of about section -->

                            <div class="my-4"></div>

                            <!-- Experience and education -->
                            <div class="bg-white p-3 shadow-sm rounded-sm">

                                <div class="grid gap-5">
                                    <div>
                                        <div
                                             class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                            <span clas="text-green-500">
                                                <i class="fa fa-shopping-cart"></i>
                                            </span>
                                            <span class="tracking-wide">Produtos</span>
                                        </div>
                                        <!-- Product grid -->
                                        @if (!empty($company['item']->products))
                                            <div class="products-grid my-10">
                                                <div
                                                     class="grid max-w-6xl grid-cols-1 gap-6 p-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                                                    @foreach ($company['item']->products as $product)
                                                        <article
                                                                 class="rounded-xl bg-white shadow-lg hover:shadow-xl duration-300 ">
                                                            <div
                                                                 class="relative flex items-end overflow-hidden rounded-xl max-h-[250px]">
                                                                <img src="{{ $product->image ? asset('storage/' . $product->image) : '/images/default.png' }}"
                                                                     class="object-cover h-[250px] w-full"
                                                                     alt="{{ $product['name'] }}" />
                                                            </div>

                                                            <div class="mt-1 p-2">
                                                                <a
                                                                   href="{{ route('store.product.show', ['companySlug' => $company['item']->slug, 'productSlug' => $product->slug, 'id' => $product->id]) }}">
                                                                    <h2 class="text-slate-700">{{ $product['name'] }}
                                                                        -
                                                                        {{ $product['model'] }}</h2>
                                                                </a>
                                                                <p class="mt-1 text-sm text-slate-400">
                                                                    Categoria
                                                                </p>

                                                                <div class="mt-3 flex items-end justify-between">
                                                                    <p class="text-lg font-bold text-blue-500">R$
                                                                        {{ $product['price'] }}
                                                                    </p>

                                                                    <div
                                                                         class="flex items-center space-x-1.5 rounded-lg bg-blue-500 px-4 py-1.5 text-white duration-100 hover:bg-blue-600">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             fill="none"
                                                                             viewBox="0 0 24 24"
                                                                             stroke-width="1.5"
                                                                             stroke="currentColor"
                                                                             class="h-4 w-4">
                                                                            <path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                                                        </svg>

                                                                        <button class="text-sm">comprar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        <div>
                                            <div
                                                 class="flex items-center space-x-2 font-semibold text-gray-900 leading-8 mb-3">
                                                <span clas="text-green-500">
                                                    <i class="fa fa-briefcase"></i>
                                                </span>
                                                <span class="tracking-wide">Serviços</span>
                                            </div>
                                            @if (!empty($company['item']->services))
                                                <div class="service-grid my-10">
                                                    <div
                                                         class="grid max-w-6xl grid-cols-1 gap-6 p-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                                                        @foreach ($company['item']->services as $service)
                                                            <article
                                                                     class="rounded-xl bg-white shadow-lg hover:shadow-xl duration-300 ">

                                                                <div
                                                                     class="relative flex items-end overflow-hidden rounded-xl max-h-[250px]">
                                                                    <img src="{{ $service->image ? asset('storage/' . $service->image) : '/images/default.png' }}"
                                                                         class="h-[250px] w-full object-cover"
                                                                         alt="Hotel Photo" />

                                                                </div>

                                                                <div class="mt-1 p-2">
                                                                    <a
                                                                       href="{{ route('store.service.show', ['companySlug' => $company['item']->slug, 'serviceSlug' => $service->slug, 'id' => $service->id]) }}">
                                                                        <h2 class="text-slate-700">
                                                                            {{ $service['name'] }}</h2>
                                                                        <p class="mt-1 text-sm text-slate-400">
                                                                            Fornecedor: {{ $service->company_name }}
                                                                        </p>
                                                                    </a>

                                                                    <div class="mt-3 flex items-end justify-between">
                                                                        <p class="text-lg font-bold text-blue-500">R$
                                                                            {{ $service['price'] }}
                                                                        </p>
                                                                        <a
                                                                           href="{{ route('store.service.show', ['companySlug' => $company['item']->slug, 'serviceSlug' => $service->slug, 'id' => $service->id]) }}">
                                                                            <div
                                                                                 class="flex items-center space-x-1.5 rounded-lg bg-blue-500 px-4 py-1.5 text-white duration-100 hover:bg-blue-600">
                                                                                <i class="fa fa-building-user"></i>

                                                                                <button class="text-sm">Ver
                                                                                    serviço</button>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- End of Experience and education grid -->
                                </div>
                                <!-- End of profile tab -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-guest-layout>
