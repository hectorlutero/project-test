<x-app-layout>
    <div class="bg-gray-900 min-h-screen flex items-center justify-center">
        <div
             class="bg-gray-800 flex-1 flex flex-col space-y-5 lg:space-y-0 lg:flex-row lg:space-x-10 sm:p-6 sm:my-2 sm:mx-4 sm:rounded-2xl">
            <!-- Navigation -->
            {{-- <div
                 class="bg-gray-900 px-2 lg:px-4 py-2 lg:py-10 sm:rounded-xl flex lg:flex-col justify-between ">
                <nav class="flex items-center flex-row space-x-2 lg:space-x-0 lg:flex-col lg:space-y-2">
                    <a class="text-white/50 p-4 inline-flex justify-center rounded-md hover:bg-gray-800 hover:text-white smooth-hover"
                       href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 sm:h-6 sm:w-6"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                  d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </a>
                    <!-- Active: bg-gray-800 text-white, Not active: text-white/50 -->
                    <a class="bg-gray-800 text-white p-4 inline-flex justify-center rounded-md"
                       href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 sm:h-6 sm:w-6"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                  d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                    </a>
                    <a class="text-white/50 p-4 inline-flex justify-center rounded-md hover:bg-gray-800 hover:text-white smooth-hover"
                       href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 sm:h-6 sm:w-6"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>
                </nav>
                <div class="flex items-center flex-row space-x-2 lg:space-x-0 lg:flex-col lg:space-y-2">
                    <a class="text-white/50 p-4 inline-flex justify-center rounded-md hover:bg-gray-800 hover:text-white smooth-hover"
                       href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 sm:h-6 sm:w-6"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a class="text-white/50 p-4 inline-flex justify-center rounded-md hover:bg-gray-800 hover:text-white smooth-hover"
                       href="#">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 sm:h-6 sm:w-6"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z"
                                  clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div> --}}
            <!-- Content -->
            <div class="flex-1 px-2 sm:px-0">
                <div class="flex justify-between items-center">
                    <h3 class="text-3xl font-extralight text-white/50">Mídias</h3>
                    <div class="inline-flex items-center space-x-2">
                        <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover"
                           href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </a>
                        <a class="bg-gray-900 text-white/50 p-2 rounded-md hover:text-white smooth-hover"
                           href="#">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-6 w-6"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="mb-10 sm:mb-0 mt-10 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
                    {{-- <form action="/admin/midia/new"
                          method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <label for="media-upload"
                               id="label-midia-upload"
                               class="group bg-gray-900/30 py-4 h-[250px] px-4 flex flex-col space-y-2 items-center justify-center cursor-pointer rounded-md hover:bg-gray-900/40 hover:smooth-hover ease-in-out duration-200">
                            <div id="media-upload-card"
                                 class="flex flex-col items-center">
                                <div
                                     class="bg-gray-900/70 text-white/50 group-hover:text-white flex w-20 h-20 rounded-full items-center justify-center ease-in-out duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-10 w-10"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1"
                                              d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <p class="text-white/50 group-hover:text-white text-center pt-2">Adicionar Mídia</p>
                                <input id="media-upload"
                                       name="media"
                                       type="file"
                                       class="hidden" />
                            </div>
                        </label>
                        <div id="media-upload-form"
                             class="hidden">
                            <div class="actions flex gap-2">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded">
                                    Enviar Mídia
                                </button>
                                <button type="button"
                                        id="cancel-selection"
                                        class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded">
                                    cancel
                                </button>
                            </div>
                        </div>

                    </form>
                    <script type="module">
                        $(document).ready($ => {
                            const mediaUploadCard = $('#media-upload-card');
                            const mediaUploadForm = $('#media-upload-form');
                            const mediaUploadInput = $('#media-upload');
                            const mediaUploadLabel = $('#label-midia-upload');
                            const cancelSelection = $('#cancel-selection');
                            const cardStyles =
                                'relative group bg-gray-900/30 py-4 h-[250px] max-h-[250px] px-4 flex flex-col space-y-2 items-center justify-center cursor-pointer rounded-md hover:bg-gray-900/40 hover:smooth-hover ease-in-out duration-200';

                            mediaUploadInput.on('change', () => {
                                if (mediaUploadInput[0].files.length > 0) {
                                    mediaUploadCard.addClass('hidden');
                                    mediaUploadForm.attr('class', cardStyles);
                                    mediaUploadLabel.css('display', 'none');

                                    const fileInfo = $('<div></div>')
                                        .attr('class', 'selected-file h-full flex flex-col justify-center text-center bg-gray-800 p-3 rounded-md font-bold text-white')
                                        .append($('<div></div>').text(`Selected file: ${mediaUploadInput[0].files[0].name}`));
                                    mediaUploadForm.prepend(fileInfo);
                                }
                            });

                            cancelSelection.on('click', () => {
                                mediaUploadCard.removeClass('hidden');
                                mediaUploadForm.attr('class', 'hidden');
                                mediaUploadLabel.css('display', 'flex');
                                $('.selected-file').remove();
                            })

                        })
                    </script> --}}

                    @forelse($entries['list'] as $entry)
                        <div
                             class="midia-card relative group h-[250px] bg-gray-900 py-4 sm:py-3 px-3 flex flex-col space-y-2 items-center cursor-pointer rounded-md hover:bg-gray-700/50 ease-in-out duration-200">
                            <img class="w-full h-full object-cover object-center rounded-md "
                                 src="/storage/{{ $entry->file_location }}"
                                 alt="{{ $entry->file_name }}" />
                            <div class="absolute inset-0 flex items-end justify-center group-hover:flex group-hover:bg-gray-900/50 rounded-md ease-in-out duration-200 p-6"
                                 style="margin-top: 0;">
                                <div
                                     class="bg-black/0 group-hover:bg-black/100 rounded-md group-hover:shadow-lg flex space-x-10 py-2 px-4 ease-in-out duration-200">
                                    <a href="#"
                                       class="text-gray-100/0  group-hover:hover:text-blue-600 group-hover:text-gray-100/100 ease-in-out duration-200">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.midia.delete', ['id' => $entry->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="text-gray-100/0 group-hover:hover:text-red-600 group-hover:text-gray-100/100 ease-in-out duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        A sua biblioteca de mídias está vazia.
                    @endforelse
                </div>

                <script type="module">
                    $(document).ready(function() {
                        $('.midia-card').on('click', function(e) {
                            // Prevent the click event from bubbling up to parent elements
                            e.stopPropagation();
                            
                            // Toggle the visibility of the delete/view options
                            $(this).find('.absolute').toggle();
                        });

                        $('.absolute').on('click', function(e) {
                            // Prevent the click event from bubbling up to parent elements
                            e.stopPropagation();
                        });

                        $('.fa-trash').on('click', function(e) {
                            // Handle the delete option
                            console.log('remove image');
                        });
                        
                        $('.fa-eye').on('click', function(e) {
                            // Handle the view option
                            console.log('view image');
                        });
                    })
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
