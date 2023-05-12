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
                               class="mr-2 text-sm font-medium text-gray-900">{{ $product['item']->company_name }}</a>
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
                               class="mr-2 text-sm font-medium text-gray-900">Produtos</a>
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
                           class="font-medium text-gray-500 hover:text-gray-600">{{ $product['item']->name }}</a>
                    </li>
                </ol>
            </nav>
            <div class="mx-auto product-summary container grid grid-cols-2">

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
                            height: 110px;
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
                    <!-- Add init="false" -->
                    <!-- Image gallery -->
                    @if (empty($product['gallery']))
                        <div class="mx-auto mt-6 rounded-lg">
                            <img src="{{ !empty($product['gallery']) ? asset('storage/' . $product['gallery'][0]) : '/images/default.png' }}"
                                 alt="Nome do Produto"
                                 class="h-[500px] w-full object-cover rounded-lg lightbox-trigger">
                        </div>
                    @else
                        <swiper-container class="mySwiper"
                                          navigation="true"
                                          thumbs-swiper=".mySwiper2">
                            @foreach ($product['gallery'] as $picture)
                                <swiper-slide>
                                    <div class="mx-auto mt-6 rounded-lg">
                                        <img src="{{ !empty($picture) ? asset('storage/' . $picture) : '/images/default.png' }}"
                                             alt="Nome do Produto"
                                             class="h-[500px] w-full object-cover rounded-lg lightbox-trigger">
                                    </div>
                                </swiper-slide>
                            @endforeach
                        </swiper-container>

                        <swiper-container class="mySwiper2"
                                          space-between="10"
                                          slides-per-view="4"
                                          free-mode="true"
                                          watch-slides-progress="true">
                            @foreach ($product['gallery'] as $picture)
                                <swiper-slide>
                                    <div class="mx-auto rounded-lg">
                                        <img src="{{ !empty($picture) ? asset('storage/' . $picture) : '/images/default.png' }}"
                                             alt="Nome do Produto"
                                             class="w-full object-cover rounded-lg">
                                    </div>
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
                            @foreach ($product['gallery'] as $picture)
                                <swiper-slide>
                                    <img src="{{ !empty($picture) ? asset('storage/' . $picture) : '/images/default.png' }}"
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

                        // Close lightbox when background is clicked
                        
                    });

                </script>

                <!-- Product info -->
                <div
                     class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
                    <div class="lg:col-span-2 lg:border-r lg:border-gray-200 lg:pr-8">
                        <p class="text-4xl mb-5 tracking-tight text-gray-900">R$ {{ $product['item']->price }}</p>
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            {{ $product['item']->name }} - {{ $product['item']->model }}</h1>
                        <div class="flex">

                            <a href="{{ route('store.company.show', ['companySlug' => $product['item']->company->slug, 'id' => $product['item']->company->id]) }}"
                               class="flex">
                                <p class="text-xl tracking-tight text-gray-400 pr-2 my-4">
                                    {{ $product['item']->company->name }} - {{ ' ' }}
                                </p>
                            </a>
                            <x-store.review-stars />
                        </div>
                        <button type="submit"
                                class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-8 py-3 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fa fa-shopping-cart mr-5"></i> Adicionar
                            ao carrinho</button>
                    </div>
                    <!-- Options -->
                    <div class="mt-4 lg:row-span-3 lg:mt-0">
                        <div class="mt-10">
                            <h4 class="text-xl mb-7 font-medium text-gray-900">Informações</h4>
                            <h3 class="text-sm font-medium text-gray-900">Highlights</h3>

                            <div class="mt-4">
                                <ul role="list"
                                    class="list-disc space-y-2 pl-4 text-sm">
                                    <li class="text-gray-400"><span class="text-gray-600">Hand cut and sewn
                                            locally</span>
                                    </li>
                                    <li class="text-gray-400"><span class="text-gray-600">Dyed with our proprietary
                                            colors</span></li>
                                    <li class="text-gray-400"><span class="text-gray-600">Pre-washed &amp;
                                            pre-shrunk</span></li>
                                    <li class="text-gray-400"><span class="text-gray-600">Ultra-soft 100%
                                            cotton</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h2 class="text-sm font-medium text-gray-900">Details</h2>

                            <div class="mt-4 space-y-6">
                                <p class="text-sm text-gray-600">The 6-Pack includes two black, two white, and two
                                    heather
                                    gray Basic Tees. Sign up for our subscription service and be the first to get new,
                                    exciting colors, like our upcoming &quot;Charcoal Gray&quot; limited release.</p>
                            </div>
                        </div>
                    </div>

                    <div
                         class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
                        <!-- Description and details -->
                        <div>
                            <h3 class="sr-only">Descrição</h3>

                            <div class="space-y-6">
                                <p class="text-base text-gray-900">{{ $product['item']->description }}</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-store.comments />

</x-guest-layout>
