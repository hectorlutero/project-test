<x-app-layout>


    <div class="sm:px-6 w-full">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                   class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Serviços</p>
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
                <div class="flex">
                    <x-dropdown-filter align="left"
                                       action="{{ route('admin.services.index') }}"
                                       :elements="$entries['filtersMenu']"
                                       :checkedOptions="$entries['checkedOptions']" />
                    <form action="{{ route('admin.services.search') }}"
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
                </div>
                @can('manage_business')
                    <div class="table-actions">
                        <a href="{{ route('admin.service.show', ['id' => 'new']) }}"
                           class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded justify-self-end">
                            <p class="text-sm font-medium leading-none text-white"><i class="fa fa-plus mr-2"></i> Adicionar
                                Serviço</p>
                        </a>
                        <button onclick="event.preventDefault()"
                                data-method="POST"
                                data-url="{{ route('admin.service.import') }}"
                                class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded justify-self-end import-spreadsheet">
                            <p class="text-sm font-medium leading-none text-white"><i class="fa fa-upload mr-2"></i>
                                Importar
                                Planilha</p>
                        </button>
                    </div>
                @endcan
            </div>
            <div class="mt-7 overflow-x-auto">
                <x-services-table :entries="$entries['list']" />
            </div>
            <div class="w-full text-end">
                <a href="{{ route('admin.service.export') }}"
                   class="focus:ring-2 focus:ring-offset-2 focus:ring-lime-700 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-lime-700 hover:bg-lime-600 focus:outline-none rounded text-right">
                    <p class="text-sm font-medium leading-none text-white"><i class="fa fa-download mr-2"></i>
                        Modelo
                        de Planilha</p>
                </a>
            </div>
        </div>
    </div>
    <x-custom-confirmation-modal />
    @php
        $type = [
            'singular' => 'service',
            'plural' => 'services',
            'route' => [
                'save' => 'admin.service.save.many',
                'delete' => 'admin.service.delete.many',
            ],
            'method' => [
                'save' => 'POST',
                'delete' => 'DELETE',
            ],
        ];
    @endphp
    @can('manage_companies')
        @php
            $type['status'] = 'PUBLISHED';
        @endphp
    @endcan
    <x-mass-action :type="$type" />

</x-app-layout>
<style>
    .checkbox:checked+.check-icon {
        display: flex;
    }
</style>

<script>
    $("#change-order").on("change", function() {
        const order = $(this).val();
        window.location.href = "{{ route('admin.services.index') }}?order=" + order;
    });

    $(document).on("click", ".confirm-service-delete", function() {
        $("#confirmation-modal-title").text("Apagar serviço");
        $("#confirmation-modal-content").text("Tem certeza que deseja apagar este serviço?");
        $("#confirmation-modal-destination-url").val($(this).data('url'));
        $("#confirmation-modal-method").val($(this).data('method'));
        $("#confirmation-modal-id").val($(this).data('id'));
        $(".confirmation-modal-custom").toggle();
    });

    $(document).on("click", ".publish-item", function() {
        console.log($(this).attr('title'));
        if ($(this).data('status') === 'PUBLISHED') {
            $("#confirmation-modal-title").text("Publicar produto");
            $("#confirmation-modal-content").text("Tem certeza que deseja publicar este produto?");
        }
        if ($(this).data('status') === 'DRAFT') {
            $("#confirmation-modal-title").text("Tornar Rascunho");
            $("#confirmation-modal-content").text("Tem certeza que deseja tornar em rascunho este produto?");
        }
        $("#confirmation-modal-destination-url").val($(this).data('url'));
        $("#confirmation-modal-method").val($(this).data('method'));
        $("#confirmation-modal-id").val($(this).data('id'));
        $("#confirmation-modal-data").val($(this).data('status'));
        $(".confirmation-modal-custom").toggle();

    });

    $(document).on("click", ".import-spreadsheet", function() {
        $("#import-spreadsheet-title").text("Importar planilha de serviços");
        $("#import-spreadsheet-content").text("Tem certeza que deseja apagar este produto?");
        $("#import-spreadsheet-destination-url").val($(this).data('url'));
        $("#import-spreadsheet-method").val($(this).data('method'));
        $("#import-spreadsheet-id").val($(this).data('id'));
        $(".import-spreadsheet-modal").toggle();
    });
</script>
