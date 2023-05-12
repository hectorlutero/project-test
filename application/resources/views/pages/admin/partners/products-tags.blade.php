<x-app-layout>


    <div class="sm:px-6 w-full">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                   class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Tags de Produtos</p>
                <div
                     class="py-3 px-4 flex items-center text-sm font-medium leading-none text-gray-600 bg-gray-200 hover:bg-gray-300 cursor-pointer rounded">
                    <p>Ordenação:</p>
                    <select aria-label="select"
                            class="focus:text-indigo-600 focus:outline-none bg-transparent ml-1"
                            id="change-order">
                        <option value="asc"
                                @if (request()->get('order') && request()->get('order') == 'asc') selected @endif>Mais antigos primeiro</option>
                        <option value="desc"
                                @if (request()->get('order') && request()->get('order') == 'desc') selected @endif>Mais recentes primeiro</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10">
            <div class="sm:flex items-center justify-between">
                <div class="flex items-center">
                    <x-dropdown-filter align="left"
                                       action="{{ route('admin.products-tags.index') }}" />
                </div>

                <a href="{{ route('admin.products-tags.show', ['id' => 'new']) }}"
                   class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">Adicionar Tag de Produto</p>
                </a>
            </div>
            <div class="mt-7 overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tbody>
                        @forelse($entries['list'] as $entry)
                            <tr tabindex="0"
                                class="focus:outline-none h-16 border border-gray-100 rounded register"
                                data-type="{{ $entry->status }}">
                                <td>
                                    <div class="ml-5">
                                        <div
                                             class="bg-gray-200 rounded-sm w-5 h-5 flex flex-shrink-0 justify-center items-center relative">
                                            <input placeholder="checkbox"
                                                   type="checkbox"
                                                   class="focus:opacity-100 checkbox opacity-0 absolute cursor-pointer w-full h-full" />
                                            <div class="check-icon hidden bg-indigo-700 text-white rounded-sm">
                                                <svg class="icon icon-tabler icon-tabler-check"
                                                     xmlns="http://www.w3.org/2000/svg"
                                                     width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24"
                                                     stroke-width="1.5"
                                                     stroke="currentColor"
                                                     fill="none"
                                                     stroke-linecap="round"
                                                     stroke-linejoin="round">
                                                    <path stroke="none"
                                                          d="M0 0h24v24H0z"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class=""
                                    title="Nome da Tag de Produto">
                                    <div class="flex items-center pl-5">
                                        <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                            {{ $entry->name }}</p>
                                        <a href="#"
                                           target="_blank">
                                            <!-- Inserir a URL para visualização da produto -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="16"
                                                 height="16"
                                                 viewBox="0 0 16 16"
                                                 fill="none">
                                                <path d="M6.66669 9.33342C6.88394 9.55515 7.14325 9.73131 7.42944 9.85156C7.71562 9.97182 8.02293 10.0338 8.33335 10.0338C8.64378 10.0338 8.95108 9.97182 9.23727 9.85156C9.52345 9.73131 9.78277 9.55515 10 9.33342L12.6667 6.66676C13.1087 6.22473 13.357 5.62521 13.357 5.00009C13.357 4.37497 13.1087 3.77545 12.6667 3.33342C12.2247 2.89139 11.6251 2.64307 11 2.64307C10.3749 2.64307 9.77538 2.89139 9.33335 3.33342L9.00002 3.66676"
                                                      stroke="#3B82F6"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M9.33336 6.66665C9.11611 6.44492 8.8568 6.26876 8.57061 6.14851C8.28442 6.02825 7.97712 5.96631 7.66669 5.96631C7.35627 5.96631 7.04897 6.02825 6.76278 6.14851C6.47659 6.26876 6.21728 6.44492 6.00003 6.66665L3.33336 9.33332C2.89133 9.77534 2.64301 10.3749 2.64301 11C2.64301 11.6251 2.89133 12.2246 3.33336 12.6666C3.77539 13.1087 4.37491 13.357 5.00003 13.357C5.62515 13.357 6.22467 13.1087 6.66669 12.6666L7.00003 12.3333"
                                                      stroke="#3B82F6"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                                <td class="pl-24"
                                    title="Categoria da Produto">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             width="20"
                                             height="20"
                                             viewBox="0 0 20 20"
                                             fill="none">
                                            <path d="M9.16667 2.5L16.6667 10C17.0911 10.4745 17.0911 11.1922 16.6667 11.6667L11.6667 16.6667C11.1922 17.0911 10.4745 17.0911 10 16.6667L2.5 9.16667V5.83333C2.5 3.99238 3.99238 2.5 5.83333 2.5H9.16667"
                                                  stroke="#52525B"
                                                  stroke-width="1.25"
                                                  stroke-linecap="round"
                                                  stroke-linejoin="round"></path>
                                            <circle cx="7.50004"
                                                    cy="7.49967"
                                                    r="1.66667"
                                                    stroke="#52525B"
                                                    stroke-width="1.25"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"></circle>
                                        </svg>
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                        </p>
                                    </div>
                                </td>
                                <td class="pl-5"
                                    title="Usuário que cadastrou a Produto">
                                    <div class="flex items-center">
                                        <svg viewBox="0 0 24 24"
                                             width="20"
                                             height="20"
                                             xmlns="http://www.w3.org/2000/svg"
                                             fill="#000000">
                                            <g id="SVGRepo_bgCarrier"
                                               stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier"
                                               stroke-linecap="round"
                                               stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <title></title>
                                                <g id="Complete">
                                                    <g id="user">
                                                        <g>
                                                            <path d="M20,21V19a4,4,0,0,0-4-4H8a4,4,0,0,0-4,4v2"
                                                                  fill="none"
                                                                  stroke="#000000"
                                                                  stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"></path>
                                                            <circle cx="12"
                                                                    cy="7"
                                                                    fill="none"
                                                                    r="4"
                                                                    stroke="#000000"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"></circle>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                        <p class="text-sm leading-none text-gray-600 ml-2"></p>
                                    </div>
                                </td>
                                <td class="pl-5"
                                    title="Imagens atribuidas à Produto">
                                    <div class="flex items-center">
                                        <svg fill="#000000"
                                             viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg"
                                             width="20"
                                             height="20">
                                            <g id="SVGRepo_bgCarrier"
                                               stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier"
                                               stroke-linecap="round"
                                               stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <path
                                                      d="M17.5531248,16.4450044 C17.6286997,16.179405 17.9052761,16.0253597 18.1708755,16.1009346 C18.4364749,16.1765095 18.5905202,16.4530859 18.5149453,16.7186853 C18.2719275,17.5727439 17.5931039,18.2421122 16.71594,18.4614032 L8.58845447,20.4931921 C7.21457067,20.8106614 5.86688485,19.9801117 5.55483435,18.6278929 L3.45442103,9.52610182 C3.14793844,8.19801056 3.96175966,6.86917188 5.28405996,6.53859681 L7.17308561,6.06634039 C7.44098306,5.99936603 7.71245031,6.16224638 7.77942467,6.43014383 C7.84639904,6.69804129 7.68351869,6.96950853 7.41562123,7.03648289 L5.52659559,7.50873931 C4.7332154,7.70708435 4.24492267,8.50438756 4.42881223,9.30124232 L6.52922555,18.4030334 C6.71644059,19.2142985 7.52497921,19.7125835 8.35461578,19.5209579 L16.4734044,17.4912607 C17.0000615,17.3595964 17.407086,16.9582414 17.5531248,16.4450044 Z M20,13.2928932 L20,5.5 C20,4.67157288 19.3284271,4 18.5,4 L9.5,4 C8.67157288,4 8,4.67157288 8,5.5 L8,11.2928932 L10.1464466,9.14644661 C10.3417088,8.95118446 10.6582912,8.95118446 10.8535534,9.14644661 L14.5637089,12.8566022 L17.2226499,11.0839749 C17.4209612,10.9517673 17.6850212,10.9779144 17.8535534,11.1464466 L20,13.2928932 L20,13.2928932 Z M19.9874925,14.6945992 L17.4362911,12.1433978 L14.7773501,13.9160251 C14.5790388,14.0482327 14.3149788,14.0220856 14.1464466,13.8535534 L10.5,10.2071068 L8,12.7071068 L8,14.5 C8,15.3284271 8.67157288,16 9.5,16 L18.5,16 C19.2624802,16 19.8920849,15.4310925 19.9874925,14.6945992 L19.9874925,14.6945992 Z M9.5,3 L18.5,3 C19.8807119,3 21,4.11928813 21,5.5 L21,14.5 C21,15.8807119 19.8807119,17 18.5,17 L9.5,17 C8.11928813,17 7,15.8807119 7,14.5 L7,5.5 C7,4.11928813 8.11928813,3 9.5,3 Z M16,5 L18,5 C18.5522847,5 19,5.44771525 19,6 L19,8 C19,8.55228475 18.5522847,9 18,9 L16,9 C15.4477153,9 15,8.55228475 15,8 L15,6 C15,5.44771525 15.4477153,5 16,5 Z M16,6 L16,8 L18,8 L18,6 L16,6 Z">
                                                </path>
                                            </g>
                                        </svg>
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                        </p>
                                    </div>
                                </td>
                                <form action="{{ route('admin.products-tags.delete', ['id' => $entry->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <td class="pl-4 text-right">
                                        <a href="{{ route('admin.products-tags.show', ['id' => $entry->id]) }}"
                                           class="focus:ring-2 focus:ring-offset-2 focus:ring-blue-950 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none">Visualizar</a>
                                        <button
                                                class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-gray-50 py-3 px-5 bg-red-400 rounded hover:bg-red-500 focus:outline-none">Apagar</a>
                                    </td>
                                </form>

                            </tr>
                            <tr class="h-3"></tr>

                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center">Nenhum registro encontrado</td>
                            </tr>
                        @endforelse

                    </tbody>
                    <tfoot>
                        {{ $entries['list']->links() }}
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


</x-app-layout>
<style>
    .checkbox:checked+.check-icon {
        display: flex;
    }
</style>

<script>
    $("#change-order").on("change", function() {
        const order = $(this).val();
        window.location.href = "{{ route('admin.products-tags.index') }}?order=" + order;
    });
</script>
