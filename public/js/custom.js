function loadMore(button) {
    let $button = $(button);
    let url = $button.data('action');
    let page = $button.data('page');

    $.ajax({
        url: url + '?page=' + page,
        datatype: "html",
        type: "get",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            // $('.auto-load').hide();
            $("#data-wrapper").append(response.items);
            if (response.hasMore === false) {
                $button.hide();
                return;
            }
            page++;
            $button.data('page', page);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
}

// $(document).on("click", ".sideDash__mark", function () {
//     $('.sideDash__item').removeClass('sideDash__item--active')
//     $(this).parent().addClass('sideDash__item--active')
// });

$(document).on("click", ".removeCoatingCompare", function () {
    let productId = $(this).attr('id')
    let data = {
        '_token': $('meta[name="csrf_token"]').attr('content'),
        'product_id': productId,
    }

    $.ajax({
        url: '/deleteCompareCoating',
        data: data,
        type: "POST",
    })
        .done(function () {
            location.reload()
        })
});
// $(document).on('click','#deleteButtonId',function() {
//     let sessionId=$(this).children('input').val();
//     console.log(sessionId)
//     let data = {
//         '_token': $('meta[name="csrf_token"]').attr('content'),
//         'product_id': productId,
//     }
//     $.ajax({
//         url: 'index/cart/remove',
//         data: data,
//         type: "POST",
//     })
//         .done(function () {
//             location.reload()
//         })
// });
$(document).on("click", ".addToCartLink", function () {
    let $button = $(this);
    let $form = $button.closest('form.addToCartForm');
    let url = $form.attr('action');
    let data = $form.serialize();

    $.ajax({
        url: url,
        data: data,
        datatype: "html",
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            $('#cart_modal .cart-list__body').html(response.cartContentView);
            $('#cart_modal .cart-list__info').html(response.cartInfo);
            if(response.totalItemsInCart <= 0){
                $('.cart .countOfCart').addClass('inactive').html('');
            } else {
                $('.cart .countOfCart').removeClass('inactive').html(response.totalItemsInCart);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
});

$(document).on("click", ".addToCartLinkOneClick", function () {
    let $button = $(this);
    let $form = $button.closest('form.addToCartForm');
    let url = $form.attr('action');
    let data = $form.serialize()+'&temporary_cart=true';

    $.ajax({
        url: url,
        data: data,
        datatype: "html",
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            $('#cart_modal .cart-list__body').html(response.cartContentView);
            $('#cart_modal .cart-list__info').html(response.cartInfo);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
});

$(document).on("click", ".send__comment__btn", function () {
    let but = $(this)
    if ($.trim(but.parent().siblings(".textarea_body").val())) {
        let data = {
            '_token': $('meta[name="csrf_token"]').attr('content'),
            'user_id': but.parent().siblings(".user_id").val(),
            'order_id': but.parent().siblings(".order_id").val(),
            'body': but.parent().siblings(".textarea_body").val(),
        }

        $.ajax({
            url: '/comment/store',
            data: data,
            type: "POST",
            success: function (data) {
                $('.textarea_body').val('')
                but.parent().parent().siblings('.all__messages').append('<div class="history__comment" style="margin-bottom: 10px"><div class="history__commentHead"><div class="history__commentName">' + data.user + '</div><div class="history__commentTime">' + data.message_date + '</div></div><div class="history__commentBody">' + data.body + '</div></div>')
                let new_comment_count = parseInt($('.comment_count_' + data.order_id).children('span').html()) + 1
                $('.comment_count_' + data.order_id).children('span').html(new_comment_count)
            },
        })
    }
});
// $(document).on("click",".close-popup",function() {
//     let $button = $(this);
//     let $popup = $button.closest('.popup');
//     popup_close($popup);
// });

/** List calculator */
$(document).on("change", ".lengthSelect", function () {
    // alert(12345);
    calculateSquarePrice($(this).data('num'));
});

$(document).on("change", ".productCalc__inpCount", function () {
    // alert(1234);
    calculateSquarePrice($(this).data('num'));
});

$(document).on("click", ".productCalc__counterBtn--plus, .productCalc__counterBtn--minus", function () {
    // alert(123);
    calculateSquarePrice($(this).data('num'));
});

let gen = null
let f = false
$(document).on("click", ".sort_button", function () {

    f = true
    gen = $(this)
    let cat = $(this).html().trim()

    $.each($('.slider_item'), function (key, item) {
        $(this).css({"display": "block"})
        if ($(this).attr('id') != cat) {
            $(this).css({"display": "none"})
        } else {
            $(this).css({"display": "block", "width": "300px"})
        }
    })
    $('.all_categories').addClass('click_click')
    $('.click_click').trigger('click')
    $('.all_categories').removeClass('click_click')
});

$(document).on("click", ".all_categories", function () {

    general = $(this)
    if (!$('.all_categories').hasClass('click_click')) {
        $.each($('.slider_item'), function (key, item) {
            $(this).css({"display": "block", "width": "300px"})
        })
        $('.all_categories').trigger('click')
    } else if (!f) {
        $.each($('.slider_item'), function (key, item) {
            $(this).css({"display": "block", "width": "300px"})
        })
        // $('.all_categories').trigger('click')
    }
    f = false
    if (gen.html().trim() != 'Все') {
        gen.setAttribute('data-active', '')
    } else {
        $('.all_categories').setAttribute('data-active', '')
    }
});

function calculateSquarePrice(num = 1) {

    let $calculator = $('#productCalc');
    let attribute_total = parseFloat($('input[name=attribute_prices]').val());
    let width = $calculator.data('width') / 1000;
    let price = $calculator.data('price');

    // count
    let countToAdd = $('#countToAdd_'+num).val();

    if ($('#length__'+num).length) {


        // has calculator

        let length = $('#length__'+num).val() / 1000;

        // square
        let square = length * width;

        square = square * countToAdd;
        $('#totalSquare_'+num).text(square.toFixed(2));
        $('#totalSquareInput_'+num).val(square.toFixed(2));

        // price
        let calculatedPrice = (price - (-attribute_total)) * square;

        $('#totalPrice_'+num).text(calculatedPrice.toFixed(2));
        $('#totalPriceInput_'+num).val(calculatedPrice.toFixed(2));

    } else {
        // price

        let calculatedPrice = (price - (-attribute_total)) * countToAdd;

        $('#totalPrice_'+num).text(calculatedPrice.toFixed(2));
        $('#totalPriceInput_'+num).val(calculatedPrice.toFixed(2));
    }


}

calculateSquarePrice(1);

/* COLOR PICKER */

$(document).on("click", ".prodCard__color", function (event) {

    event.preventDefault();
    let $colorBox = $(this);
    $('.prodCard__color').removeClass('selected');
    $colorBox.addClass('selected');
    let $sliderSwiper = $colorBox.closest('.colorsSlider__wrapper');
    $sliderSwiper.find('input[name=color]').val($colorBox.data('color'));
});
$(document).on("click", ".rightPointer", function (event) {

    event.preventDefault();
    $('#content').animate({
        scrollLeft: "+=200px"
    }, "slow");
});
$(document).on("click", ".leftPointer", function (event) {

    event.preventDefault();
    $('#content').animate({
        scrollLeft: "-=200px"
    }, "slow");
});
$(document).on('click', '.product-cart-remove', function (event) {
    let $button = $(this);
    let url = '/cart/remove';
    let product_id = $button.data('product-id');
    let _token = $('meta[name=csrf_token]').attr('content');

    $.ajax({
        url: url,
        data: {product_id: product_id, _token: _token},
        datatype: "html",
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            $button.closest('.basket__card').remove();
            location.reload();
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
})

$(document).on('click', '.help_popup_submit_btn', function () {
    $('.popup_help').removeClass('_active')
})

if ($('#doc_type_id').length > 0) {
    setTimeout(function () {
        if ($('#doc_type_id').val() == 'Технические каталоги') $('#1').trigger('click');
        if ($('#doc_type_id').val() == 'Нормы и ГОСТы') $('#2').trigger('click');
        if ($('#doc_type_id').val() == 'Инструкции по монтажу') $('#3').trigger('click');
    }, 0.001);
}

$(document).on('click', '.first__type', function () {
    $('.doc_type').removeClass('active_doc_type-font')
    $('.doc_type').removeClass('active_doc_type')
    $(this).addClass('active_doc_type')
    $(this).addClass('active_doc_type-font')
    $('.first__type__color').css({"background-color": "#006BDE"})
    $('.threid__type__color').css({"background-color": "#F6F6F6"})
    $('.second__type__color').css({"background-color": "#F6F6F6"})
})

$(document).on('click', '.second__type', function () {
    $('.doc_type').removeClass('active_doc_type-font')
    $('.doc_type').removeClass('active_doc_type')
    $(this).addClass('active_doc_type')
    $(this).addClass('active_doc_type-font')
    $('.first__type__color').css({"background-color": "#F6F6F6"})
    $('.threid__type__color').css({"background-color": "#F6F6F6"})
    $('.second__type__color').css({"background-color": "#006BDE"})
})

$(document).on('click', '.threid__type', function () {
    $('.doc_type').removeClass('active_doc_type-font')
    $('.doc_type').removeClass('active_doc_type')
    $(this).addClass('active_doc_type')
    $(this).addClass('active_doc_type-font')
    $('.first__type__color').css({"background-color": "#F6F6F6"})
    $('.threid__type__color').css({"background-color": "#006BDE"})
    $('.second__type__color').css({"background-color": "#F6F6F6"})
})

$(document).on('click', '.doc_type', function () {
    let params = (new URL(document.location)).searchParams;
    let tagId = params.get('tagId');
    let page = params.get('page');
    let data = {
        '_token': $('meta[name="csrf_token"]').attr('content'),
        'type': $(this).attr('id')
    }
    if (tagId) {
        data.tagId = tagId;
    }
    if (page){
        data.page=page;
    }

    $.ajax({
        url: '/posts/tehnicheskie-katalogi',
        data: data,
        type: "POST",
        success: function (data) {
            $('.prodCard__docsBody').empty()
            // console.log(data.files.data)
            $.each(data.files.data, function (key, value) {
                $('.prodCard__docsBody').append('<div class="prodCard__docsItem" style="margin-right: 15px"><div class="prodCard__docsSvgBox"><svg><use xlink:href="http://mkrostov.ru/img/sprites/sprite-mono.svg#doc' + data.type + '"></use></svg></div></br><a class="prodCard__docsName link" href="../upload_files/' + value['filepath'] + '">' + value['title'] + '</a></div>')
            });
            if (data.files.length === 0) {
                $('.prodCard__docsBody').append('<h2 style="font-size: 30px">Пусто</h2>')
            }
        },
    })
})

$(document).on('click', '.file_search_input_btn', function () {
    if ($('.file_search_input').val() != '') {
        // console.log($('.active_doc_type').attr('id'))
        let data = {
            '_token': $('meta[name="csrf_token"]').attr('content'),
            'type': $('.active_doc_type').attr('id'),
            'search_body': $('.file_search_input').val(),
        }

        $.ajax({
            url: '/posts/tehnicheskie-katalogi',
            data: data,
            type: "POST",
            success: function (data) {
                $('.prodCard__docsBody').empty()
                $.each(data.files, function (key, value) {
                    $('.prodCard__docsBody').append('<div class="prodCard__docsItem" style="margin-right: 15px"><div class="prodCard__docsSvgBox"><svg><use xlink:href="http://mkrostov.ru/img/sprites/sprite-mono.svg#doc' + data.type + '"></use></svg></div></br><a class="prodCard__docsName link" href="../upload_files/' + value['filepath'] + '">' + value['title'] + '</a></div>')
                });
                if (data.files.length === 0) {
                    $('.prodCard__docsBody').append('<h2 style="font-size: 30px">Пусто</h2>')
                }
            },
        })
    }
})

$(document).on("click", ".open_help_popup", function () {
    $('.popup_help').addClass('_active')
});

$(document).on('submit', '.getConsult', function (event) {
    event.preventDefault();
    let $button = $(this);
    let $form = $button.closest('form');
    let url = '/storeFeedback';

    $.ajax({
        url: url,
        data: new FormData(this),
        datatype: "JSON",
        processData: false,
        contentType: false,
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            $form[0].reset();
            Swal.fire(
                '',
                response,
                'success'
            )
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
})


$(document).on('submit', '.getModalBuy', function (event) {
    event.preventDefault();
    let $button = $(this);
    let $form = $button.closest('form');
    let url = '/send/OneClickMail';

    $.ajax({
        url: url,
        data: new FormData(this),
        datatype: "JSON",
        processData: false,
        contentType: false,
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {

            $('.popup_buy').removeClass('_active')
            $form[0].reset();
            Swal.fire(
                '',
                'Запрос успешно отправлен! В ближайшее время с Вами свяжется менеджер!<br>',
                'success'
            )
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
})

$(document).on('click', '.addTo', function (event) {
    event.preventDefault();
    var product_id = $('.addToCartForm').find('[name="product_id"]').val();
    let $button = $(this);
    let destination = $button.data('destination');
    let $card = $button.closest('.card');
    let coatings = null
    $card.hasClass('coatings')
    let productId = $card.data('product');

    if ($card.hasClass('coatings')){
        coatings = 1
        productId = $card.data('product');
    }else if ($button.hasClass('coatings')){
        coatings = 1
        productId = $button.attr('id')
    }
    if(productId == undefined){
        productId = product_id;
    }
    let active = 1
    $button.hasClass('active') ? active = 1 : active = null;

    let _token = $('meta[name=csrf_token]').attr('content');
    let url = '/addTo' + destination;

    $.ajax({
        url: url,
        data: {product_id: productId, _token: _token, coatings: coatings, active: active},
        datatype: "html",
        type: "POST",
        beforeSend: function () {
            // $('.auto-load').show();
        }
    })
        .done(function (response) {
            $button.toggleClass('active');

            if ($button.hasClass('removeCard')) {
                $card.remove();
                location.reload();
            } else {
                console.log(response)
                Swal.fire(
                    '',
                    response.message,
                    'success'
                )
                if(response.count <= 0){
                    $('.' + destination.toLowerCase() +' .countOfCart').addClass('inactive').html('');
                } else {
                    $('.' + destination.toLowerCase() +' .countOfCart').removeClass('inactive').html(response.count);
                }

            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('Server error occured');
        });
})
