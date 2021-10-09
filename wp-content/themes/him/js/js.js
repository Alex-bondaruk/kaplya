[].map.call(document.querySelectorAll('.btn_click_custom'), el => {
    el.addEventListener('click', e => {
        e = e.touches ? e.touches[0] : e;
        const r = el.getBoundingClientRect(), d = Math.sqrt(Math.pow(r.width, 2) + Math.pow(r.height, 2)) * 2;
        el.style.cssText = `--s: 0; --o: 1;`;
        el.offsetTop;
        el.style.cssText = `--t: 1; --o: 0; --d: ${d}; --x:${e.clientX - r.left}; --y:${e.clientY - r.top};`
    })
});

$.fn.extend({
    filedrop: function (options) {
        var defaults = {
            callback: null
        }
        options = $.extend(defaults, options)
        return this.each(function () {
            var files = []
            var $this = $(this)

            // Stop default browser actions
            $this.bind('dragover dragleave', function (event) {
                event.stopPropagation()
                event.preventDefault()
            })

            // Catch drop event
            $this.bind('drop', function (event) {
                // Stop default browser actions
                event.stopPropagation()
                event.preventDefault()

                // Get all files that are dropped
                files = event.originalEvent.target.files || event.originalEvent.dataTransfer.files

                // Convert uploaded file to data URL and pass trought callback
                if (options.callback) {
                    var reader = new FileReader()
                    reader.onload = function (event) {
                        options.callback(event.target.result)
                    }
                    reader.readAsDataURL(files[0])
                }
                return false
            })
        })
    }
})


function paddingBodyHeader() {
    var headerHeight = $('.header_mob').outerHeight();
    $('body').css('padding-top', headerHeight + 'px');
}


if ($(window).width() < 923) {
    paddingBodyHeader();
}

$(window).on('resize', function () {
    var win = $(this);
    if (win.width() < 923) {
        paddingBodyHeader();
    } else {
        $('body').css('padding-top', 0);
    }
});

$('.dropzone').filedrop({
    callback: function (fileEncryptedData) {
        // a callback?
    }
})

$('.loadmore_posts').on('click', function(e){
    e.preventDefault();
    if(action == 'load_testim') {
        $(this).text('Загружаю...');
        var data = {
            'action': action,
            'query': true_posts,
            'page' : current_page
        };
        $.ajax({
            url:ajaxurl,
            data:data,
            type:'POST',
            success:function(data){
                if( data ) {
                    $('.loadmore_posts').text('Загрузить ещё');
                    $('.testimonials_page .s7_items').append(data);
                    current_page++;
                    if (current_page == max_pages) $(".loadmore_posts").remove();
                } else {
                    $('.loadmore_posts').remove();
                }
            }
        });
    }
    if(action == 'load_posts') {
        $(this).text('Загружаю...');
        var data = {
            'action': action,
            'query': true_posts,
            'page' : current_page
        };
        $.ajax({
            url:ajaxurl,
            data:data,
            type:'POST',
            success:function(data){
                if( data ) {
                    $('.loadmore_posts').text('Загрузить ещё');
                    $('.archive_post .s6_items').append(data);
                    current_page++;
                    if (current_page == max_pages) $(".loadmore_posts").remove();
                } else {
                    $('.loadmore_posts').remove();
                }
            }
        });
    }
});

$('.loadmore_posts_text').on('click', function (e) {
    e.preventDefault();
    if (action_text == 'load_testim_text') {
        $(this).text('Загружаю...');
        var data = {
            'action': action_text,
            'query': true_posts_text,
            'page_text': current_page_text
        };
        $.ajax({
            url: ajaxurl_text,
            data: data,
            type: 'POST',
            success: function (data) {
                if (data) {
                    $('.loadmore_posts_text').text('Загрузить ещё');
                    $('.testimonials_page .s7_items_text').append(data);
                    current_page_text++;
                    if (current_page_text == max_pages_text) $(".loadmore_posts_text").remove();
                } else {
                    $('.loadmore_posts_text').remove();
                }
            }
        });
    }
    if (action == 'load_posts') {
        $(this).text('Загружаю...');
        var data = {
            'action': action_text,
            'query': true_posts_text,
            'page_text': current_page_text
        };
        $.ajax({
            url: ajaxurl_text,
            data: data,
            type: 'POST',
            success: function (data) {
                if (data) {
                    $('.loadmore_posts_text').text('Загрузить ещё');
                    $('.archive_post .s6_items').append(data);
                    current_page_text++;
                    if (current_page_text == max_pages_text) $(".loadmore_posts_text").remove();
                } else {
                    $('.loadmore_posts_text').remove();
                }
            }
        });
    }
});

$('#menu_mob ul li a span').on('click', function (e) {
    if (e.target !== e.currentTarget) return;
    e.preventDefault();
    $(this).toggleClass('active');
    $(this).parent().siblings('ul').slideToggle();
});

$.extend($.expr[':'], {
    'off-top': function (el) { // проверка того, что элемент достиг верха экрана
        return $(el).offset().top < $(window).scrollTop();
    },
    'off-top-height': function (el) { // проверка того, что весь элемент ушел за верхний край экрана
        return ($(el).offset().top + $(el).outerHeight()) < $(window).scrollTop();
    },
    'off-right': function (el) { // проверка того, что элемент ушел за правый край
        return $(el).offset().left + $(el).outerWidth() - $(window).scrollLeft() > $(window).width();
    },
    'off-bottom': function (el) { // проверка того, что элемент ушел за нижний край
        return $(el).offset().top + $(el).outerHeight() - $(window).scrollTop() > $(window).height();
    },
    'off-left': function (el) { // проверка того, что элемент ушел за левый край
        return $(el).offset().left < $(window).scrollLeft();
    },
    'off-screen': function (el) { // элемент вышел из области видимости экран
        return $(el).is(':off-top, :off-right, :off-bottom, :off-left');
    }
});

var curHover = false;
$('.header_menu > ul > .dropdown').hover(function () {
    curHover = true;
    $(this).find('ul').css('left', 'auto');
    if ($(this).find('ul').is(":off-right")) {
        $(this).find('ul').css('left', 'auto');
        $(this).find('ul').css('right', 0);
    }
    if (!curHover) {
        $(this).find('ul').css('right', 'auto');
        $(this).find('ul').css('left', 0);
    }
    $(this).find('ul').addClass('active');
}, function () {
    $(this).find('ul').removeClass('active');
    curHover = false;
});
$(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
        $('.up_btn').fadeIn();
    } else {
        $('.up_btn').fadeOut();
    }
});
const beforeAfter = document.querySelector(".before_item");
if (beforeAfter != null) {
    $('.before_item').twentytwenty();
}
$('img.img_svg').each(function () {
    var $img = $(this);
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');
    $.get(imgURL, function (data) {
        var $svg = $(data).find('svg');
        if (typeof imgClass !== 'undefined') {
            $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }
        $svg = $svg.removeAttr('xmlns:a');
        if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
            $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }
        $img.replaceWith($svg);
    }, 'xml');
});
$('.before_slider').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    pauseOnHover: false,
    autoplay: false,
    /*  autoplaySpeed: 3000,*/
    /*  fade: false,*/
    arrows: true,
    dots: false,
    draggable: false,
    touchMove: false
})
/*
$('before-after').each(function() {
      btp_touch_handler_init( $(this).get(0) );
    }); 
    
    $( '.before-after').mousemove( function(event){
      var $this = $(this);
      var width = $this.width();
      var offset =$this.offset();   
      var x = event.pageX - offset.left;
      
      var delta = x/width *100;
      $this.find('.layer-after').css('left', delta + '%');
      $this.find('.before_item_photo_img').css('right', delta + '%');   
    });
	*/
