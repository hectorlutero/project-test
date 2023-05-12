$(document).ready(function () {
    $('[name=is24_7]').on('click', function () {
        if ($('[name=is24_7]').attr('value') == '1')
            $('[name=is24_7]').attr('value', 0)
        else
            $('[name=is24_7]').attr('value', 1)
    })
    $('[name=is24_7]').attr('value') === '1' ? $('[name=is24_7]').attr('checked', true) : $('[name=is24_7]').attr('checked', false)
    console.log('asdasd');
    tinymce.init({
        selector: 'textarea'
    });
})