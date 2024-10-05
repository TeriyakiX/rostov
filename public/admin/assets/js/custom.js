/*FORM*/

$(document).on('click', '.delete-photo', function(e) {
    e.preventDefault()
    $('input[name="is_delete"]').val(1)
    $('.main-page-image').attr('src', '')
})

$(document).on("click", ".ajaxForm button[type=submit]", function (event) {
    event.preventDefault();
    let $button = $(this);
    let $form = $button.closest('.ajaxForm');
    let url = $form.attr('action');

    let formData = new FormData($form[0]);

    if (jQuery('input[type=file]').length) {
        jQuery.each(jQuery('input[type=file]')[0].files, function (i, file) {
            formData.append('photos[' + i + ']', file);
        });
    }

    $.ajax({
        url: url,
        data: formData,
        // datatype: "html",
        type: "POST",
        async: false,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            // $button.closest('.form-group').remove();
            // console.log(response)
            alert('Запись успешно обновлена!');
            location.reload();
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {

            var response = JSON.parse(jqXHR.responseText);
            var errorString = '';
            $.each(response.errors, function (key, value) {
                errorString += value;
            });
            Swal.fire(
                '',
                errorString,
                'error'
            )

            console.log('Server error occured');
        });
});

/*PHOTOS!*/

$(document).on("click", ".delete-photo", function () {
    let csrf = $('meta[name=csrf_token]').attr('content');
    $button = $(this);
    let url = $button.data('url');

    $.ajax({
        url: url,
        data: {_token: csrf},
        datatype: "html",
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            $button.closest('.form-group').remove();
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
});

$(document).on("click", ".photo-add-block", function () {
    $button = $(this);
    $blockHtml = $('#photo-upload-item').html();
    $('#photo-upload-container').prepend($blockHtml);
});

$(document).on("click", ".file-add-block", function () {
    $button = $(this);
    $blockHtml = $('#file-upload-item').html();
    $('#file-upload-container').prepend($blockHtml);
});

/*ATTRIBUTES!*/

$(document).on("change", ".select-attribute", function () {
    let csrf = $('meta[name=csrf_token]').attr('content');
    $select = $(this);
    let attributeId = $select.val();

    $.ajax({
        url: '/admin/entity/attribute/' + attributeId + '/getOptions',
        data: {_token: csrf},
        datatype: "html",
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            console.log(response);
            let $optionsBlock = $select.closest('.attribute-block').find('.options');
            $optionsBlock.show();
            $optionsBlock.html(response);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
});

$(document).on("click", ".attribute-add-block", function () {
    $button = $(this);
    $blockHtml = $('#attribute-item').html();
    $('#attribute-item-container').append($blockHtml);
});

$(document).on("click", ".delete-option", function () {
    $button = $(this);
    $button.closest('.attribute-block').remove();
});

/*PRODUCT TYPE*/

$(document).on("change", ".product_type_radio", function () {
    let $radio = $(this);
    let typeNumber = $radio.val();
    $('.type_block').hide();
    $('#type_block_' + typeNumber).show();
});

/*MULTISELECT*/
let $multiselect = $('#multiselect');
let productId = $multiselect.data('product');
if (typeof productId !== 'undefined') {
    let csrf = $('meta[name=csrf_token]').attr('content');
    let dropdownData = $.ajax({
        url: '/admin/entity/multiselectItems',
        data: {_token: csrf, productId: productId, type: 'related'},
        type: "POST",
        async: false,
        success: function (data) {
            return data;
        }
    });
    $('#multiselect').dropdown({
        data: dropdownData.responseJSON,
        input: '<input type="text" maxLength="20" placeholder="Search">'
    });
}
let $multiselectSimilar = $('#multiselectSimilar');
let similarProductId = $multiselectSimilar.data('product');
if (typeof similarProductId !== 'undefined') {
    let csrf = $('meta[name=csrf_token]').attr('content');
    let dropdownData = $.ajax({
        url: '/admin/entity/multiselectItems',
        data: {_token: csrf, productId: productId, type: 'similar'},
        type: "POST",
        async: false,
        success: function (data) {
            return data;
        }
    });
    $('#multiselectSimilar').dropdown({
        data: dropdownData.responseJSON,
        input: '<input type="text" maxLength="20" placeholder="Search">'
    });
    console.log(dropdownData.responseJSON)
}
// let items = [];
// let uniqueArr = [];
// let inputArr=[];


// function getSelectedSimilarId() {
//     $('#multiselectSimilar option:selected').each(function () {
//         items.push($(this).val());
//     });
//     uniqueArr = Array.from(new Set(items))
//
//     uniqueArr.forEach(function (item){
//         if ( if (uniqueArr.hasOwnProperty('id')))
//         inputArr.push(item,`<input id="${ item }" type="text" name="similarSort[]" placeholder="номер сортировки">`)
//         // $('#sortSimilar').append(`<input id="${ item }" type="text" name="similarSort[]" placeholder="номер сортировки">`);
//     })
//     console.log(inputArr);
// }
// getSelectedSimilarId()



// $('#multiselectSimilar').on('click', function (e) {
//     getSelectedSimilarId()
//
// });


/*TagsMultiselect*/
let $multiselect1 = $('#multiselect1');
let productId1 = $multiselect1.data('product');
let entity = $multiselect1.data('entity');
if (typeof productId1 !== 'undefined') {
    let csrf = $('meta[name=csrf_token]').attr('content');

    let dropdownData = $.ajax({
        url: '/admin/entity/multiselectTags',
        data: {_token: csrf, entity: entity},
        type: "POST",
        async: false,
        success: function (data) {
            return data;
        }
    });
    console.log(dropdownData.responseJSON)
    $('#multiselect1').dropdown({
        data: dropdownData.responseJSON,
        input: '<input type="text" maxLength="20" placeholder="Search">'
    });
}
$('#myTiny').summernote({
    height: 300,
});
$('#calculateTiny').summernote({
    height: 300,
    callbacks: {
        onInit: function () {
            $("div.note-editor button.btn-codeview").click();
        }
    }
});

