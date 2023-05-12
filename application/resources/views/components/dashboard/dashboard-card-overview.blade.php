        <div
             class="group flex flex-col col-span-full xl:col-span-4 max-w-md py-6  px-8 bg-white shadow-lg rounded-lg my-20">
            <div class="flex justify-center md:justify-end -mt-16">
                <div
                     class="w-20 h-20 flex items-center justify-center relative rounded-full border-2 border-indigo-500 group-hover:bg-indigo-500 transition ease-in-out duration-200">
                    <i
                       class="absolute {{ $data['icon'] }} text-4xl text-indigo-500 group-hover:text-white transition ease-in-out duration-200"></i>
                </div>
            </div>
            <div class="flex justify-between flex-col col-span-full">
                @if ($data['name'] === 'Empresas por Plano')
                    <h2 class="text-gray-800 text-3xl font-thin mb-4">{{ $data['name'] }}</h2>
                    <div class="flex justify-between px-3">
                        @foreach ($data['data'] as $plan)
                            <div class="col-span-1">
                                <h2 class="text-gray-500  text-center  text-xl font-thin">{{ $plan['name'] }}</h2>
                                <h2 class="mt-2 text-indigo-400 text-center text-6xl font-semibold">
                                    {{ $plan['entries'] }}
                                </h2>
                            </div>
                        @endforeach
                    </div>
                @else
                    @if ($data['name'] === 'Negócios')
                        <h2 class="text-gray-800 text-3xl font-thin mb-4">{{ $data['name'] }}</h2>
                        <a href="{{ $data['route'] ? route($data['route'], ['filter' => 'active']) : '#' }}">
                            <h2 class="mt-2 text-indigo-400 text-center text-6xl font-semibold">
                                {{ $data['data']['active'] }}
                            </h2>
                        </a>
                        <div class="flex justify-end mt-4">
                            <a href="{{ $data['route'] ? route($data['route'], ['filter' => 'pending_approval']) : '#' }}"
                               class="text-sm font-medium text-indigo-500">{{ $data['data']['pending'] > 0 ? ($data['data']['pending'] > 1 ? $data['data']['pending'] . ' negócios pendentes' : 1 . ' negócio pendente') . ' aprovação' : '' }}</a>
                        </div>
                    @else
                        <a href="{{ $data['route'] ? route($data['route']) : '#' }}">
                            <h2 class="text-gray-800 text-3xl font-thin mb-4">
                                {{ $data['name'] }}</h2>
                            <h2
                                class="mt-2 text-indigo-400 text-center {{ $data['name'] === 'Vendas' ? 'text-4xl' : 'text-6xl' }} font-semibold">
                                {{ $data['data'] }}
                            </h2>
                        </a>
                    @endif
                @endif
            </div>
        </div>
        <!-- Chart built with Chart.js 3 -->
        <!-- Check out src/js/components/dashboard-card-01.js for config -->
        <!-- Change the height attribute to adjust the chart height -->
        {{-- <canvas id="dashboard-card-01"
                width="389"
                height="128"></canvas> --}}