$(".s8_item_title").click(function () {
    $(this).parent('.s8_item').toggleClass("s8_item_active");
    $(this).parent('.s8_item').children('.s8_item_desc').slideToggle(500);
});
!function (a) {
    "function" == typeof define && define.amd ? define(["jquery"], a) : a("object" == typeof exports ? require("jquery") : jQuery)
}(function (a) {
    var b, c = navigator.userAgent, d = /iphone/i.test(c), e = /chrome/i.test(c), f = /android/i.test(c);
    a.mask = {
        definitions: {9: "[0-9]", a: "[A-Za-z]", "*": "[A-Za-z0-9]"},
        autoclear: !0,
        dataName: "rawMaskFn",
        placeholder: "_"
    }, a.fn.extend({
        caret: function (a, b) {
            var c;
            if (0 !== this.length && !this.is(":hidden")) return "number" == typeof a ? (b = "number" == typeof b ? b : a, this.each(function () {
                this.setSelectionRange ? this.setSelectionRange(a, b) : this.createTextRange && (c = this.createTextRange(), c.collapse(!0), c.moveEnd("character", b), c.moveStart("character", a), c.select())
            })) : (this[0].setSelectionRange ? (a = this[0].selectionStart, b = this[0].selectionEnd) : document.selection && document.selection.createRange && (c = document.selection.createRange(), a = 0 - c.duplicate().moveStart("character", -1e5), b = a + c.text.length), {
                begin: a,
                end: b
            })
        }, unmask: function () {
            return this.trigger("unmask")
        }, mask: function (c, g) {
            var h, i, j, k, l, m, n, o;
            if (!c && this.length > 0) {
                h = a(this[0]);
                var p = h.data(a.mask.dataName);
                return p ? p() : void 0
            }
            return g = a.extend({
                autoclear: a.mask.autoclear,
                placeholder: a.mask.placeholder,
                completed: null
            }, g), i = a.mask.definitions, j = [], k = n = c.length, l = null, a.each(c.split(""), function (a, b) {
                "?" == b ? (n--, k = a) : i[b] ? (j.push(new RegExp(i[b])), null === l && (l = j.length - 1), k > a && (m = j.length - 1)) : j.push(null)
            }), this.trigger("unmask").each(function () {
                function h() {
                    if (g.completed) {
                        for (var a = l; m >= a; a++) if (j[a] && C[a] === p(a)) return;
                        g.completed.call(B)
                    }
                }

                function p(a) {
                    return g.placeholder.charAt(a < g.placeholder.length ? a : 0)
                }

                function q(a) {
                    for (; ++a < n && !j[a];) ;
                    return a
                }

                function r(a) {
                    for (; --a >= 0 && !j[a];) ;
                    return a
                }

                function s(a, b) {
                    var c, d;
                    if (!(0 > a)) {
                        for (c = a, d = q(b); n > c; c++) if (j[c]) {
                            if (!(n > d && j[c].test(C[d]))) break;
                            C[c] = C[d], C[d] = p(d), d = q(d)
                        }
                        z(), B.caret(Math.max(l, a))
                    }
                }

                function t(a) {
                    var b, c, d, e;
                    for (b = a, c = p(a); n > b; b++) if (j[b]) {
                        if (d = q(b), e = C[b], C[b] = c, !(n > d && j[d].test(e))) break;
                        c = e
                    }
                }

                function u() {
                    var a = B.val(), b = B.caret();
                    if (o && o.length && o.length > a.length) {
                        for (A(!0); b.begin > 0 && !j[b.begin - 1];) b.begin--;
                        if (0 === b.begin) for (; b.begin < l && !j[b.begin];) b.begin++;
                        B.caret(b.begin, b.begin)
                    } else {
                        for (A(!0); b.begin < n && !j[b.begin];) b.begin++;
                        B.caret(b.begin, b.begin)
                    }
                    h()
                }

                function v() {
                    A(), B.val() != E && B.change()
                }

                function w(a) {
                    if (!B.prop("readonly")) {
                        var b, c, e, f = a.which || a.keyCode;
                        o = B.val(), 8 === f || 46 === f || d && 127 === f ? (b = B.caret(), c = b.begin, e = b.end, e - c === 0 && (c = 46 !== f ? r(c) : e = q(c - 1), e = 46 === f ? q(e) : e), y(c, e), s(c, e - 1), a.preventDefault()) : 13 === f ? v.call(this, a) : 27 === f && (B.val(E), B.caret(0, A()), a.preventDefault())
                    }
                }

                function x(b) {
                    if (!B.prop("readonly")) {
                        var c, d, e, g = b.which || b.keyCode, i = B.caret();
                        if (!(b.ctrlKey || b.altKey || b.metaKey || 32 > g) && g && 13 !== g) {
                            if (i.end - i.begin !== 0 && (y(i.begin, i.end), s(i.begin, i.end - 1)), c = q(i.begin - 1), n > c && (d = String.fromCharCode(g), j[c].test(d))) {
                                if (t(c), C[c] = d, z(), e = q(c), f) {
                                    var k = function () {
                                        a.proxy(a.fn.caret, B, e)()
                                    };
                                    setTimeout(k, 0)
                                } else B.caret(e);
                                i.begin <= m && h()
                            }
                            b.preventDefault()
                        }
                    }
                }

                function y(a, b) {
                    var c;
                    for (c = a; b > c && n > c; c++) j[c] && (C[c] = p(c))
                }

                function z() {
                    B.val(C.join(""))
                }

                function A(a) {
                    var b, c, d, e = B.val(), f = -1;
                    for (b = 0, d = 0; n > b; b++) if (j[b]) {
                        for (C[b] = p(b); d++ < e.length;) if (c = e.charAt(d - 1), j[b].test(c)) {
                            C[b] = c, f = b;
                            break
                        }
                        if (d > e.length) {
                            y(b + 1, n);
                            break
                        }
                    } else C[b] === e.charAt(d) && d++, k > b && (f = b);
                    return a ? z() : k > f + 1 ? g.autoclear || C.join("") === D ? (B.val() && B.val(""), y(0, n)) : z() : (z(), B.val(B.val().substring(0, f + 1))), k ? b : l
                }

                var B = a(this), C = a.map(c.split(""), function (a, b) {
                    return "?" != a ? i[a] ? p(b) : a : void 0
                }), D = C.join(""), E = B.val();
                B.data(a.mask.dataName, function () {
                    return a.map(C, function (a, b) {
                        return j[b] && a != p(b) ? a : null
                    }).join("")
                }), B.one("unmask", function () {
                    B.off(".mask").removeData(a.mask.dataName)
                }).on("focus.mask", function () {
                    if (!B.prop("readonly")) {
                        clearTimeout(b);
                        var a;
                        E = B.val(), a = A(), b = setTimeout(function () {
                            B.get(0) === document.activeElement && (z(), a == c.replace("?", "").length ? B.caret(0, a) : B.caret(a))
                        }, 10)
                    }
                }).on("blur.mask", v).on("keydown.mask", w).on("keypress.mask", x).on("input.mask paste.mask", function () {
                    B.prop("readonly") || setTimeout(function () {
                        var a = A(!0);
                        B.caret(a), h()
                    }, 0)
                }), e && f && B.off("input.mask").on("input.mask", u), A()
            })
        }
    })
});
jQuery(function ($) {
    $(".phone_input").mask("+7 (999) 999-9999");
});
$(".burger").click(function () {
    $(".mob_menu").css("right", "0");
});
$(".mob_menu_close").click(function () {
    $(".mob_menu").css("right", "-100%");
});
$(function () {
    $('.up_btn').click(function () {
        $('html, body').animate({scrollTop: 0}, 1000);
        return false;
    });
});

const selectCustom = document.querySelector(".calc_select_inside select");
if (selectCustom != null) {
    $(".calc_select_inside select").select2({
        minimumResultsForSearch: -1
    });
}

const cartOrderSelect = document.querySelector(".modal_select_time--select select");
if (cartOrderSelect != null) {
    $(".modal_select_time--select select").select2({
        minimumResultsForSearch: -1,
        dropdownCssClass: "dropdown_time_select"
    });
}

var overlay = $('#overlay');
var open_modal = $('.open_modal');
var close_modal = $('.modal_close, #overlay');
var modal = $('.modal_window');

open_modal.on('click', function (event) {
    event.preventDefault();
    var div = $(this).attr('href');
    $(div).addClass('active');
    overlay.fadeIn(400,
        function () {
            $(div)
                .css('display', 'block')
                .animate({opacity: 1, top: '50%', marginTop: "-" + ($(div).outerHeight() / 2)}, 200);
            $('html').addClass('overflow-hidden');
        }
    );
});
close_modal.on('click', function (e) {
    if (e.target !== e.currentTarget) return;
    modal
        .animate(
            {opacity: 0, top: 45 + "%"}, 200,
            function () {
                $(this).css('display', 'none');
                overlay.fadeOut(400);
                $('html').removeClass('overflow-hidden');
            }
        );
    $(modal).removeClass('active');
});
var wpcf7Elm = document.querySelectorAll('.wpcf7');
for (var iElm = 0; iElm < wpcf7Elm.length; iElm++) {
    wpcf7Elm[iElm].addEventListener('wpcf7mailsent', function (event) {
        if ($('.modal_window').hasClass('active')) {
            $('.modal_window').animate(
                {opacity: 0, top: 45 + "%"}, 200,
                function () {
                    $(this).css('display', 'none');
                    var divCustom = $('#modal_success');
                    overlay.fadeIn(400,
                        function () {
                            $(divCustom)
                                .css('display', 'block')
                                .animate({
                                    opacity: 1,
                                    top: '50%',
                                    marginTop: "-" + ($(divCustom).outerHeight() / 2)
                                }, 200);
                            $('html').addClass('overflow-hidden');
                        }
                    );
                }
            );
        } else {
            var divCustom = $('#modal_success');
            overlay.fadeIn(400,
                function () {
                    $(divCustom)
                        .css('display', 'block')
                        .animate({opacity: 1, top: '50%', marginTop: "-" + ($(divCustom).outerHeight() / 2)}, 200);
                    $('html').removeClass('overflow-hidden');
                }
            );
        }
    }, false);
}

