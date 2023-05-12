<div class="dark:bg-gray-900">
    <div class="mx-auto py-5 md:py-12">
        <div class="h-[600px] relative">
            <img src="{{ asset('images/R.jpeg.webp') }}"
                 alt="A work table with house plants"
                 role="img"
                 class="h-[600px] w-full object-cover transform -scale-x-100" />
            <div class="absolute top-0 w-full h-full bg-black opacity-50"></div>
            <div class="absolute z-10 top-0 left-0 flex flex-col justify-center px-52 items-start h-full">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-semibold text-gray-100 sm:w-8/12">
                    Pedequevem!
                </h1>
                <p class="text-base leading-normal text-gray-100 mt-4 sm:mt-5 sm:w-5/12">
                    Encontre tudo que você precisa para o seu carro! Só PedeQueVem!
                </p>
                <a href="{{ route('search.index', ['term' => '']) }}"
                   class="hidden sm:flex bg-indigo-800 py-4 px-8 text-base font-medium text-white mt-8 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-800 hover:bg-white hover:text-indigo-800">
                    Veja nossa Loja!
                </a>
            </div>
            <button
                    class="absolute bottom-0 sm:hidden dark:bg-white dark:text-gray-100 bg-gray-800 py-4 text-base font-medium text-white mt-8 flex justify-center items-center w-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 hover:bg-gray-700">
                Explore
            </button>
        </div>
    </div>
</div>
