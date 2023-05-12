<input type="hidden"
       name="type"
       value="{{ $type['plural'] }}">
<input type="hidden"
       name="route"
       value="{{ route($type['route']['save']) }}">
<input type="hidden"
       name="method"
       value="{{ json_encode($type['method']) }}">
@can('manage_companies')
<input type="hidden"
       name="status"
       value="{{ $type['status'] }}">
@endcan
@push('post-scripts')
<script>
let type = $('[name=type]').val();
let route = $('[name=route]').val();
let status = $('[name=status]').val();
let method = JSON.parse($('[name=method]').val());
var selectedProducts = [];
const trashBtn = $(`
        <button type="submit" class="fixed bottom-10 right-10 bg-red-400 text-white text-center rounded-full w-[75px] h-[75px] flex justify-center items-center cursor-pointer trash-button text-4xl" title="Apagar Selecionados">
            <i class="fas fa-trash"></i>
        </button>`);
$('body').append(trashBtn);

if (status) {
    const publishBtn = $(`
            <button type="submit" class="fixed bottom-[130px] right-10 bg-emerald-400 text-white text-center rounded-full w-[75px] h-[75px] flex justify-center items-center cursor-pointer publish-button text-4xl" title="Publicar Selecionados">
                <i class="fas fa-file-lines"></i>
                </button>`);
    $('body').append(publishBtn);
    $('.publish-button').hide();
    $('.publish-button').slideUp(200);
}

$('.trash-button').hide();
$('.publish-button').hide();
$('.trash-button').slideUp(200);
$('.publish-button').slideUp(200);

// Generate overlay style
var checkedValues = [];
$(`input[name=${type}]`).on("change", function(e) {
    var productId = $(e.currentTarget).val();
    if ($(e.currentTarget).is(':checked')) {
        selectedProducts.push(productId);
    } else {
        var index = selectedProducts.indexOf(productId);
        if (index !== -1) {
            selectedProducts.shift(index, 1);
        }
    }
    $('.trash-button').slideDown(200);
    if (status)
        $('.publish-button').slideDown(200);


    // Update trashBtn visibility
    if (selectedProducts.length > 0) {
        if ($('.trash-button').length == 0) {
            $('.trash-button').slideDown(200);
            if (status)
                $('.publish-button').slideDown(200);
        }
    } else {
        $('.trash-button').slideUp(200);
        if (status)
            $('.publish-button').slideUp(200);
    }
});

$('.trash-button').on("click", function(e) {
    $(`[name=${type}]:checkbox:checked`).each(function(i) {
        let index = parseInt($(this).val());
        checkedValues[i] = index;

    });

    let data = {
        type: type,
        values: JSON.stringify(checkedValues),
        _token: '{{ csrf_token() }}'
    }

    let request = {
        route: route,
        method: method.delete,
        data: data
    }
    let currentProtocol = window.location.protocol; // Get the current protocol (http: or https:)
    if (currentProtocol === "https:") {
        request.route = request.route.replace(/^http:\/\//i,
            "https://"); // Replace "http://" with "https://" at the beginning of the string
    }
    ajaxRequest(request);
    $('.overlay').remove();
});

$('.publish-button').on("click", function(e) {
    $(`[name=${type}]:checkbox:checked`).each(function(i) {
        let index = parseInt($(this).val());
        checkedValues[i] = index;

    });

    let data = {
        type: type,
        values: JSON.stringify(checkedValues),
        _token: '{{ csrf_token() }}',
        status: status
    }

    let request = {
        route: route,
        method: method.save,
        data: data
    }
    let currentProtocol = window.location.protocol; // Get the current protocol (http: or https:)
    if (currentProtocol === "https:") {
        request.route = request.route.replace(/^http:\/\//i,
            "https://"); // Replace "http://" with "https://" at the beginning of the string
    }
    ajaxRequest(request);
    $('.overlay').remove();
});

function ajaxRequest(request) {
    console.log(request);
    $.ajax({
        url: request.route,
        method: request.method,
        data: request.data,
        success: function(response) {
            location.reload();
            // console.log(response);
            // Handle success response here
        },
        error: function(xhr) {
            location.reload();
            // console.log(xhr)
            // Handle error response here
        }
    });
}
</script>
@endpush