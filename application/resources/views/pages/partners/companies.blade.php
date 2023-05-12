<x-app-layout>


    <div class="sm:px-6 w-full">
        <div class="px-4 md:px-10 py-4 md:py-7">
            <div class="flex items-center justify-between">
                <p tabindex="0"
                   class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-gray-800">
                    Empresas</p>
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
                    <button type="button"
                            class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 switch-status"
                            data-status="pending-approval">
                        <div class="py-2 px-8 bg-indigo-100 text-indigo-700 rounded-full">
                            <p>Pendente Aprovação</p>
                        </div>
                    </button>
                    <button type="button"
                            class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 ml-4 sm:ml-8 switch-status"
                            data-status="active">
                        <div class="py-2 px-8 text-gray-600 hover:text-indigo-700 hover:bg-indigo-100 rounded-full ">
                            <p>Ativas</p>
                        </div>
                    </button>
                    <button type="button"
                            class="rounded-full focus:outline-none focus:ring-2 focus:bg-indigo-50 focus:ring-indigo-800 ml-4 sm:ml-8 switch-status"
                            data-status="banned">
                        <div class="py-2 px-8 text-gray-600 hover:text-indigo-700 hover:bg-indigo-100 rounded-full ">
                            <p>Banidas</p>
                        </div>
                    </button>

                </div>
                <button
                        class="focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600 mt-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-indigo-700 hover:bg-indigo-600 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">Add Task</p>
                </button>
            </div>
            <div class="mt-7 overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <tbody>
                        @if ($companies)
                            @forelse($companies as $company)
                                <tr tabindex="0"
                                    class="focus:outline-none h-16 border border-gray-100 rounded register"
                                    data-type="{{ $company->status }}">
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
                                    <td class="">
                                        <div class="flex items-center pl-5">
                                            <p class="text-base font-medium leading-none text-gray-700 mr-2">Marketing
                                                Keynote Presentation</p>
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
                                        </div>
                                    </td>
                                    <td class="pl-24">
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
                                            <p class="text-sm leading-none text-gray-600 ml-2">Urgent</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="20"
                                                 height="20"
                                                 viewBox="0 0 20 20"
                                                 fill="none">
                                                <path d="M7.5 5H16.6667"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M7.5 10H16.6667"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M7.5 15H16.6667"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M4.16669 5V5.00667"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M4.16669 10V10.0067"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M4.16669 15V15.0067"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                            </svg>
                                            <p class="text-sm leading-none text-gray-600 ml-2">04/07</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="20"
                                                 height="20"
                                                 viewBox="0 0 20 20"
                                                 fill="none">
                                                <path d="M3.33331 17.4998V6.6665C3.33331 6.00346 3.59671 5.36758 4.06555 4.89874C4.53439 4.4299 5.17027 4.1665 5.83331 4.1665H14.1666C14.8297 4.1665 15.4656 4.4299 15.9344 4.89874C16.4033 5.36758 16.6666 6.00346 16.6666 6.6665V11.6665C16.6666 12.3295 16.4033 12.9654 15.9344 13.4343C15.4656 13.9031 14.8297 14.1665 14.1666 14.1665H6.66665L3.33331 17.4998Z"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M10 9.1665V9.17484"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M6.66669 9.1665V9.17484"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                                <path d="M13.3333 9.1665V9.17484"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                            </svg>
                                            <p class="text-sm leading-none text-gray-600 ml-2">23</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 width="20"
                                                 height="20"
                                                 viewBox="0 0 20 20"
                                                 fill="none">
                                                <path d="M12.5 5.83339L7.08333 11.2501C6.75181 11.5816 6.56556 12.0312 6.56556 12.5001C6.56556 12.9689 6.75181 13.4185 7.08333 13.7501C7.41485 14.0816 7.86449 14.2678 8.33333 14.2678C8.80217 14.2678 9.25181 14.0816 9.58333 13.7501L15 8.33339C15.663 7.67034 16.0355 6.77107 16.0355 5.83339C16.0355 4.8957 15.663 3.99643 15 3.33339C14.337 2.67034 13.4377 2.29785 12.5 2.29785C11.5623 2.29785 10.663 2.67034 10 3.33339L4.58333 8.75005C3.58877 9.74461 3.03003 11.0935 3.03003 12.5001C3.03003 13.9066 3.58877 15.2555 4.58333 16.2501C5.57789 17.2446 6.92681 17.8034 8.33333 17.8034C9.73985 17.8034 11.0888 17.2446 12.0833 16.2501L17.5 10.8334"
                                                      stroke="#52525B"
                                                      stroke-width="1.25"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"></path>
                                            </svg>
                                            <p class="text-sm leading-none text-gray-600 ml-2">04/07</p>
                                        </div>
                                    </td>
                                    <td class="pl-5">
                                        <button
                                                class="py-3 px-3 text-sm focus:outline-none leading-none text-red-700 bg-red-100 rounded">Due
                                            today at 18:00</button>
                                    </td>
                                    <td class="pl-4">
                                        <button
                                                class="focus:ring-2 focus:ring-offset-2 focus:ring-red-300 text-sm leading-none text-gray-600 py-3 px-5 bg-gray-100 rounded hover:bg-gray-200 focus:outline-none">View</button>
                                    </td>

                                </tr>
                                <tr class="h-3"></tr>

                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="text-center">Nenhum registro encontrado</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
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
        window.location.href = "{{ route('admin.companies') }}?order=" + order;
    });

    $(document).on("click", ".switch-status", function() {
        $(".switch-status").removeClass("bg-indigo-100 text-indigo-700").addClass(
            "text-gray-600 hover:text-indigo-700 hover:bg-indigo-100")
        // $(this).addClass("bg-indigo-100 text-indigo-700")
    })
</script>
