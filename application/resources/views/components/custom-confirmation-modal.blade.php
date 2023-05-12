<div class="fixed inset-0 overflow-y-auto z-50 confirmation-modal-custom"
     style="display: none;">
    <div class="fixed inset-0 transform transition-all confirmation-modal-custom">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <div class="relative px-4 min-h-screen md:flex md:items-center md:justify-center">
        <div class="bg-black opacity-25 w-full h-full absolute z-10 inset-0"
             onclick="$('.confirmation-modal-custom').hide()"></div>
        <div class="bg-white rounded-lg md:max-w-md md:mx-auto p-4 fixed inset-x-0 bottom-0 z-50 mb-4 mx-4 md:relative">
            <div class="md:flex items-center">
                <div
                     class="rounded-full border border-gray-300 flex items-center justify-center w-16 h-16 flex-shrink-0 mx-auto">
                    <svg width="30"
                         height="30"
                         viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="#000000">
                        <g id="SVGRepo_bgCarrier"
                           stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier"
                           stroke-linecap="round"
                           stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                  d="M1.225 21.225A1.678 1.678 0 0 0 2.707 22H22.28a1.68 1.68 0 0 0 1.484-.775 1.608 1.608 0 0 0 .003-1.656L13.995 1.827a1.745 1.745 0 0 0-2.969 0l-9.8 17.742a1.603 1.603 0 0 0 0 1.656zm.859-1.143l9.82-17.773A.71.71 0 0 1 12.508 2a.73.73 0 0 1 .629.342l9.751 17.708a.626.626 0 0 1 .017.662.725.725 0 0 1-.626.288H2.708a.723.723 0 0 1-.623-.286.605.605 0 0 1-.001-.632zM13 15h-1V8h1zm-1.5 2.5a1 1 0 1 1 1 1 1.002 1.002 0 0 1-1-1z">
                            </path>
                            <path fill="none"
                                  d="M0 0h24v24H0z"></path>
                        </g>
                    </svg>
                </div>
                <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                    <p class="font-bold"
                       id="confirmation-modal-title"></p>
                    <p class="text-sm text-gray-700 mt-1"
                       id="confirmation-modal-content"></p>
                    <input type="hidden"
                           id="confirmation-modal-destination-url">
                    <input type="hidden"
                           id="confirmation-modal-method">
                    <input type="hidden"
                           id="confirmation-modal-id">
                    <input type="hidden"
                           id="confirmation-modal-data">
                </div>
            </div>
            <div class="text-center md:text-right mt-4 md:flex md:justify-end">
                <button class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-red-200 text-red-700 rounded-lg font-semibold text-sm md:ml-2 md:order-2"
                        id="confirm-action">Confirmar</button>
                <button class="block w-full md:inline-block md:w-auto px-4 py-3 md:py-2 bg-gray-200 rounded-lg font-semibold text-sm mt-4
          md:mt-0 md:order-1"
                        onclick="$('.confirmation-modal-custom').hide()">Cancelar</button>
            </div>
        </div>
    </div>
</div>
@push('post-scripts')
<script>
$(document).on("click", "#confirm-action", function() {
    // $(this).prop("disabled", "disabled");
    const method = $("#confirmation-modal-method").val();
    let destinationUrl = $("#confirmation-modal-destination-url").val();
    const itemId = $("#confirmation-modal-id").val();
    const data = $("#confirmation-modal-data").val();
    let currentProtocol = window.location.protocol; // Get the current protocol (http: or https:)
    if (currentProtocol === "https:") {
        destinationUrl = destinationUrl.replace(/^http:\/\//i,
            "https://"); // Replace "http://" with "https://" at the beginning of the string
    }
    // console.log(destinationUrl)
    $.ajax({
        url: destinationUrl,
        method: method,
        data: {
            status: data,
            _token: '{{ csrf_token() }}',
        },
        success: function(response) {
            location.reload();
            // Handle success response here
        },
        error: function(xhr) {
            location.reload();
            // Handle error response here
        }
    });


});
</script>
@endpush