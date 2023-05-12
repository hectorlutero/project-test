<nav x-data="{ open: false }"
     class="fixed top-0 left-0 z-20 w-full border-b border-gray-200 bg-gray-100 py-2.5 px-6 sm:px-4">

    <div class="container mx-auto flex justify-between items-center">
        <a href="/">
            <h1 class="h2">PedeQueVem!</h1>
        </a>
        <div class="relative w-full px-8 pl-5 flex justify-end">
            <form action="{{ route('search.index') }}"
                  method="get"
                  class="flex justify-end">
                @csrf
                <input type="text"
                       name="term"
                       class="h-14 right-0 w-[600px] rounded z-0 focus:shadow focus:outline-none"
                       placeholder="Procure o que você precisa...">
                <div class="relative top-4 right-10">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 z-20 hover:text-gray-500"></i>
                </div>
            </form>
            <div class="sm:right-0 text-right flex items-center">
                <a href={{ url('/') }}
                   class="cart-link ml-4 text-gray-600 hover:text-gray-900"
                   title="Meu Carrinho">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <a href={{ url('/') }}
                   class="cart-link ml-4 text-gray-600 hover:text-gray-900"
                   title="Favoritos">
                    <i class="fa-solid fa-heart"></i>
                </a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                            in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                @endif

            </div>
        </div>

        <ul class="hidden">
            <li><a href="#">Home</a></li>
            <li><a href="#">News</a></li>
            <li class="flex relative group">
                <a href="#"
                   class="mr-1">Services</a>
                <i class="fa-solid fa-chevron-down fa-2xs pt-3"></i>
                <!-- Submenu starts -->
                <ul
                    class="absolute bg-white p-3 w-52 top-6 transform scale-0 group-hover:scale-100 transition duration-150 ease-in-out origin-top shadow-lg">
                    <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">Webdesign</a></li>
                    <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">Digital marketing</a></li>
                    <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">SEO</a></li>
                    <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">Ad campaigns</a></li>
                    <li class="text-sm hover:bg-slate-100 leading-8"><a href="#">UX Design</a></li>
                </ul>
                <!-- Submenu ends -->
            </li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
        </ul>

        <a href="#"
           class="bg-red-400 px-5 py-1 rounded-3xl hover:bg-red-500 text-white hidden"
           role="button">Sign In</a>


        <!-- Mobile menu icon -->
        <button id="mobile-icon"
                class="md:hidden">
            <i onclick="changeIcon(this)"
               class="fa-solid fa-bars"></i>
        </button>

    </div>

    <!-- Mobile menu -->
    <div class="md:hidden flex justify-center mt-3 w-full">
        <div id="mobile-menu"
             class="mobile-menu absolute top-23 w-full">
            <!-- add hidden here later -->
            <ul class="bg-gray-100 shadow-lg leading-9 font-bold h-screen">
                <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="https://google.com"
                       class="block pl-7">Home</a></li>
                <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="#"
                       class="block pl-7">News</a></li>
                <li class="border-b-2 border-white hover:bg-red-400 hover:text-white">
                    <a href="#"
                       class="block pl-11">Services <i class="fa-solid fa-chevron-down fa-2xs pt-4"></i></a>

                    <!-- Submenu starts -->
                    <ul class="bg-white text-gray-800 w-full">
                        <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16"
                               href="#">Webdesign</a></li>
                        <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16"
                               href="#">Digital marketing</a></li>
                        <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16"
                               href="#">SEO</a></li>
                        <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16"
                               href="#">Ad campaigns</a></li>
                        <li class="text-sm leading-8 font-normal hover:bg-slate-200"><a class="block pl-16"
                               href="#">UX Design</a></li>
                    </ul>
                    <!-- Submenu ends -->
                </li>
                <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="#"
                       class="block pl-7">About</a></li>
                <li class="border-b-2 border-white hover:bg-red-400 hover:text-white pl-4"><a href="#"
                       class="block pl-7">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
