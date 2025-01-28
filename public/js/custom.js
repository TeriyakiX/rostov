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

$(document).on("click", ".card__icon--basket", function () {
    let url = $(this).data("action");

    let productId = $(this).data("product-id");
    let quantity = $(this).data("quantity") || 1;
    let startPrice = $(this).data("start-price") || 0;
    let startPricePromo = $(this).data("start-price-promo") || 0;

    let price = $(this).data("price") || 0;
    let totalSquare = $(this).data("total-square") || 0;
    let length = $(this).data("length") || null;
    let attributePrices = $(this).data("attribute-prices") || 0;
    let color = $(this).data("color") || null;
    let coating = $(this).data("coating") || null;
    let width = $(this).data("width") || null;

    let totalPrice = totalSquare > 0
        ? ((price + attributePrices) * totalSquare).toFixed(2)
        : ((price + attributePrices) * quantity).toFixed(2);

    let data = {
        '_token': $('meta[name="csrf_token"]').attr('content'),
        'product_id': productId,
        'totalPrice': [totalPrice],
        'price': price,
        'startprice': startPrice,
        'startpricepromo': startPricePromo,
        'attribute_prices': attributePrices,
        'color': color,
        'totalSquare': [totalSquare],
        'length': [length],
        'quantity': [quantity],
        'width': width,
        'coating': coating,
    }

    $.ajax({
        url: url,
        datatype: "html",
        type: "POST",
        data: data,
        beforeSend: function () {
            $('#loader').fadeIn();
        }
    })
        .done(function (response) {
            $('#loader').fadeOut();
            showNotification(response.message, 'success')
            $('#cart_modal .cart-list__body').html(response.cartContentView);
            $('#cart_modal .cart-list__info').html(response.cartInfo);
            if(response.totalItemsInCart <= 0){
                $('.cart .countOfCart').addClass('inactive').html('');
            } else {
                $('.cart .countOfCart').removeClass('inactive').html(response.totalItemsInCart);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $('#loader').fadeOut();
            showNotification('Ошибка. Пожалуйста, попробуйте позже.', 'error');
            console.log('Server error occured');
        });
});

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
            $('#loader').fadeIn();
        }
    })
        .done(function (response) {
            $('#loader').fadeOut();
            showNotification(response.message, 'success')
            $('#cart_modal .cart-list__body').html(response.cartContentView);
            $('#cart_modal .cart-list__info').html(response.cartInfo);
            if(response.totalItemsInCart <= 0){
                $('.cart .countOfCart').addClass('inactive').html('');
            } else {
                $('.cart .countOfCart').removeClass('inactive').html(response.totalItemsInCart);
            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $('#loader').fadeOut();
            showNotification('Ошибка. Пожалуйста, попробуйте позже.', 'error');
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
            $('#loader').fadeIn();
        }
    })
        .done(function (response) {
            $('#loader').fadeOut();
            $('#cart_modal .cart-list__body').html(response.cartContentView);
            $('#cart_modal .cart-list__info').html(response.cartInfo);
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $('#loader').fadeOut();
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
                $('.prodCard__docsBody').append('<div class="prodCard__docsItem" style="margin-right: 15px"><div class="prodCard__docsSvgBox"><svg><use xlink:href="/img/sprites/sprite-mono.svg#doc' + data.type + '"></use></svg></div></br><a class="prodCard__docsName link" href="../upload_files/' + value['filepath'] + '">' + value['title'] + '</a></div>')
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
                    $('.prodCard__docsBody').append('<div class="prodCard__docsItem" style="margin-right: 15px"><div class="prodCard__docsSvgBox"><svg><use xlink:href="/img/sprites/sprite-mono.svg#doc' + data.type + '"></use></svg></div></br><a class="prodCard__docsName link" href="../upload_files/' + value['filepath'] + '">' + value['title'] + '</a></div>')
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
        beforeSend: function (response) {
            $('#loader').fadeIn();
        },
    })
        .done(function (response) {
            $('#loader').fadeOut();
            $('.popup_consult').removeClass('_active')
            $form[0].reset();
            // Swal.fire(
            //     '',
            //     response,
            //     'success'
            // )
            showNotification('Запрос успешно отправлен! Среднее время ожидания ответа: 20–30 минут в рабочее время.', 'info');
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $('#loader').fadeOut();
            var response = JSON.parse(jqXHR.responseText);
            var errorString = '';
            $.each(response.errors, function (key, value) {
                errorString += value;
            });
            // Swal.fire(
            //     '',
            //     errorString,
            //     'error'
            // )
            showNotification('Ошибка. Пожалуйста, попробуйте позже.', 'error');

            console.log('Server error occured');
        });
})