/*-----------------*/
/*-- CALCULATOR --*/
/*---------------*/

$.jqCart({
    buttons: '.modal_calc .submit',
    handler: url_ajax,
    visibleLabel: true,
    openByAdding: false,
    currency: '₽',
    cartLabel: '.open_cart'
});

$(document).on('click', '.jqcart_open_order a', function (e) {
    e.preventDefault();
//	var div = $(this).attr('href');
//	$(div).addClass('active');
//	overlay.fadeIn(400,
//		function() {
//			$(div)
//				.css('display', 'block')
//				.animate({opacity: 1, top: '50%', marginTop: "-" + ($(div).outerHeight()/2)}, 200);
//			    $('html').addClass('overflow-hidden');
//		}
//	);

    $('.cart_orders_wrapper').addClass('disable');
//	$('.jqcart-layout').remove();
    //setTimeout(methods.clearCart, 3000);
    $('.modal_calc_form').removeClass('disable');
});

// старая логика
$(document).on('click', '.back_to_cart', function (e) {
    e.preventDefault();
    $('.cart_orders_wrapper').removeClass('disable');
    $('.modal_calc_form').addClass('disable');
});

$(".input_number").on("keypress keyup blur", function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

$(".calc_quantity_input").on("keypress keyup blur", function (event) {
    var minPrice = parseInt($(this).attr('data-min'));
    var maxPrice = parseInt($(this).attr('data-max'));
    if ($(this).val() < minPrice) {
        $(this).val(minPrice);
    }
    if ($(this).val() > maxPrice) {
        $(this).val(maxPrice);
    }
});

$('.calc_quantity_control--plus').on('click', function (e) {
    e.preventDefault();
    var curPrice = $(this).parent().find('.calc_quantity_input').val();
    if (curPrice == '') {
        curPrice = 0;
    }
    curPrice = parseInt(curPrice);
    curPrice++;
    $(this).parent().find('.calc_quantity_input').val(curPrice);
    var minPrice = parseInt($(this).parent().find('.calc_quantity_input').attr('data-min'));
    var maxPrice = parseInt($(this).parent().find('.calc_quantity_input').attr('data-max'));
    if (curPrice < minPrice) {
        $(this).parent().find('.calc_quantity_input').val(minPrice);
    }
    if (curPrice > maxPrice) {
        $(this).parent().find('.calc_quantity_input').val(maxPrice);
    }
    $(this).parent().find('.calc_quantity_input').trigger('change');
});
$('.calc_quantity_control--minus').on('click', function (e) {
    e.preventDefault();
    var curPrice = $(this).parent().find('.calc_quantity_input').val();
    if (curPrice == '') {
        curPrice = 0;
    }
    curPrice = parseInt(curPrice);
    curPrice--;
    $(this).parent().find('.calc_quantity_input').val(curPrice);
    var minPrice = parseInt($(this).parent().find('.calc_quantity_input').attr('data-min'));
    var maxPrice = parseInt($(this).parent().find('.calc_quantity_input').attr('data-max'));
    if (curPrice < minPrice) {
        $(this).parent().find('.calc_quantity_input').val(minPrice);
    }
    if (curPrice > maxPrice) {
        $(this).parent().find('.calc_quantity_input').val(maxPrice);
    }
    $(this).parent().find('.calc_quantity_input').trigger('change');
});

/*-- CALCULATOR STUL --*/

const calcStul = document.querySelector("#form_stul");
if (calcStul != null) {

    var calcStulBack;
    var calcStulBackBool;
    var isStulBack = '';
    var calcStulBasicPrice = parseFloat($('#form_stul').find('input[name="basic_price"]').val());
    var calcStulBackPrice = parseFloat($('#form_stul').find('input[name="calc_stul_back"]').val());
    var calcStulMaterialPrice = parseFloat($('#form_stul').find('input[name="calc_stul_type"]:checked').val());
    var calcStulMaterialTitle = $('#form_stul').find('input[name="calc_stul_type"]:checked + span').text();
    var calcStulQuantity = $('#form_stul').find('.calc_quantity_input').val();
    var calcStulResult = 0;
    var calcStulPrice = 0;
    if ($('#form_stul').find('input[name="calc_stul_back"]').prop('checked')) {
        calcStulBack = calcStulBackPrice;
        calcStulBackBool = true;
    } else {
        calcStulBack = calcStulBasicPrice;
        calcStulBackBool = false;
    }
    if (calcStulBackBool) {
        isStulBack = 'true';
    } else {
        isStulBack = 'false';
    }
    calcStulPrice = calcStulMaterialPrice * calcStulBack;
    calcStulResult = (calcStulMaterialPrice * calcStulBack) * calcStulQuantity;
    $('#form_stul').find('.calc_price').html('Стоимость: <span>' + calcStulResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_stul').find('input[name="price"]').val(calcStulPrice.toFixed(0));
    $('#form_stul').find('input[name="total"]').val(calcStulResult.toFixed(0));
    $('#form_stul').find('input[name="quantity"]').val(calcStulQuantity);
    $('#form_stul .submit').attr('data-id', $('#form_stul input[name="id"]').val());
    $('#form_stul .submit').attr('data-title', $('#form_stul input[name="title"]').val());
    $('#form_stul .submit').attr('data-price', $('#form_stul input[name="price"]').val());
    $('#form_stul .submit').attr('data-total', $('#form_stul input[name="total"]').val());
    $('#form_stul .submit').attr('data-quantity', $('#form_stul input[name="quantity"]').val());
    $('#form_stul .submit').attr('data-type', $('#form_stul input[name="type"]').val());
    $('#form_stul .submit').attr('data-material', calcStulMaterialTitle);
    $('#form_stul .submit').attr('data-back', isStulBack);

    /*-------- CHANGE --------*/

    $('#form_stul input').on('change', function () {
        calcStulBack;
        calcStulBackBool;
        isStulBack = '';
        calcStulBasicPrice = parseFloat($('#form_stul').find('input[name="basic_price"]').val());
        calcStulBackPrice = parseFloat($('#form_stul').find('input[name="calc_stul_back"]').val());
        calcStulMaterialPrice = parseFloat($('#form_stul').find('input[name="calc_stul_type"]:checked').val());
        calcStulMaterialTitle = $('#form_stul').find('input[name="calc_stul_type"]:checked + span').text();
        calcStulQuantity = $('#form_stul').find('.calc_quantity_input').val();
        calcStulResult = 0;
        calcStulPrice = 0;
        if ($('#form_stul').find('input[name="calc_stul_back"]').prop('checked')) {
            calcStulBack = calcStulBackPrice;
            calcStulBackBool = true;
        } else {
            calcStulBack = calcStulBasicPrice;
            calcStulBackBool = false;
        }
        if (calcStulBackBool) {
            isStulBack = 'true';
        } else {
            isStulBack = 'false';
        }
        calcStulPrice = calcStulMaterialPrice * calcStulBack;
        calcStulResult = (calcStulMaterialPrice * calcStulBack) * calcStulQuantity;
        $('#form_stul').find('.calc_price').html('Стоимость: <span>' + calcStulResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_stul').find('input[name="price"]').val(calcStulPrice.toFixed(0));
        $('#form_stul').find('input[name="total"]').val(calcStulResult.toFixed(0));
        $('#form_stul').find('input[name="quantity"]').val(calcStulQuantity);
        $('#form_stul .submit').attr('data-id', $('#form_stul input[name="id"]').val());
        $('#form_stul .submit').attr('data-title', $('#form_stul input[name="title"]').val());
        $('#form_stul .submit').attr('data-price', $('#form_stul input[name="price"]').val());
        $('#form_stul .submit').attr('data-total', $('#form_stul input[name="total"]').val());
        $('#form_stul .submit').attr('data-quantity', $('#form_stul input[name="quantity"]').val());
        $('#form_stul .submit').attr('data-type', $('#form_stul input[name="type"]').val());
        $('#form_stul .submit').attr('data-material', calcStulMaterialTitle);
        $('#form_stul .submit').attr('data-back', isStulBack);
    });

}

/*-- CALCULATOR DIVAN --*/

const calcDivan = document.querySelector("#form_divan");
if (calcDivan != null) {

    var calcDivanClean = 0;
    var calcDivanUrina = 0;
    var calcDivanSelect = parseFloat($('#form_divan').find('select').val());
    var calcDivanSelectText = $('#form_divan').find('select option:selected').text();
    var calcDivanMaterialPrice = parseFloat($('#form_divan').find('input[name="calc_divan_type"]:checked').val());
    var calcDivanMaterialTitle = $('#form_divan').find('input[name="calc_divan_type"]:checked + span').text();
    var calcDivanPad = parseFloat($('#form_divan').find('input[name="calc_divan_pad"]').val());
    var calcDivanPadCur = $('#form_divan').find('input[name="calc_divan_pad"]').attr('data-item');
    var calcDivanPadCount = 0;
    var calcDivanPadResult = 0;
    var calcDivanResult = 0;
    var calcDivanPrice = 0;
    var calcDivanCleanBool;
    var calcDivanUrinaBool;
    var calcDivanCleanPadBool;
    var isDivanCleanBoth = '';
    var isDivanUrina = '';
    var isDivanCleanPad = '';
    if ($('#form_divan').find('input[name="calc_divan_clean"]').prop('checked')) {
        calcDivanClean = parseFloat($('#form_divan').find('input[name="calc_divan_clean"]').val());
        calcDivanCleanBool = true;
    } else {
        calcDivanClean = 0;
        calcDivanCleanBool = false;
    }
    if ($('#form_divan').find('input[name="calc_divan_pad"]').prop('checked')) {
        $('#form_divan').find('.calc_checkboxes--small').show();
        calcDivanCleanPadBool = true;
    } else {
        $('#form_divan').find('.calc_checkboxes--small').hide();
        calcDivanCleanPadBool = false;
    }
    if ($('#form_divan').find('input[name="calc_divan_pad"]').prop('checked')) {
        if (parseInt($('#form_divan').find('.calc_quantity_input').val()) > 0) {
            calcDivanPadCount = parseFloat($('#form_divan').find('.calc_quantity_input').val());
            calcDivanPadResult = calcDivanPadCount * calcDivanPad;
        } else {
            calcDivanPadCount = 0;
            calcDivanPadResult = 0
        }
    }
    if ($('#form_divan').find('input[name="calc_divan_urina"]').prop('checked')) {
        calcDivanUrina = parseFloat($('#form_divan').find('input[name="calc_divan_urina"]').val());
        calcDivanUrinaBool = true;
    } else {
        calcDivanUrina = 0;
        calcDivanUrinaBool = false;
    }
    if (calcDivanCleanBool) {
        isDivanCleanBoth = 'true';
    } else {
        isDivanCleanBoth = 'false';
    }
    if (calcDivanUrinaBool) {
        isDivanUrina = 'true';
    } else {
        isDivanUrina = 'false';
    }
    if (calcDivanCleanPadBool) {
        isDivanCleanPad = 'true';
    } else {
        isDivanCleanPad = 'false';
    }
    calcDivanPrice = (calcDivanSelect * calcDivanMaterialPrice) + calcDivanPadResult + calcDivanUrina + calcDivanClean;
    calcDivanResult = (calcDivanSelect * calcDivanMaterialPrice) + calcDivanPadResult + calcDivanUrina + calcDivanClean;
    $('#form_divan').find('.calc_price').html('Стоимость: <span>' + calcDivanResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_divan').find('input[name="price"]').val(calcDivanPrice.toFixed(0));
    $('#form_divan').find('input[name="total"]').val(calcDivanResult.toFixed(0));
    $('#form_divan').find('input[name="quantity"]').val('1');
    $('#form_divan .submit').attr('data-id', $('#form_divan input[name="id"]').val());
    $('#form_divan .submit').attr('data-title', $('#form_divan input[name="title"]').val());
    $('#form_divan .submit').attr('data-price', $('#form_divan input[name="price"]').val());
    $('#form_divan .submit').attr('data-total', $('#form_divan input[name="total"]').val());
    $('#form_divan .submit').attr('data-quantity', $('#form_divan input[name="quantity"]').val());
    $('#form_divan .submit').attr('data-type', $('#form_divan input[name="type"]').val());
    $('#form_divan .submit').attr('data-selectedtext', calcDivanSelectText);
    $('#form_divan .submit').attr('data-material', calcDivanMaterialTitle);
    $('#form_divan .submit').attr('data-padcount', calcDivanPadCount);
    $('#form_divan .submit').attr('data-cleanboth', isDivanCleanBoth);
    $('#form_divan .submit').attr('data-cleanurina', isDivanUrina);
    $('#form_divan .submit').attr('data-cleanpad', isDivanCleanPad);

    /*-------- CHANGE --------*/

    $('#form_divan input, #form_divan select').on('change', function () {
        calcDivanClean = 0;
        calcDivanUrina = 0;
        calcDivanSelect = parseFloat($('#form_divan').find('select').val());
        calcDivanSelectText = $('#form_divan').find('select option:selected').text();
        calcDivanMaterialPrice = parseFloat($('#form_divan').find('input[name="calc_divan_type"]:checked').val());
        calcDivanMaterialTitle = $('#form_divan').find('input[name="calc_divan_type"]:checked + span').text();
        calcDivanPad = parseFloat($('#form_divan').find('input[name="calc_divan_pad"]').val());
        calcDivanPadCur = $('#form_divan').find('input[name="calc_divan_pad"]').attr('data-item');
        calcDivanPadCount = 0;
        calcDivanPadResult = 0;
        calcDivanResult = 0;
        calcDivanPrice = 0;
        calcDivanCleanBool;
        calcDivanUrinaBool;
        calcDivanCleanPadBool;
        isDivanCleanBoth = '';
        isDivanUrina = '';
        isDivanCleanPad = '';
        if ($('#form_divan').find('input[name="calc_divan_clean"]').prop('checked')) {
            calcDivanClean = parseFloat($('#form_divan').find('input[name="calc_divan_clean"]').val());
            calcDivanCleanBool = true;
        } else {
            calcDivanClean = 0;
            calcDivanCleanBool = false;
        }
        if ($('#form_divan').find('input[name="calc_divan_pad"]').prop('checked')) {
            $('#form_divan').find('.calc_checkboxes--small').show();
            calcDivanCleanPadBool = true;
        } else {
            $('#form_divan').find('.calc_checkboxes--small').hide();
            calcDivanCleanPadBool = false;
        }
        if ($('#form_divan').find('input[name="calc_divan_pad"]').prop('checked')) {
            if (parseInt($('#form_divan').find('.calc_quantity_input').val()) > 0) {
                calcDivanPadCount = parseFloat($('#form_divan').find('.calc_quantity_input').val());
                calcDivanPadResult = calcDivanPadCount * calcDivanPad;
            } else {
                calcDivanPadCount = 0;
                calcDivanPadResult = 0
            }
        }
        if ($('#form_divan').find('input[name="calc_divan_urina"]').prop('checked')) {
            calcDivanUrina = parseFloat($('#form_divan').find('input[name="calc_divan_urina"]').val());
            calcDivanUrinaBool = true;
        } else {
            calcDivanUrina = 0;
            calcDivanUrinaBool = false;
        }
        if (calcDivanCleanBool) {
            isDivanCleanBoth = 'true';
        } else {
            isDivanCleanBoth = 'false';
        }
        if (calcDivanUrinaBool) {
            isDivanUrina = 'true';
        } else {
            isDivanUrina = 'false';
        }
        if (calcDivanCleanPadBool) {
            isDivanCleanPad = 'true';
        } else {
            isDivanCleanPad = 'false';
        }
        calcDivanPrice = (calcDivanSelect * calcDivanMaterialPrice) + calcDivanPadResult + calcDivanUrina + calcDivanClean;
        calcDivanResult = (calcDivanSelect * calcDivanMaterialPrice) + calcDivanPadResult + calcDivanUrina + calcDivanClean;
        $('#form_divan').find('.calc_price').html('Стоимость: <span>' + calcDivanResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_divan').find('input[name="price"]').val(calcDivanPrice.toFixed(0));
        $('#form_divan').find('input[name="total"]').val(calcDivanResult.toFixed(0));
        $('#form_divan').find('input[name="quantity"]').val('1');
        $('#form_divan .submit').attr('data-id', $('#form_divan input[name="id"]').val());
        $('#form_divan .submit').attr('data-title', $('#form_divan input[name="title"]').val());
        $('#form_divan .submit').attr('data-price', $('#form_divan input[name="price"]').val());
        $('#form_divan .submit').attr('data-total', $('#form_divan input[name="total"]').val());
        $('#form_divan .submit').attr('data-quantity', $('#form_divan input[name="quantity"]').val());
        $('#form_divan .submit').attr('data-type', $('#form_divan input[name="type"]').val());
        $('#form_divan .submit').attr('data-selectedtext', calcDivanSelectText);
        $('#form_divan .submit').attr('data-material', calcDivanMaterialTitle);
        $('#form_divan .submit').attr('data-padcount', calcDivanPadCount);
        $('#form_divan .submit').attr('data-cleanboth', isDivanCleanBoth);
        $('#form_divan .submit').attr('data-cleanurina', isDivanUrina);
        $('#form_divan .submit').attr('data-cleanpad', isDivanCleanPad);
    });

}

/*-- CALCULATOR KRESLO --*/

const calcKreslo = document.querySelector("#form_kreslo");
if (calcKreslo != null) {

    var calcKresloSlide;
    var calcKresloSlideBool;
    var isSlide = '';
    var calcKresloBasicPrice = parseFloat($('#form_kreslo').find('input[name="basic_price"]').val());
    var calcKresloSlidePrice = parseFloat($('#form_kreslo').find('input[name="calc_kreslo_sliding"]').val());
    var calcKresloMaterialPrice = parseFloat($('#form_kreslo').find('input[name="calc_kreslo_type"]:checked').val());
    var calcKresloMaterialTitle = $('#form_kreslo').find('input[name="calc_kreslo_type"]:checked + span').text();
    var calcKresloQuantity = $('#form_kreslo').find('.calc_quantity_input').val();
    var calcKresloResult = 0;
    var calcKresloPrice = 0;
    if ($('#form_kreslo').find('input[name="calc_kreslo_sliding"]').prop('checked')) {
        calcKresloSlide = calcKresloSlidePrice;
        calcKresloSlideBool = true;
    } else {
        calcKresloSlide = calcKresloBasicPrice;
        calcKresloSlideBool = false;
    }
    if (calcKresloSlideBool) {
        isSlide = 'true';
    } else {
        isSlide = 'false';
    }
    calcKresloPrice = calcKresloMaterialPrice * calcKresloSlide;
    calcKresloResult = (calcKresloMaterialPrice * calcKresloSlide) * calcKresloQuantity;
    $('#form_kreslo').find('.calc_price').html('Стоимость: <span>' + calcKresloResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_kreslo').find('input[name="price"]').val(calcKresloPrice.toFixed(0));
    $('#form_kreslo').find('input[name="total"]').val(calcKresloResult.toFixed(0));
    $('#form_kreslo').find('input[name="quantity"]').val(calcKresloQuantity);
    $('#form_kreslo .submit').attr('data-id', $('#form_kreslo input[name="id"]').val());
    $('#form_kreslo .submit').attr('data-title', $('#form_kreslo input[name="title"]').val());
    $('#form_kreslo .submit').attr('data-price', $('#form_kreslo input[name="price"]').val());
    $('#form_kreslo .submit').attr('data-total', $('#form_kreslo input[name="total"]').val());
    $('#form_kreslo .submit').attr('data-quantity', $('#form_kreslo input[name="quantity"]').val());
    $('#form_kreslo .submit').attr('data-type', $('#form_kreslo input[name="type"]').val());
    $('#form_kreslo .submit').attr('data-material', calcKresloMaterialTitle);
    $('#form_kreslo .submit').attr('data-slide', isSlide);

    /*-------- CHANGE --------*/

    $('#form_kreslo input').on('change', function () {
        calcKresloSlide;
        calcKresloSlideBool;
        isSlide = '';
        calcKresloBasicPrice = parseFloat($('#form_kreslo').find('input[name="basic_price"]').val());
        calcKresloSlidePrice = parseFloat($('#form_kreslo').find('input[name="calc_kreslo_sliding"]').val());
        calcKresloMaterialPrice = parseFloat($('#form_kreslo').find('input[name="calc_kreslo_type"]:checked').val());
        calcKresloMaterialTitle = $('#form_kreslo').find('input[name="calc_kreslo_type"]:checked + span').text();
        calcKresloQuantity = $('#form_kreslo').find('.calc_quantity_input').val();
        calcKresloResult = 0;
        calcKresloPrice = 0;
        if ($('#form_kreslo').find('input[name="calc_kreslo_sliding"]').prop('checked')) {
            calcKresloSlide = calcKresloSlidePrice;
            calcKresloSlideBool = true;
        } else {
            calcKresloSlide = calcKresloBasicPrice;
            calcKresloSlideBool = false;
        }
        if (calcKresloSlideBool) {
            isSlide = 'true';
        } else {
            isSlide = 'false';
        }
        calcKresloPrice = calcKresloMaterialPrice * calcKresloSlide;
        calcKresloResult = (calcKresloMaterialPrice * calcKresloSlide) * calcKresloQuantity;
        $('#form_kreslo').find('.calc_price').html('Стоимость: <span>' + calcKresloResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_kreslo').find('input[name="price"]').val(calcKresloPrice.toFixed(0));
        $('#form_kreslo').find('input[name="total"]').val(calcKresloResult.toFixed(0));
        $('#form_kreslo').find('input[name="quantity"]').val(calcKresloQuantity);
        $('#form_kreslo .submit').attr('data-id', $('#form_kreslo input[name="id"]').val());
        $('#form_kreslo .submit').attr('data-title', $('#form_kreslo input[name="title"]').val());
        $('#form_kreslo .submit').attr('data-price', $('#form_kreslo input[name="price"]').val());
        $('#form_kreslo .submit').attr('data-total', $('#form_kreslo input[name="total"]').val());
        $('#form_kreslo .submit').attr('data-quantity', $('#form_kreslo input[name="quantity"]').val());
        $('#form_kreslo .submit').attr('data-type', $('#form_kreslo input[name="type"]').val());
        $('#form_kreslo .submit').attr('data-material', calcKresloMaterialTitle);
        $('#form_kreslo .submit').attr('data-slide', isSlide);
    });

}

/*-- CALCULATOR PUFIK --*/

const calcPufik = document.querySelector("#form_pufik");
if (calcPufik != null) {

    var calcPufikMaterialTitle = $('#form_pufik').find('input[name="calc_pufik_type"]:checked + .calc_checkbox_input_txt').text();
    var calcPufikMaterialPrice = parseFloat($('#form_pufik').find('input[name="calc_pufik_type"]:checked').val());
    var calcPriceQuantity = $('#form_pufik').find('.calc_quantity_input').val();
    var calcPufikResult = 0;
    var calcPufikPrice = 0;
    calcPufikPrice = calcPufikMaterialPrice;
    calcPufikResult = calcPufikMaterialPrice * calcPriceQuantity;
    $('#form_pufik').find('.calc_price').html('Стоимость: <span>' + calcPufikResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_pufik').find('input[name="price"]').val(calcPufikPrice.toFixed(0));
    $('#form_pufik').find('input[name="total"]').val(calcPufikResult.toFixed(0));
    $('#form_pufik').find('input[name="quantity"]').val(calcPriceQuantity);
    $('#form_pufik .submit').attr('data-id', $('#form_pufik input[name="id"]').val());
    $('#form_pufik .submit').attr('data-title', $('#form_pufik input[name="title"]').val());
    $('#form_pufik .submit').attr('data-price', $('#form_pufik input[name="price"]').val());
    $('#form_pufik .submit').attr('data-total', $('#form_pufik input[name="total"]').val());
    $('#form_pufik .submit').attr('data-quantity', $('#form_pufik input[name="quantity"]').val());
    $('#form_pufik .submit').attr('data-type', $('#form_pufik input[name="type"]').val());
    $('#form_pufik .submit').attr('data-material', calcPufikMaterialTitle);

    /*-------- CHANGE --------*/

    $('#form_pufik input').on('change', function () {
        calcPufikMaterialTitle = $('#form_pufik').find('input[name="calc_pufik_type"]:checked + .calc_checkbox_input_txt').text();
        calcPufikMaterialPrice = parseFloat($('#form_pufik').find('input[name="calc_pufik_type"]:checked').val());
        calcPriceQuantity = $('#form_pufik').find('.calc_quantity_input').val();
        calcPufikResult = 0;
        calcPufikPrice = 0;
        calcPufikPrice = calcPufikMaterialPrice;
        calcPufikResult = calcPufikMaterialPrice * calcPriceQuantity;
        $('#form_pufik').find('.calc_price').html('Стоимость: <span>' + calcPufikResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_pufik').find('input[name="price"]').val(calcPufikPrice.toFixed(0));
        $('#form_pufik').find('input[name="total"]').val(calcPufikResult.toFixed(0));
        $('#form_pufik').find('input[name="quantity"]').val(calcPriceQuantity);
        $('#form_pufik .submit').attr('data-id', $('#form_pufik input[name="id"]').val());
        $('#form_pufik .submit').attr('data-title', $('#form_pufik input[name="title"]').val());
        $('#form_pufik .submit').attr('data-price', $('#form_pufik input[name="price"]').val());
        $('#form_pufik .submit').attr('data-total', $('#form_pufik input[name="total"]').val());
        $('#form_pufik .submit').attr('data-quantity', $('#form_pufik input[name="quantity"]').val());
        $('#form_pufik .submit').attr('data-type', $('#form_pufik input[name="type"]').val());
        $('#form_pufik .submit').attr('data-material', calcPufikMaterialTitle);
    });

}

/*-- CALCULATOR OFFICE --*/

const calcOffice = document.querySelector("#form_office");
if (calcOffice != null) {

    var calcOfficeSelectItemText;
    var calcOfficeSelectPriceTxt = parseFloat($('#form_office').find('select[name="office_select"] option:selected').attr('data-price-txt'));
    var calcOfficeSelectPriceSkin = parseFloat($('#form_office').find('select[name="office_select"] option:selected').attr('data-price-skin'));
    var calcOfficeMaterialTitle = $('#form_office').find('input[name="calc_office_type"]:checked + .calc_checkbox_input_txt').text();
    var calcOfficeSelectItemText = $('#form_office').find('select[name="office_select"] option:selected').text();
    var calcOfficeQuantity = $('#form_office').find('.calc_quantity_input').val();
    var calcOfficeResult = 0;
    var calcOfficePrice = 0;
    var calcOfficePriceStart = 0;
    if ($('#form_office .calc_checkbox:nth-child(1) input').prop('checked')) {
        calcOfficePriceStart = calcOfficeSelectPriceTxt;
    } else {
        calcOfficePriceStart = calcOfficeSelectPriceSkin;
    }
    calcOfficePrice = calcOfficePriceStart;
    calcOfficeResult = calcOfficePrice * calcOfficeQuantity;
    $('#form_office').find('.calc_price').html('Стоимость: <span>' + calcOfficeResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_office').find('input[name="price"]').val(calcOfficePrice.toFixed(0));
    $('#form_office').find('input[name="total"]').val(calcOfficeResult.toFixed(0));
    $('#form_office').find('input[name="quantity"]').val(calcOfficeQuantity);
    $('#form_office .submit').attr('data-id', $('#form_office input[name="id"]').val());
    $('#form_office .submit').attr('data-title', $('#form_office input[name="title"]').val());
    $('#form_office .submit').attr('data-price', $('#form_office input[name="price"]').val());
    $('#form_office .submit').attr('data-total', $('#form_office input[name="total"]').val());
    $('#form_office .submit').attr('data-quantity', $('#form_office input[name="quantity"]').val());
    $('#form_office .submit').attr('data-type', $('#form_office input[name="type"]').val());
    $('#form_office .submit').attr('data-selectedtext', calcOfficeSelectItemText);
    $('#form_office .submit').attr('data-material', calcOfficeMaterialTitle);

    /*-------- CHANGE --------*/

    $('#form_office select, #form_office input').on('change', function () {
        calcOfficeSelectItemText;
        calcOfficeSelectPriceTxt = parseFloat($('#form_office').find('select[name="office_select"] option:selected').attr('data-price-txt'));
        calcOfficeSelectPriceSkin = parseFloat($('#form_office').find('select[name="office_select"] option:selected').attr('data-price-skin'));
        calcOfficeMaterialTitle = $('#form_office').find('input[name="calc_office_type"]:checked + .calc_checkbox_input_txt').text();
        calcOfficeSelectItemText = $('#form_office').find('select[name="office_select"] option:selected').text();
        calcOfficeQuantity = $('#form_office').find('.calc_quantity_input').val();
        calcOfficeResult = 0;
        calcOfficePrice = 0;
        calcOfficePriceStart = 0;
        if ($('#form_office .calc_checkbox:nth-child(1) input').prop('checked')) {
            calcOfficePriceStart = calcOfficeSelectPriceTxt;
        } else {
            calcOfficePriceStart = calcOfficeSelectPriceSkin;
        }
        calcOfficePrice = calcOfficePriceStart;
        calcOfficeResult = calcOfficePrice * calcOfficeQuantity;
        $('#form_office').find('.calc_price').html('Стоимость: <span>' + calcOfficeResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_office').find('input[name="price"]').val(calcOfficePrice.toFixed(0));
        $('#form_office').find('input[name="total"]').val(calcOfficeResult.toFixed(0));
        $('#form_office').find('input[name="quantity"]').val(calcOfficeQuantity);
        $('#form_office .submit').attr('data-id', $('#form_office input[name="id"]').val());
        $('#form_office .submit').attr('data-title', $('#form_office input[name="title"]').val());
        $('#form_office .submit').attr('data-price', $('#form_office input[name="price"]').val());
        $('#form_office .submit').attr('data-total', $('#form_office input[name="total"]').val());
        $('#form_office .submit').attr('data-quantity', $('#form_office input[name="quantity"]').val());
        $('#form_office .submit').attr('data-type', $('#form_office input[name="type"]').val());
        $('#form_office .submit').attr('data-selectedtext', calcOfficeSelectItemText);
        $('#form_office .submit').attr('data-material', calcOfficeMaterialTitle);
    });

}

/*-- CALCULATOR MATRAS --*/

const calcMatras = document.querySelector("#form_matras");
if (calcMatras != null) {

    var calcMatrasCleanBoth;
    var calcMatrasCleanSmell;
    var calcMatrasCleanBothBool;
    var calcMatrasCleanSmellBool;
    var isTrueBoth = '';
    var isTrueSmell = '';
    var calcMatrasSizeTitle = $('#form_matras').find('input[name="calc_matras_size"]:checked + .calc_checkbox_input_txt').text();
    var calcMatrasSizePrice = parseFloat($('#form_matras').find('input[name="calc_matras_size"]:checked').val());
    var calcMatrasQuantity = $('#form_matras').find('.calc_quantity_input').val();
    var calcMatrasResult = 0;
    var calcMatrasPrice = 0;
    if ($('#form_matras').find('input[name="calc_matras_clean_both"]').prop('checked')) {
        calcMatrasCleanBoth = 2;
        calcMatrasCleanBothBool = true;
    } else {
        calcMatrasCleanBoth = 1;
        calcMatrasCleanBothBool = false;
    }
    if ($('#form_matras').find('input[name="calc_matras_clean_smell"]').prop('checked')) {
        calcMatrasCleanSmell = parseFloat($('#form_matras').find('input[name="calc_matras_clean_smell"]').val());
        calcMatrasCleanSmellBool = true;
    } else {
        calcMatrasCleanSmell = 0;
        calcMatrasCleanSmellBool = false;
    }
    if (calcMatrasCleanBothBool) {
        isTrueBoth = 'true';
    } else {
        isTrueBoth = 'false';
    }
    if (calcMatrasCleanSmellBool) {
        isTrueSmell = 'true';
    } else {
        isTrueSmell = 'false';
    }
    calcMatrasPrice = (calcMatrasSizePrice * calcMatrasCleanBoth) + calcMatrasCleanSmell;
    calcMatrasResult = ((calcMatrasSizePrice * calcMatrasCleanBoth) + calcMatrasCleanSmell) * calcMatrasQuantity;
    $('#form_matras').find('.calc_price').html('Стоимость: <span>' + calcMatrasResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_matras').find('input[name="price"]').val(calcMatrasPrice.toFixed(0));
    $('#form_matras').find('input[name="total"]').val(calcMatrasResult.toFixed(0));
    $('#form_matras').find('input[name="quantity"]').val(calcMatrasQuantity);
    $('#form_matras .submit').attr('data-id', $('#form_matras input[name="id"]').val());
    $('#form_matras .submit').attr('data-title', $('#form_matras input[name="title"]').val());
    $('#form_matras .submit').attr('data-price', $('#form_matras input[name="price"]').val());
    $('#form_matras .submit').attr('data-total', $('#form_matras input[name="total"]').val());
    $('#form_matras .submit').attr('data-quantity', $('#form_matras input[name="quantity"]').val());
    $('#form_matras .submit').attr('data-type', $('#form_matras input[name="type"]').val());
    $('#form_matras .submit').attr('data-material', calcMatrasSizeTitle);
    $('#form_matras .submit').attr('data-both', isTrueBoth);
    $('#form_matras .submit').attr('data-smell', isTrueSmell);

    /*-------- CHANGE --------*/

    $('#form_matras input').on('change', function () {
        calcMatrasCleanBoth;
        calcMatrasCleanSmell;
        calcMatrasCleanBothBool;
        calcMatrasCleanSmellBool;
        isTrueBoth = '';
        isTrueSmell = '';
        calcMatrasSizeTitle = $('#form_matras').find('input[name="calc_matras_size"]:checked + .calc_checkbox_input_txt').text();
        calcMatrasSizePrice = parseFloat($('#form_matras').find('input[name="calc_matras_size"]:checked').val());
        calcMatrasQuantity = $('#form_matras').find('.calc_quantity_input').val();
        calcMatrasResult = 0;
        calcMatrasPrice = 0;
        if ($('#form_matras').find('input[name="calc_matras_clean_both"]').prop('checked')) {
            calcMatrasCleanBoth = 2;
            calcMatrasCleanBothBool = true;
        } else {
            calcMatrasCleanBoth = 1;
            calcMatrasCleanBothBool = false;
        }
        if ($('#form_matras').find('input[name="calc_matras_clean_smell"]').prop('checked')) {
            calcMatrasCleanSmell = parseFloat($('#form_matras').find('input[name="calc_matras_clean_smell"]').val());
            calcMatrasCleanSmellBool = true;
        } else {
            calcMatrasCleanSmell = 0;
            calcMatrasCleanSmellBool = false;
        }
        if (calcMatrasCleanBothBool) {
            isTrueBoth = 'true';
        } else {
            isTrueBoth = 'false';
        }
        if (calcMatrasCleanSmellBool) {
            isTrueSmell = 'true';
        } else {
            isTrueSmell = 'false';
        }
        calcMatrasPrice = (calcMatrasSizePrice * calcMatrasCleanBoth) + calcMatrasCleanSmell;
        calcMatrasResult = ((calcMatrasSizePrice * calcMatrasCleanBoth) + calcMatrasCleanSmell) * calcMatrasQuantity;
        $('#form_matras').find('.calc_price').html('Стоимость: <span>' + calcMatrasResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_matras').find('input[name="price"]').val(calcMatrasPrice.toFixed(0));
        $('#form_matras').find('input[name="total"]').val(calcMatrasResult.toFixed(0));
        $('#form_matras').find('input[name="quantity"]').val(calcMatrasQuantity);
        $('#form_matras .submit').attr('data-id', $('#form_matras input[name="id"]').val());
        $('#form_matras .submit').attr('data-title', $('#form_matras input[name="title"]').val());
        $('#form_matras .submit').attr('data-price', $('#form_matras input[name="price"]').val());
        $('#form_matras .submit').attr('data-total', $('#form_matras input[name="total"]').val());
        $('#form_matras .submit').attr('data-quantity', $('#form_matras input[name="quantity"]').val());
        $('#form_matras .submit').attr('data-type', $('#form_matras input[name="type"]').val());
        $('#form_matras .submit').attr('data-material', calcMatrasSizeTitle);
        $('#form_matras .submit').attr('data-both', isTrueBoth);
        $('#form_matras .submit').attr('data-smell', isTrueSmell);
    });

}

/*-- CALCULATOR KOVRIK --*/

const calcKovrik = document.querySelector("#form_kovrik");
if (calcKovrik != null) {

    var calcKovrikDlina = 1;
    var calcKovrikShir = 1;
    var calcKovrikMaterialPrice = parseFloat($('#form_kovrik').find('input[name="calc_kover_type"]:checked').val());
    var calcKovrikMaterialText = $('#form_kovrik').find('input[name="calc_kover_type"]:checked + span').text();
    var calcKovrikQuantity = parseFloat($('#form_kovrik').find('.calc_quantity_input').val());
    var calcKovrikResult = 0;
    var calcKovrikPrice = 0;
    if ($('#form_kovrik').find('input[name="calc_kover_dlin"]').val() != '') {
        calcKovrikDlina = parseFloat($('#form_kovrik').find('input[name="calc_kover_dlin"]').val());
    }
    if ($('#form_kovrik').find('input[name="calc_kover_shir"]').val() != '') {
        calcKovrikShir = parseFloat($('#form_kovrik').find('input[name="calc_kover_shir"]').val());
    }
    calcKovrikPrice = ((calcKovrikDlina / 100) * (calcKovrikShir / 100)) * calcKovrikMaterialPrice;
    calcKovrikResult = (((calcKovrikDlina / 100) * (calcKovrikShir / 100)) * calcKovrikMaterialPrice) * calcKovrikQuantity;
    $('#form_kovrik').find('.calc_price').html('Стоимость: <span>' + calcKovrikResult.toFixed(2) + '</span> <em>₽</em>');
    $('#form_kovrik').find('input[name="price"]').val(calcKovrikPrice.toFixed(0));
    $('#form_kovrik').find('input[name="total"]').val(calcKovrikResult.toFixed(0));
    $('#form_kovrik').find('input[name="quantity"]').val(calcKovrikQuantity);
    $('#form_kovrik .submit').attr('data-id', $('#form_kovrik input[name="id"]').val());
    $('#form_kovrik .submit').attr('data-title', $('#form_kovrik input[name="title"]').val());
    $('#form_kovrik .submit').attr('data-price', $('#form_kovrik input[name="price"]').val());
    $('#form_kovrik .submit').attr('data-total', $('#form_kovrik input[name="total"]').val());
    $('#form_kovrik .submit').attr('data-quantity', $('#form_kovrik input[name="quantity"]').val());
    $('#form_kovrik .submit').attr('data-type', $('#form_kovrik input[name="type"]').val());
    $('#form_kovrik .submit').attr('data-dlina', calcKovrikDlina);
    $('#form_kovrik .submit').attr('data-shirina', calcKovrikShir);
    $('#form_kovrik .submit').attr('data-material', calcKovrikMaterialText);

    /*-------- CHANGE --------*/

    $('#form_kovrik input').on('change', function () {
        calcKovrikDlina = 1;
        calcKovrikShir = 1;
        calcKovrikMaterialPrice = parseFloat($('#form_kovrik').find('input[name="calc_kover_type"]:checked').val());
        calcKovrikMaterialText = $('#form_kovrik').find('input[name="calc_kover_type"]:checked + span').text();
        calcKovrikQuantity = parseFloat($('#form_kovrik').find('.calc_quantity_input').val());
        calcKovrikResult = 0;
        calcKovrikPrice = 0;
        if ($('#form_kovrik').find('input[name="calc_kover_dlin"]').val() != '') {
            calcKovrikDlina = parseFloat($('#form_kovrik').find('input[name="calc_kover_dlin"]').val());
        }
        if ($('#form_kovrik').find('input[name="calc_kover_shir"]').val() != '') {
            calcKovrikShir = parseFloat($('#form_kovrik').find('input[name="calc_kover_shir"]').val());
        }
        calcKovrikPrice = ((calcKovrikDlina / 100) * (calcKovrikShir / 100)) * calcKovrikMaterialPrice;
        calcKovrikResult = (((calcKovrikDlina / 100) * (calcKovrikShir / 100)) * calcKovrikMaterialPrice) * calcKovrikQuantity;
        $('#form_kovrik').find('.calc_price').html('Стоимость: <span>' + calcKovrikResult.toFixed(2) + '</span> <em>₽</em>');
        $('#form_kovrik').find('input[name="price"]').val(calcKovrikPrice.toFixed(0));
        $('#form_kovrik').find('input[name="total"]').val(calcKovrikResult.toFixed(0));
        $('#form_kovrik').find('input[name="quantity"]').val(calcKovrikQuantity);
        $('#form_kovrik .submit').attr('data-id', $('#form_kovrik input[name="id"]').val());
        $('#form_kovrik .submit').attr('data-title', $('#form_kovrik input[name="title"]').val());
        $('#form_kovrik .submit').attr('data-price', $('#form_kovrik input[name="price"]').val());
        $('#form_kovrik .submit').attr('data-total', $('#form_kovrik input[name="total"]').val());
        $('#form_kovrik .submit').attr('data-quantity', $('#form_kovrik input[name="quantity"]').val());
        $('#form_kovrik .submit').attr('data-type', $('#form_kovrik input[name="type"]').val());
        $('#form_kovrik .submit').attr('data-dlina', calcKovrikDlina);
        $('#form_kovrik .submit').attr('data-shirina', calcKovrikShir);
        $('#form_kovrik .submit').attr('data-material', calcKovrikMaterialText);
    });
}

/*-- CALCULATOR OTHER --*/

const calcOther = document.querySelector("#form_other");
if (calcOther != null) {

    var calcOtherSelectItemText;
    var calcOtherSelect = $('#form_other').find('select[name="other_elements_select"]').val();
    var calcOtherSelectText = $('#form_other').find('select[name="other_elements_select"] option:selected').text();
    var calcOtherItemChecked;
    var calcOtherQuantity = $('#form_other').find('.calc_quantity_input').val();
    var calcOtherResult = 0;
    var calcOtherPrice = 0;
    $('#form_other .calc_checkboxes_other').each(function () {
        $(this).hide();
        if ($(this).attr('data-item') == calcOtherSelect) {
            $(this).show();
            calcOtherItemChecked = parseFloat($(this).find('input:checked').val());
            calcOtherSelectItemText = $(this).find('input:checked + span').text();
        }
    });

    calcOtherPrice = calcOtherItemChecked;
    calcOtherResult = calcOtherItemChecked * calcOtherQuantity;
    $('#form_other').find('.calc_price').html('Стоимость: <span>' + calcOtherResult.toFixed(0) + '</span> <em>₽</em>');
    $('#form_other').find('input[name="price"]').val(calcOtherPrice.toFixed(0));
    $('#form_other').find('input[name="total"]').val(calcOtherResult.toFixed(0));
    $('#form_other').find('input[name="quantity"]').val(calcOtherQuantity);
    $('#form_other .submit').attr('data-id', $('#form_other input[name="id"]').val());
    $('#form_other .submit').attr('data-title', $('#form_other input[name="title"]').val());
    $('#form_other .submit').attr('data-price', $('#form_other input[name="price"]').val());
    $('#form_other .submit').attr('data-total', $('#form_other input[name="total"]').val());
    $('#form_other .submit').attr('data-quantity', $('#form_other input[name="quantity"]').val());
    $('#form_other .submit').attr('data-type', $('#form_other input[name="type"]').val());
    $('#form_other .submit').attr('data-selectedtext', calcOtherSelectText);
    $('#form_other .submit').attr('data-selecteditem', calcOtherSelectItemText);

    /*-------- CHANGE --------*/

    $('#form_other select, #form_other input').on('change', function () {
        calcOtherSelectItemText;
        calcOtherSelect = $('#form_other').find('select[name="other_elements_select"]').val();
        calcOtherSelectText = $('#form_other').find('select[name="other_elements_select"] option:selected').text();
        calcOtherQuantity = $('#form_other').find('.calc_quantity_input').val();
        calcOtherResult = 0;
        calcOtherPrice = 0;
        $('#form_other .calc_checkboxes_other').each(function () {
            $(this).hide();
            if ($(this).attr('data-item') == calcOtherSelect) {
                $(this).show();
                calcOtherItemChecked = parseFloat($(this).find('input:checked').val());
                calcOtherSelectItemText = $(this).find('input:checked + span').text();
            }
        });

        calcOtherPrice = calcOtherItemChecked;
        calcOtherResult = calcOtherItemChecked * calcOtherQuantity;
        $('#form_other').find('.calc_price').html('Стоимость: <span>' + calcOtherResult.toFixed(0) + '</span> <em>₽</em>');
        $('#form_other').find('input[name="price"]').val(calcOtherPrice.toFixed(0));
        $('#form_other').find('input[name="total"]').val(calcOtherResult.toFixed(0));
        $('#form_other').find('input[name="quantity"]').val(calcOtherQuantity);
        $('#form_other .submit').attr('data-id', $('#form_other input[name="id"]').val());
        $('#form_other .submit').attr('data-title', $('#form_other input[name="title"]').val());
        $('#form_other .submit').attr('data-price', $('#form_other input[name="price"]').val());
        $('#form_other .submit').attr('data-total', $('#form_other input[name="total"]').val());
        $('#form_other .submit').attr('data-quantity', $('#form_other input[name="quantity"]').val());
        $('#form_other .submit').attr('data-type', $('#form_other input[name="type"]').val());
        $('#form_other .submit').attr('data-selectedtext', calcOtherSelectText);
        $('#form_other .submit').attr('data-selecteditem', calcOtherSelectItemText);
    });

}

jQuery.extend(jQuery.fn, {
    checka: function () {
        if (jQuery(this).val().length < 3) {
            jQuery(this).addClass('error');
            return false
        } else {
            jQuery(this).removeClass('error');
            return true
        }
    },
    checke: function () {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var emailaddressVal = jQuery(this).val();
        if (!emailReg.test(emailaddressVal) || emailaddressVal == "") {
            jQuery(this).addClass('error');
            return false
        } else {
            jQuery(this).removeClass('error');
            return true
        }
    },
});

jQuery(function ($) {
    $('#commentform').submit(function (e) {
        e.preventDefault();
        if ($("#author").length) var author = $("#author").checka();
        if ($("#email").length) var email = $("#email").checke();
        var comment = $("#comment").checka();
        if (!$('#submit').hasClass('loadingform') && !$("#author").hasClass('error') && !$("#email").hasClass('error') && !$("#comment").hasClass('error')) {
            $.ajax({
                type: 'POST',
                url: 'http://' + location.host + '/wp-admin/admin-ajax.php',
                data: $(this).serialize() + '&action=ajaxcomments',
                beforeSend: function (xhr) {
                    $('#submit').addClass('loadingform').val('Загрузка');
                },
                error: function (request, status, error) {
                    if (status == 500) {
                        alert('Ошибка при добавлении комментария');
                    } else if (status == 'timeout') {
                        alert('Ошибка: Сервер не отвечает, попробуй ещё.');
                    } else {
                        var errormsg = request.responseText;
                        var string1 = errormsg.split("<p>");
                        var string2 = string1[1].split("</p>");
                        alert(string2[0]);
                    }
                },
                success: function (newComment) {
                    if ($('.commentlist').length > 0) {
                        if ($('#respond').parent().hasClass('comment')) {
                            if ($('#respond').parent().children('.children').length) {
                                $('#respond').parent().children('.children').append(newComment);
                            } else {
                                newComment = '<ul class="children">' + newComment + '</ul>';
                                $('#respond').parent().append(newComment);
                            }
                            $("#cancel-comment-reply-link").trigger("click");
                        } else {
                            $('.commentlist').append(newComment);
                        }
                    } else {
                        newComment = '<ul class="commentlist">' + newComment + '</ol>';
                        $('#respond').before($(newComment));
                    }
                    $('#comment').val('');
                },
                complete: function () {
                    $('div#respond').text('Ваш комментарий отправлен на модерацию');
                }
            });
        }
        return false;
    });
    if ($('span.jqcart-total-cnt').text() == 0) {
        $('.open_cart').css('display', 'none');
    }
    $('.calc_submit').click(function () {
        $('.open_cart').css('display', 'block');
    });
});

jQuery(document).ready(function ($) {

    /*Tabs on reviews page*/
    $('ul.tabs li').click(function(){
        console.log('fff');
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    })

    var this_town;

    function detectTown() {
        let my = YMaps.location.city;
        this_town = $(".this-town").text();

        if (my == this_town) {
        } else {
            if (!sessionStorage.getItem("town-sam")) {
                if (sessionStorage.getItem("town") != this_town) {
                    $("#detect-town").slideDown();
                }
            }
        }
    }

    $(".btn-town-yes").click(function () {
        sessionStorage.setItem("town", this_town);
        $("#detect-town").slideUp();
    })

    $(".btn-town-no").click(function () {
        $("#detect-town").slideUp();
    })

    /*$(".modal_cities a").click(function(){
        sessionStorage.setItem("town-sam","yes");
    })*/

    $('.modal_cities a').click(function (e) {
        e.preventDefault();
        sessionStorage.setItem("town-sam","yes");
        let urlSityAjax = location.protocol + '//' + location.hostname + '/wp-content/themes/him/ajax/myajax.php';
        let urlSityAjaxBase = location.protocol + '//' + location.hostname + '/wp-admin/admin-ajax.php';
        let currentActiveSity = $(this).text();
        let urlCurrentSite = new URL($(this).prop("href"));
        urlCurrentSite = urlCurrentSite.pathname;
        let idSite = $(this).data('site');
        /*sessionStorage.setItem("currentActiveTown", currentActiveSity);
        console.log(idSite);*/
        let data = {
            action: 'my_actions',
            currentActiveSity: currentActiveSity,
            urlCurrentSite: urlCurrentSite,
            idSite: idSite
        }

        $.ajax({
            url: urlSityAjaxBase,
            type: 'POST',
            data: data,
            success: function (data) {
                document.location.href = "https://"+document.domain+data;
            }
        });
    });

    $('.imports_submit').click(function (e) {
        e.preventDefault();
        let urlSityAjax = location.protocol + '//' + location.hostname + '/wp-admin/admin-ajax.php';
        let nameImports = $(".file_name").val();
        var file_data =  $(".userfile")[0].files[0];
        var form_data = new FormData();
        form_data.append("action", 'imports');
        form_data.append("file", file_data);
        form_data.append("nameImports", nameImports);
        $.ajax({
            url: urlSityAjax,
            processData: false,
            contentType: false,
            data: form_data,
            type: 'POST',
            success: function (response) {
                $('#import_titles_response').text('Файл загружен/обновлен!');
            }
        });
    });

    detectTown();

})