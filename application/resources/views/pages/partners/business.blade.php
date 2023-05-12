<x-app-layout>


    <div class="sm:px-6 w-full">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                   class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Meus negócios</p>
            </div>
        </div>
        <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10">

            <div class="sm:flex items-center justify-between">
                <a href="{{ route('partner.business.show', ['id' => 'new']) }}"
                   class="right-0 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-5 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg width="24px"
                                 height="24px"
                                 viewBox="0 0 64 64"
                                 xmlns="http://www.w3.org/2000/svg"
                                 stroke-width="3"
                                 stroke="#ffffff"
                                 fill="none">
                                <g id="SVGRepo_bgCarrier"
                                   stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier"
                                   stroke-linecap="round"
                                   stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                          d="M30,52.16c.81-2.07,7.06-17,19.76-19.86a.09.09,0,0,0,0-.18c-2.14-.86-15.22-6.57-19.38-20.26a.09.09,0,0,0-.18,0c-.51,2.27-3.94,14.43-20,20a.1.1,0,0,0,0,.19c2.24.38,13.48,3.14,19.62,20.15A.1.1,0,0,0,30,52.16Z">
                                    </path>
                                    <path
                                          d="M48.79,25.08c.29-.74,2.52-6.07,7.06-7.09a0,0,0,0,0,0-.07c-.76-.3-5.43-2.34-6.92-7.23a0,0,0,0,0-.07,0c-.18.82-1.4,5.16-7.14,7.13a0,0,0,0,0,0,.07c.8.14,4.81,1.12,7,7.2A0,0,0,0,0,48.79,25.08Z">
                                    </path>
                                </g>
                            </svg>
                            <span
                                  class="text-sm font-medium ml-3 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200 text-white">
                                Criar novo negócio
                            </span>
                        </div>
                    </div>
                </a>
            </div>


            <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10">
                <div class="sm:flex items-center justify-between">
                    <div class="flex items-center">

                        <x-dropdown-filter align="left"
                                           action="{{ route('partner.businesses.index') }}"
                                           :elements="$entries['filtersMenu']['companies']"
                                           :checkedOptions="$entries['checkedOptions']['companies']" />
                        <form action="{{ route('partner.businesses.search') }}"
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
                    <div class="flex items-center flex-grow ml-10">
                        <p class="font-bold">Empresas</p>
                    </div>
                </div>
                <div class="mt-7 overflow-x-auto">
                    <x-companies-table :entries="$entries['list']['companies']" />
                </div>
            </div>



        </div>
    </div>

    <x-custom-confirmation-modal />
    {{-- <x-import-spreadsheet-modal :companies="$entries['list']['companies']"
                                type="service" /> --}}
    @php
        $type = [
            'singular' => 'company',
            'plural' => 'companies',
            'route' => [
                'save' => 'partner.business.save.many',
                'delete' => 'partner.business.delete.many',
            ],
            'method' => [
                'save' => 'POST',
                'delete' => 'DELETE',
            ],
        ];
    @endphp
    <x-mass-action :type="$type" />



</x-app-layout>
<style>
    .checkbox:checked+.check-icon {
        display: flex;
    }
</style>

<script>
    $("#service-change-order").on("change", function() {
        const order = $(this).val();
        window.location.href = "{{ route('partner.businesses.index') }}?service_order=" + order;
    });

    $(document).on("click", ".confirm-service-delete", function() {
        $("#confirmation-modal-title").text("Apagar serviço");
        $("#confirmation-modal-content").text("Tem certeza que deseja apagar este serviço?");
        $("#confirmation-modal-destination-url").val($(this).data('url'));
        $("#confirmation-modal-method").val($(this).data('method'));
        $("#confirmation-modal-id").val($(this).data('id'));
        $(".confirmation-modal-custom").toggle();
    });

    $(document).on("click", ".import-service-spreadsheet", function() {
        $("#import-spreadsheet-title").text("Importar planilha de serviços");
        $("#import-spreadsheet-content").text("Tem certeza que deseja apagar este produto?");
        $("#import-spreadsheet-destination-url").val($(this).data('url'));
        $("#import-spreadsheet-method").val($(this).data('method'));
        $("#import-spreadsheet-id").val($(this).data('id'));
        $(".import-spreadsheet-modal").toggle();
    });

    $("#company-change-order").on("change", function() {
        const order = $(this).val();
        window.location.href = "{{ route('partner.businesses.index') }}?company_order=" + order;
    });

    $(document).on("click", ".ban-button", function() {
        $("#confirmation-modal-title").text("Alterar Status");
        $("#confirmation-modal-content").text("Tem certeza que deseja alterar o status desta empresa?");
        $("#confirmation-modal-destination-url").val($(this).data('url'))
        $(".confirmation-modal-custom").toggle();
    });

    $(document).on("click", ".company-confirm-delete", function() {
        $("#confirmation-modal-title").text("Apagar empresa");
        $("#confirmation-modal-content").text("Tem certeza que deseja apagar esta empresa?");
        $("#confirmation-modal-destination-url").val($(this).data('url'));
        $("#confirmation-modal-method").val($(this).data('method'));
        $("#confirmation-modal-id").val($(this).data('id'));
        $(".confirmation-modal-custom").toggle();
    });
</script>
