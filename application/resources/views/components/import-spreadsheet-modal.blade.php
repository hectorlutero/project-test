<div class="fixed inset-0 overflow-y-auto z-50 import-spreadsheet-modal"
     style="display: none;">
    @php
        $type === 'service' ? ($tipo = 'serviço') : ($tipo = 'produto');
    @endphp
    <div class="fixed inset-0 transform transition-all import-spreadsheet-modal">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <div class="relative px-4 min-h-screen md:flex md:items-center md:justify-center">

        <div class="bg-black opacity-25 w-full h-full absolute z-10 inset-0"
             onclick="$('.import-spreadsheet-modal').hide()"></div>
        <div
             class="bg-white rounded-lg md:max-w-xl w-3/4 md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
            <form action="{{ route('partner.' . $type . '.import') }}"
                  class="import-spreadsheet-form"
                  enctype="multipart/form-data"
                  method="POST">
                @csrf
                <div class="items-center">
                    <div class="modal-header flex items-center">
                        <div
                             class="rounded-full border border-gray-300 flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                            <i class="fa fa-upload"></i>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 text-center md:text-left">

                        <div class="modal-content mt-5">

                            <div class="modal-header text-center my-5">
                                <input name="company"
                                       id="companies"
                                       type="hidden"
                                       value="{{ $company }}" />
                            </div>
                            <div class="bg-white p7 rounded w-full mx-auto">
                                <div x-data="dataFileDnD()"
                                     class="relative flex flex-col p-4 text-gray-400 border border-gray-200 rounded">
                                    <div x-ref="dnd"
                                         class="relative flex flex-col text-gray-400 border border-gray-200 border-dashed rounded cursor-pointer">
                                        <input accept="*"
                                               type="file"
                                               class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                                               @change="addFiles($event)"
                                               @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                                               @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                               @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                               name="spreadsheet"
                                               title="" />
                                        <div class="flex flex-col items-center justify-center py-10 text-center">
                                            <svg class="w-6 h-6 mr-1 text-current-50"
                                                 xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="m-0">Clique ou arraste sua planilha para esta área.</p>
                                            <p class="m-0">Formato aceito somente <b>.xlsx</b>.</p>
                                        </div>
                                    </div>

                                    <template x-if="files.length > 0">
                                        <div class="grid grid-cols-2 gap-4 mt-4 md:grid-cols-6"
                                             @drop.prevent="drop($event)"
                                             @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                                            <template x-for="(_, index) in Array.from({ length: files.length })">
                                                <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                                     style="padding-top: 100%;"
                                                     @dragstart="dragstart($event)"
                                                     @dragend="fileDragging = null"
                                                     :class="{ 'border-blue-600': fileDragging == index }"
                                                     draggable="true"
                                                     :data-index="index">
                                                    <button class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none"
                                                            type="button"
                                                            @click="remove(index)">
                                                        <svg class="w-4 h-4 text-gray-700"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             fill="none"
                                                             viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                    {{-- <template x-if="files[index].type.includes('audio/')">
                                                            <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 fill="none"
                                                                 viewBox="0 0 24 24"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                            </svg>
                                                        </template> --}}
                                                    <template
                                                              x-if="files[index].type.includes('application/') || files[index].type === ''">
                                                        <svg class="absolute w-12 h-12 text-lime-600 transform top-1/2 -translate-y-2/3"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             fill="none"
                                                             viewBox="0 0 24 24"
                                                             stroke="currentColor">
                                                            <path stroke-linecap="round"
                                                                  stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                        </svg>
                                                    </template>
                                                    {{-- <template x-if="files[index].type.includes('image/')">
                                                            <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                                                 x-bind:src="loadFile(files[index])" />
                                                        </template>
                                                        <template x-if="files[index].type.includes('video/')">
                                                            <video
                                                                   class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                                                <fileDragging x-bind:src="loadFile(files[index])"
                                                                              type="video/mp4">
                                                            </video>
                                                        </template> --}}

                                                    <div
                                                         class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-lime-600/40 bg-opacity-50">
                                                        <span class="w-full font-bold text-gray-900 truncate"
                                                              x-text="files[index].name">Loading</span>
                                                        <span class="text-xs text-gray-900"
                                                              x-text="humanFileSize(files[index].size)">...</span>
                                                    </div>

                                                    <div class="absolute inset-0 z-40 transition-colors duration-300"
                                                         @dragenter="dragenter($event)"
                                                         @dragleave="fileDropping = null"
                                                         :class="{
                                                             'bg-blue-200 bg-opacity-80': fileDropping ==
                                                                 index &&
                                                                 fileDragging != index
                                                         }">
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="modal-msg alert"
                                 style="margin-top: 10px; display: none;"
                                 role="alert"></div>
                        </div>
                    </div>

                </div>
                <div class="text-center md:text-right mt-4 md:flex md:justify-end">
                    <button type="submit"
                            class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2">Confirmar</button>
                    <button type="button"
                            class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
                md:mt-0 md:order-1"
                            onclick="$('.import-spreadsheet-modal').hide()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('post-scripts')
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
            defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    <script>
        // $(document).on("click", "#confirm-action", function() {
        //     $(this).prop("disabled", "disabled");
        //     const method = $("#import-spreadsheet-method").val();
        //     // const destinationUrl = $("#import-spreadsheet-destination-url").val();
        //     const itemId = $("#import-spreadsheet-id").val();

        //     if (method && method === "POST") $(`.import-spreadsheet-form`).submit();
        //     else window.location.href = destinationUrl;
        // });

        function dataFileDnD() {
            return {
                files: [],
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size) {
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " + ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove(index) {
                    let files = [...this.files];
                    files.splice(index, 1);

                    this.files = createFileList(files);
                },
                drop(e) {
                    let removed, add;
                    let files = [...this.files];

                    removed = files.splice(this.fileDragging, 1);
                    files.splice(this.fileDropping, 0, ...removed);


                    this.files = createFileList(files);

                    this.fileDropping = null;
                    this.fileDragging = null;
                },
                dragenter(e) {
                    let targetElem = e.target.closest("[draggable]");

                    this.fileDropping = targetElem.getAttribute("data-index");
                },
                dragstart(e) {
                    this.fileDragging = e.target
                        .closest("[draggable]")
                        .getAttribute("data-index");
                    e.dataTransfer.effectAllowed = "move";
                },
                loadFile(file) {
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);

                    preview.forEach(elem => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // free memory
                        };
                    });

                    return blobUrl;
                },
                addFiles(e) {
                    console.log(e.target.files);
                    if (e.target.files[0].type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        const files = createFileList([...this.files], [...e.target.files]);
                        this.files = files;
                        this.form.formData.files = [...files];
                    } else {
                        alert('Não é formato xlsx')
                    }
                }
            };
        }
    </script>
@endpush
