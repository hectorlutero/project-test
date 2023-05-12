<x-app-layout>


    <div class="sm:px-6 w-full">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                   class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Perfis de Acesso & Permissões</p>
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


                <a href="{{ route('admin.role.show', ['id' => 'new']) }}"
                   class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">Adicionar Perfil</p>
                </a>
            </div>
            <div class="mt-7 overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tbody>
                        @forelse($entries['list'] as $entry)
                            <tr tabindex="0"
                                class="focus:outline-none h-16 border border-gray-100 rounded register">
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
                                    title="Nome do Perfil">
                                    <div class="flex items-center pl-5">
                                        <p class="text-base font-medium leading-none text-gray-700 mr-2">
                                            {{ $entry->name }}
                                        </p>
                                    </div>
                                </td>

                                <td class="pl-5"
                                    title="Usuários vinculados à este Perfil de Acesso">
                                    <div class="flex items-center">
                                        <svg class="shrink-0 h-6 w-6"
                                             viewBox="0 0 24 24">
                                            <path class="fill-current @if (in_array(Request::segment(2), ['users'])) {{ 'text-indigo-500' }}@else{{ 'text-slate-600' }} @endif"
                                                  d="M18.974 8H22a2 2 0 012 2v6h-2v5a1 1 0 01-1 1h-2a1 1 0 01-1-1v-5h-2v-6a2 2 0 012-2h.974zM20 7a2 2 0 11-.001-3.999A2 2 0 0120 7zM2.974 8H6a2 2 0 012 2v6H6v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5H0v-6a2 2 0 012-2h.974zM4 7a2 2 0 11-.001-3.999A2 2 0 014 7z" />
                                            <path class="fill-current @if (in_array(Request::segment(2), ['users'])) {{ 'text-indigo-300' }}@else{{ 'text-slate-400' }} @endif"
                                                  d="M12 6a3 3 0 110-6 3 3 0 010 6zm2 18h-4a1 1 0 01-1-1v-6H6v-6a3 3 0 013-3h6a3 3 0 013 3v6h-3v6a1 1 0 01-1 1z" />
                                        </svg>
                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                            {{ \App\Models\User::role($entry->name)->count() }}
                                        </p>
                                    </div>
                                </td>
                                <form data-id="{{ $entry->id }}"
                                      class="confirm-delete-form"
                                      action="{{ route('admin.role.delete', ['id' => $entry->id]) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <td class="pl-4 text-right gap-4">
                                        <a href="{{ route('admin.role.show', ['id' => $entry->id]) }}"
                                           class="focus:ring-2 focus:ring-offset-2 focus:ring-blue-950 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none">Visualizar</a>
                                        <button href="#"
                                                onclick="event.preventDefault()"
                                                data-method="DELETE"
                                                data-url="{{ route('admin.role.delete', ['id' => $entry->id]) }}"
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
        window.location.href = "{{ route('admin.roles.index') }}?order=" + order;
    });

    $(document).on("click", ".confirm-delete", function() {
        $("#confirmation-modal-title").text("Apagar perfil de acesso");
        $("#confirmation-modal-content").text("Tem certeza que deseja apagar este perfil de acesso?");
        $("#confirmation-modal-destination-url").val($(this).data('url'));
        $("#confirmation-modal-method").val($(this).data('method'));
        $("#confirmation-modal-id").val($(this).data('id'));
        $(".confirmation-modal-custom").toggle();
    });
</script>