$(document).on('submit', '.getModalBuy', function (event) {
    event.preventDefault();
    let $button = $(this);
    let $form = $button.closest('form');
    let url = '/send/oneClickMail';

    $.ajax({
        url: url,
        data: new FormData(this),
        datatype: "JSON",
        processData: false,
        contentType: false,
        type: "POST",
        beforeSend: function (response) {
            $('#loader').fadeIn();
        },
    })
        .done(function (response) {
            $('#loader').fadeOut();
            $('.popup_buy').removeClass('_active')
            $form[0].reset();
            // Swal.fire(
            //     '',
            //     'Запрос успешно отправлен! В ближайшее время с Вами свяжется менеджер!<br>',
            //     'success'
            // )
            showNotification('Запрос успешно отправлен! Среднее время ожидания ответа: 20–30 минут в рабочее время.', 'info');
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $('#loader').fadeOut();
            try {
                if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                    let errorString = '';
                    $.each(jqXHR.responseJSON.errors, function (key, value) {
                        errorString += value + '<br>';
                    });
                    showNotification(errorString, 'error');
                } else {
                    if (jqXHR.status === 404) {
                        showNotification('Ошибка. Пожалуйста, попробуйте позже', 'error');
                    } else if (jqXHR.status === 500) {
                        showNotification('Ошибка. Пожалуйста, попробуйте позже', 'error');
                    } else {
                        showNotification('Ошибка. Пожалуйста, попробуйте позже', 'error');
                    }
                }
            } catch (e) {
                showNotification('Ошибка. Пожалуйста, попробуйте позже', 'error');
            }
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
        beforeSend: function (response) {
            $('#loader').fadeIn();
        },
    })
        .done(function (response) {
            $('#loader').fadeOut();
            $button.toggleClass('active');
            showNotification(response.message, 'success');

            if ($button.hasClass('removeCard')) {
                $card.remove();
                location.reload();
            } else {
                // Swal.fire(
                //     '',
                //     response.message,
                //     'success'
                // )
                if(response.count <= 0){
                    $('.' + destination.toLowerCase() +' .countOfCart').addClass('inactive').html('');
                } else {
                    $('.' + destination.toLowerCase() +' .countOfCart').removeClass('inactive').html(response.count);
                }

            }
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            $('#loader').fadeOut();
            showNotification('Ошибка. Пожалуйста, попробуйте позже.', 'error');
            console.log('Server error occured');
        });
})

$('form[data-ajax="true"]').on('submit', function (e) {
    e.preventDefault();

    let form = $(this);
    let formData = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function (response) {
          $('#loader').fadeIn();
        },
        success: function (response) {
            $('#loader').fadeOut();
            $('#successModal').fadeIn();
            form[0].reset();
        },
        error: function (xhr) {
            $('#loader').fadeOut();
            // alert('Ошибка: ' + (xhr.responseJSON?.error || 'Неизвестная ошибка'));
            showNotification('Ошибка. Пожалуйста, попробуйте позже.', 'error');
        },
    });
});

$(document).on('click', '.prodCard__icon--share', function () {
    const link = $(this).data('link');
    if (link && navigator.clipboard) {
        navigator.clipboard.writeText(link).then(() => {
            alert('Ссылка скопирована в буфер обмена!');
        }).catch(err => {
            console.error('Не удалось скопировать ссылку:', err);
        });
    }
});

$('[data-consent]').each(function () {
    const consentCheckbox = $(this);
    const submitButton = consentCheckbox.closest('form').find('[data-submit]');

    function toggleSubmitButton() {
        if (consentCheckbox.is(':checked')) {
            submitButton.removeClass('disabled').prop('disabled', false);
        } else {
            submitButton.addClass('disabled').prop('disabled', true);
        }
    }

    consentCheckbox.on('change', toggleSubmitButton);
    toggleSubmitButton();
});

function showNotification(message, type = 'success') {
    const $container = $('#notification-container');

    if ($container.length === 0) {
        $('body').append('<div id="notification-container" style="position: fixed; top: 32px; right: 32px; z-index: 9999; width: 364px; padding: 32px;"></div>');
    }

    const iconPaths = {
        success: '/img/icons/success.svg',
        error: '/img/icons/error.svg',
        info: '/img/icons/info_2.svg',
        close: '/img/icons/cross.svg'
    };

    const typeStyles = {
        success: { background: 'rgba(255, 255, 255, 1)', border: '1px solid rgba(89, 216, 20, 1)', color: 'rgba(89, 216, 20, 1)' },
        error: { background: 'rgba(255, 255, 255, 1)', border: '1px solid rgba(255, 0, 0, 1)', color: 'rgba(255, 0, 0, 1)' },
        info: { background: 'rgba(255, 255, 255, 1)', border: '1px solid rgba(0, 107, 222, 1)', color: 'rgba(0, 107, 222, 1)' }
    };

    const styles = typeStyles[type] || {
        background: '#000',
        border: '1px solid #000',
        color: 'white'
    };

    const $notification = $(`
        <div class="notification notification-${type}">
            <img class="notification-status" src="${iconPaths[type] || iconPaths.success}" alt="${type}">
            <span>${message}</span>
            <button>
                <img class="notification-close" src="${iconPaths.close}" alt="close">
            </button>
        </div>
    `);

    $notification.css({
        background: styles.background,
        border: styles.border,
        color: styles.color,
        padding: '16px',
        'margin-bottom': '8px',
        'border-radius': '8px',
        'box-shadow': '0 2px 5px rgba(0, 0, 0, 0.2)',
        opacity: 0,
        transition: 'opacity 0.3s, transform 0.3s',
        transform: 'translateY(-10px)'
    });

    $('#notification-container').append($notification);

    setTimeout(() => {
        $notification.css({
            opacity: 1,
            transform: 'translateY(0)'
        });
    }, 10);

    setTimeout(() => {
        $notification.css({
            opacity: 0,
            transform: 'translateY(-10px)'
        });
        setTimeout(() => $notification.remove(), 300);
    }, 3000);

    $notification.find('button').on('click', () => {
        $notification.css({
            opacity: 0,
            transform: 'translateY(-10px)'
        });
        setTimeout(() => $notification.remove(), 300);
    });
}
