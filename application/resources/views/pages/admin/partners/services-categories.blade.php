<x-app-layout>


    <div class="sm:px-6 w-full">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                   class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Categoria de Serviços</p>
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
                                       action="{{ route('admin.services-categories.index') }}" />
                </div>

                <a href="{{ route('admin.services-categories.show', ['id' => 'new']) }}"
                   class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">Adicionar Categoria de Serviço</p>
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
                                    title="Nome da Serviço">
                                    <div class="flex items-center pl-5">
                                        <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                            {{ $entry->name }}</p>
                                        <a href="#"
                                           target="_blank">
                                            <!-- Inserir a URL para visualização da categorias de produtos -->
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

                                <form data-id="{{ $entry->id }}"
                                      class="confirm-delete-form"
                                      action="{{ route('admin.services-categories.delete', ['id' => $entry->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <td class="pl-4 text-right">

                                        <a href="{{ route('admin.services-categories.show', ['id' => $entry->id]) }}"
                                           class="focus:ring-2 focus:ring-offset-2 focus:ring-blue-950 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none">Visualizar</a>
                                        <button href="#"
                                                onclick="event.preventDefault()"
                                                data-method="DELETE"
                                                data-url="{{ route('admin.services-categories.delete', ['id' => $entry->id]) }}"
                                                data-id="{{ $entry->id }}"
                                                class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-gray-50 py-3 px-5 mx-0.5 bg-red-400 rounded hover:bg-red-500 focus:outline-none confirm-delete">Apagar</a>
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
    <x-custom-confirmation-modal />


</x-app-layout>
<style>
    .checkbox:checked+.check-icon {
        display: flex;
    }
</style>

<script>
    $("#change-order").on("change", function() {
        const order = $(this).val();
        window.location.href = "{{ route('admin.services-categories.index') }}?order=" + order;
    });
    $(document).on("click", ".confirm-delete", function() {
        $("#confirmation-modal-title").text("Apagar categoria de serviço");
        $("#confirmation-modal-content").text("Tem certeza que deseja apagar esta categoria de serviço?");
        $("#confirmation-modal-destination-url").val($(this).data('url'));
        $("#confirmation-modal-method").val($(this).data('method'));
        $("#confirmation-modal-id").val($(this).data('id'));
        $(".confirmation-modal-custom").toggle();
    });
</script>
