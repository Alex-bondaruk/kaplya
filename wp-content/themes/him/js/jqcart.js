/*!
 * jQuery jqCart Plugin v1.1.2
 * requires jQuery v1.9 or later
 *
 * http://incode.pro/
 *
 * Date: Date: 2016-05-18 19:15
 */
;(function($) {
	
  'use strict';
  
	function numberFormat(n) {
		n += "";
		n = new Array(4 - n.length % 3).join("U") + n;
		return n.replace(/([0-9U]{3})/g, "$1 ").replace(/U/g, "");
	}

	function declOfNum(n, text_forms) {  
	    n = Math.abs(n) % 100; var n1 = n % 10;
	    if (n > 10 && n < 20) { return text_forms[2]; }
	    if (n1 > 1 && n1 < 5) { return text_forms[1]; }
	    if (n1 == 1) { return text_forms[0]; }
	    return text_forms[2];
	}

	function getAttributes(node) {
	    var d = {}, 
	        re_dataAttr = /^data\-(.+)$/;

	    $.each(node.get(0).attributes, function(index, attr) {
	        if (re_dataAttr.test(attr.nodeName)) {
	            var key = attr.nodeName.match(re_dataAttr)[1];
	            d[key] = attr.nodeValue;
	        }
	    });

	    return d;
	}

  const modalCalcs = document.querySelector('.modal_calc');
  var cartData,
    itemData,
    orderPreviewOld = '',
    orderPreview = '',
    totalCnt = 0,
    visibleLabel = false,
	discount = (100 - parseFloat($('.jqcart-orderform-custom input[name="discount"]').val())) / 100,
	priceDis = 0,
    labelOld = $('<div class="jqcart-cart-label"><span class="jqcart-title">Оформить заказ</span><span class="jqcart-total-cnt">0</span></div>'),
    label = $('<div class="cart_open_wrapper"><div class="cart_open_inside"><div class="cart_open_icon"><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.66536 0C7.48803 0 7.31868 0.0699791 7.19401 0.195312L6.72266 0.666667H4.15495C3.16628 0.666667 2.31448 1.40478 2.17448 2.38411L1.94401 4H3.29167L3.49479 2.57161C3.54079 2.24561 3.82561 2 4.15495 2H6.9987C7.17603 2 7.34539 1.93002 7.47005 1.80469L7.94141 1.33333H10.056L10.5273 1.80469C10.652 1.93002 10.8214 2 10.9987 2H13.8424C14.1718 2 14.4566 2.24625 14.5026 2.57292L14.7057 4H16.0534L15.8229 2.38411C15.6823 1.40478 14.8311 0.666667 13.8424 0.666667H11.2747L10.8034 0.195312C10.6787 0.0699791 10.5094 0 10.332 0H7.66536ZM0.998698 5.33333C0.630698 5.33333 0.332031 5.632 0.332031 6V7.33333C0.332031 7.70133 0.630698 8 0.998698 8H1.10938L2.14583 14.2187C2.25317 14.8614 2.8096 15.3333 3.46094 15.3333H14.5352C15.1872 15.3333 15.7429 14.8614 15.8503 14.2187L16.888 8H16.9987C17.3667 8 17.6654 7.70133 17.6654 7.33333V6C17.6654 5.632 17.3667 5.33333 16.9987 5.33333H0.998698ZM5.66536 8.66667C6.03336 8.66667 6.33203 8.96533 6.33203 9.33333V12.6667C6.33203 13.0347 6.03336 13.3333 5.66536 13.3333C5.29736 13.3333 4.9987 13.0347 4.9987 12.6667V9.33333C4.9987 8.96533 5.29736 8.66667 5.66536 8.66667ZM8.9987 8.66667C9.3667 8.66667 9.66537 8.96533 9.66537 9.33333V12.6667C9.66537 13.0347 9.3667 13.3333 8.9987 13.3333C8.6307 13.3333 8.33203 13.0347 8.33203 12.6667V9.33333C8.33203 8.96533 8.6307 8.66667 8.9987 8.66667ZM12.332 8.66667C12.7 8.66667 12.9987 8.96533 12.9987 9.33333V12.6667C12.9987 13.0347 12.7 13.3333 12.332 13.3333C11.964 13.3333 11.6654 13.0347 11.6654 12.6667V9.33333C11.6654 8.96533 11.964 8.66667 12.332 8.66667Z" fill="white"/></svg></div><div class="cart_open_count"><span class="jqcart-total-cnt">0</span></div></div><div class="cart_open_price"></div></div>'),
	modalOld = '<div class="jqcart-layout1"><div class="jqcart-checkout">123</div></div>',
	modal = '<div class="modal_cart"><div class="jqcart-layout"><div class="jqcart-checkout">123</div></div>',
    orderformOld = '<p class="jqcart-cart-title">Контактная информация:</p><form class="jqcart-orderform-custom"><p><label>ФИО:</label><input type="text" name="user_name"></p><p><label>Телефон:</label><input type="text" name="user_phone"></p><p><label>Email:</label><input type="text" name="user_mail"></p><p><label>Адрес:</label><input type="text" name="user_address"></p><p><label>Коментарий:</label><textarea name="user_comment"></textarea></p><p><input type="submit" value="Отправить заказ"><input type="reset" value="Вернуться к покупкам"></p></form>',
	orderform = '<div class="modal_calc_form disable"><div class="modal_title">Оформление заказа</div><div class="modal_desc">Заполните форму и мы свяжемся с вами!</div><div class="modal_form"><form class="jqcart-orderform-custom"><input type="hidden" name="discount" value="0"/><input type="hidden" name="coupon" value="0"/><div class="modal_form_fields"><div class="modal_form_field"><input type="text" name="user_name" placeholder="Ваше имя:"/></div><div class="modal_form_field"><input type="text" class="phone_input" name="user_phone" placeholder="Телефон:"/></div><div class="modal_form_field" style="display:none"><input type="text" name="user_address" placeholder="Адрес:"/></div><div class="modal_form_field modal_form_field--select_time" style="display:none"><label class="modal_select_time"><div class="modal_select_time--txt">Желаемое время:</div><div class="modal_select_time--select"><select name="time_clean"><option value="morning">Утром</option><option value="day">Днём</option><option value="evening">Вечером</option></select></div></label></div><div class="modal_form_field modal_form_field--checkbox modal_form_field--agree"><label class="modal_agree"><input type="checkbox" checked name="privacy"/><span class="modal_agree_txt">Даю согласие на обработку <a href="/privacy-policy/">персональных данных</a></span></label></div></div><div class="modal_form_submit"><button type="submit" class="submit btn_click_custom"><span>Вызвать мастера</span><input type="submit" class="submit" value="Вызвать мастера"/></button></div></form><div class="back_to_cart">Вернуться в корзину</div></div></div>';
  var opts = {
		buttons: '.add_item',
		cartLabel: 'body',
		visibleLabel: false,
		openByAdding: false,
		handler: '/',
		currency: '$'
  };
  var actions = {
    init: function(o) {
      opts = $.extend(opts, o);
      cartData = actions.getStorage();
	  if(modalCalcs != null) {
		  $('.modal_calc').each(function() {
				var curId = $(this).find('input[name="id"]').val();
				for (var key in cartData) {
					if (cartData[key].id == curId) {
						$(this).find('.submit').attr('disabled', true).addClass('disable').val('Товар в корзине');
						return;
					} else {
						$(this).find('.submit').attr('disabled', false).removeClass('disable').val('Добавить в корзину');
					}
				}
		  });
	  }
      if (cartData !== null && Object.keys(cartData).length) {
        for (var key in cartData) {
          if (cartData.hasOwnProperty(key)) {
            totalCnt += cartData[key].quantity;
          }
        }
        visibleLabel = true;
      }
	  var subtotal = 0,
		discount = (100 - parseFloat($('.jqcart-orderform-custom input[name="discount"]').val())) / 100,
		priceDis = 0,
	  cartData = actions.getStorage();
	  var key, sum = 0;
	  for (key in cartData) {
		if (cartData.hasOwnProperty(key)) {
					sum = Math.ceil((cartData[key].quantity * cartData[key].price) * 100) / 100;
					subtotal = Math.ceil((subtotal + sum) * 100) / 100;
					if(discount != 1) {
						priceDis = subtotal * discount;
       					$('.jqcart_orders_coupon input').removeClass('invalid').addClass('valid');
						$('.jqcart_orders_result .total_price').addClass('dis');
						$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').show(); 
					} else {
        				$('.jqcart_orders_coupon input').removeClass('valid').addClass('invalid');
						$('.jqcart_orders_result .total_price').removeClass('dis');
						$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').hide();
					}
		}
	  }
      label.prependTo(opts.cartLabel)[visibleLabel || opts.visibleLabel ? 'show' : 'hide']()
        .on('click', actions.openCart)
        .find('.jqcart-total-cnt').text(totalCnt);
		if(subtotal > 0) {
			$('.cart_open_price').html(numberFormat(subtotal.toFixed(0)) + ' <em>' + opts.currency + '</em>');
		} else {
			$('.cart_open_price').html(' ');  
		}
      $(document)
        .on('click', opts.buttons, actions.addToCart)
        .on('click', '.jqcart-layout', function(e) {
          if (e.target === this) {
            actions.hideCart();
          }
        })
        .on('click', '.jqcart-incr', actions.changeAmount)
				.on('input keyup', '.jqcart-amount', actions.changeAmount)
        .on('click', '.jqcart-del-item', actions.delFromCart)
        .on('submit', '.jqcart-orderform-custom', actions.sendOrder)
        .on('reset', '.jqcart-orderform-custom', actions.hideCart)
				.on('click', '.jqcart-print-order', actions.printOrder);
      return false;
    },
    addToCart: function(e) {
      e.preventDefault();
      itemData = getAttributes($(this));
			if(typeof parseInt(itemData.id) === 'undefined') {
				console.log('Отсутствует ID товара');
				return false;
			}
      cartData = actions.getStorage() || {};
      //itemData.quantity = parseInt($(this).parents('form').find('input[name="quantity"]').val());
      itemData.id = parseInt(itemData.id);
      itemData.quantity = parseInt(itemData.quantity);
      itemData.price = parseInt(itemData.price);
      itemData.total = parseInt(itemData.total);
	  if(modalCalcs != null) {
		  $('.modal_calc').each(function() {
				var curId = $(this).find('input[name="id"]').val();
				if (parseInt(itemData.id) == curId) {
					//$(this).find('.submit').attr('disabled', true).addClass('disable').val('Товар в корзине');
					$(this).find('input[name="id"]').val(itemData.id + itemData.id);
					$(this).find('.submit').attr('data-id', itemData.id + itemData.id);
					return;
				}
		  });
	  }
   	  cartData[itemData.id] = itemData;
      itemData.id += itemData.id;
      actions.setStorage(cartData);
      actions.changeTotalCnt(itemData.quantity);
      label.show();
			if(opts.openByAdding) {
				actions.openCart();
			}
		setTimeout(function(){
			$('.modal_calc').animate(
				{opacity: 0, top: 45+"%"}, 200,
				function() {
					$('.modal_calc').css('display', 'none');
					$('#overlay').fadeOut(400);
					$('html').removeClass('overflow-hidden');
				}
			);
			$('.modal_calc').removeClass('active');
		}, 500);
      return false;
    },
    delFromCart: function() {
      var $that = $(this),
        line = $that.closest('.jqcart-tr'),
        itemId = line.data('id');
      cartData = actions.getStorage();
	  if(modalCalcs != null) {
		  if (cartData !== null && Object.keys(cartData).length) {
			  $('.modal_calc').each(function() {
					var curId = $(this).find('input[name="id"]').val();
					if (itemId == curId) {
						$(this).find('.submit').attr('disabled', false).removeClass('disable').val('Добавить в корзину');
						return;
					}
			  });
		  }
	  }
      actions.changeTotalCnt(-cartData[itemId].quantity);
      delete cartData[itemId];
      actions.setStorage(cartData);
      line.remove();
      actions.recalcSum();
      if(cartData != null) {
		  if(Object.keys(cartData).length) {
			$('.cart_orders .modal_title').text('В вашей корзине ' + Object.keys(cartData).length + ' ' + declOfNum(Object.keys(cartData).length, ['товар', 'товара', 'товаров']));
		  }
	  }
      return false;
    },
    changeAmount: function() {
      var $that = $(this),
				manually = $that.hasClass('jqcart-amount'),
        amount = +(manually ? $that.val() : $that.attr('data-incr')),
        itemId = $that.closest('.jqcart-tr').attr('data-id');
      cartData = actions.getStorage();
			if(manually) {
      	cartData[itemId].quantity = isNaN(amount) || amount < 1 ? 1 : amount;
			} else {
				cartData[itemId].quantity += amount;
			}
      if (cartData[itemId].quantity < 1) {
        cartData[itemId].quantity = 1;
      }
			if(manually) {
				$that.val(cartData[itemId].quantity);
			} else {
      	$that.siblings('input').val(cartData[itemId].quantity);
			}
      actions.setStorage(cartData);
      actions.recalcSum();
      return false;
    },
    recalcSum: function() {
      var subtotal = 0,
        amount,
		discount = (100 - parseFloat($('.jqcart-orderform-custom input[name="discount"]').val())) / 100,
		priceDis = 0,
        sum = 0,
        totalCnt = 0;
      $('.jqcart-tr').each(function() {
        amount = +$('.jqcart-amount', this).val();
        sum = Math.ceil((amount * $('.jqcart-price', this).text()) * 100) / 100;
        $('.jqcart-sum', this).html(sum + ' ' + opts.currency);
				subtotal = Math.ceil((subtotal + sum) * 100) / 100;
				if(discount != 1) {
					priceDis = subtotal * discount;
   					$('.jqcart_orders_coupon input').removeClass('invalid').addClass('valid');
					$('.jqcart_orders_result .total_price').addClass('dis');
					$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').show(); 
				} else {
    				$('.jqcart_orders_coupon input').removeClass('valid').addClass('invalid');
					$('.jqcart_orders_result .total_price').removeClass('dis');
					$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').hide();
				}
        totalCnt += amount;
      });
      $('.jqcart-subtotal strong.total_price').html(subtotal + ' <em>' + opts.currency + '</em>');
      $('.jqcart-total-cnt').text(totalCnt);
	  if(subtotal > 0) {
		$('.cart_open_price').html(numberFormat(subtotal.toFixed(0)) + ' <em>' + opts.currency + '</em>');
	  } else {
		$('.cart_open_price').html(' ');  
	  }
      if (totalCnt <= 0) {
				actions.hideCart();
				if(!opts.visibleLabel) {
        	label.hide();
				}
      }
      return false;
    },
    changeTotalCnt: function(n) {
		var subtotal = 0,
		  discount = (100 - parseFloat($('.jqcart-orderform-custom input[name="discount"]').val())) / 100,
		  priceDis = 0,
		  cartData = actions.getStorage();
		  var key, sum = 0;
		  for (key in cartData) {
			if (cartData.hasOwnProperty(key)) {
						sum = Math.ceil((cartData[key].quantity * cartData[key].price) * 100) / 100;
						subtotal = Math.ceil((subtotal + sum) * 100) / 100;
					if(discount != 1) {
						priceDis = subtotal * discount;
       					$('.jqcart_orders_coupon input').removeClass('invalid').addClass('valid');
						$('.jqcart_orders_result .total_price').addClass('dis');
						$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').show(); 
					} else {
        				$('.jqcart_orders_coupon input').removeClass('valid').addClass('invalid');
						$('.jqcart_orders_result .total_price').removeClass('dis');
						$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').hide();
					}
			}
		  }
	  if(subtotal > 0) {
		$('.cart_open_price').html(numberFormat(subtotal.toFixed(0)) + ' <em>' + opts.currency + '</em>');
	  } else {
		$('.cart_open_price').html(' ');  
	  }
      var cntOutput = $('.jqcart-total-cnt');
      cntOutput.text((+parseInt(cntOutput.text()) + n));
      return false;
    },
    openCart: function() {
      var subtotal = 0,
			cartHtml = '';
		$('html').addClass('overflow-hidden');
      cartData = actions.getStorage();
      orderPreviewOld = '<p class="jqcart-cart-title">Корзина <span class="jqcart-print-order"></span></p><div class="jqcart-table-wrapper"><div class="jqcart-manage-order"><div class="jqcart-thead"><div>ID</div><div></div><div>Наименование</div><div>Цена</div><div>Кол-во</div><div>Сумма</div><div></div></div>';
      if(cartData != null) {
		  if(Object.keys(cartData).length) {
			orderPreview = '<div class="cart_orders_wrapper"><div class="cart_orders"><div class="modal_title">В вашей корзине ' + Object.keys(cartData).length + ' ' + declOfNum(Object.keys(cartData).length, ['товар', 'товара', 'товаров']) + '</div><div class="jqcart-table-wrapper"><div class="jqcart-manage-order"><div class="jqcart_orders_inside" data-simplebar><div class="jqcart_orders_list">';
		  }
	  } else {
		orderPreview = '<div class="cart_orders_wrapper"><div class="cart_orders"><div class="modal_title">Ваша корзина пуста</div><div class="jqcart-table-wrapper"><div class="jqcart-manage-order"><div class="jqcart_orders_inside" data-simplebar><div class="jqcart_orders_list">';
	  }
      var key, sum = 0;
      for (key in cartData) {
        if (cartData.hasOwnProperty(key)) {
					sum = Math.ceil((cartData[key].quantity * cartData[key].price) * 100) / 100;
					subtotal = Math.ceil((subtotal + sum) * 100) / 100;
					
					if(discount != 1) {
						priceDis = subtotal * discount;
       					$('.jqcart_orders_coupon input').removeClass('invalid').addClass('valid');
						$('.jqcart_orders_result .total_price').addClass('dis');
						$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').show(); 
					} else {
        				$('.jqcart_orders_coupon input').removeClass('valid').addClass('invalid');
						$('.jqcart_orders_result .total_price').removeClass('dis');
						$('.jqcart_orders_result .price_dis').html(numberFormat(priceDis.toFixed(0)) + ' <em>' + opts.currency + '</em>').hide();
					}
          orderPreview += '<div class="jqcart_order_product jqcart-tr" data-id="' + cartData[key].id + '">';
					orderPreview += '<div class="jqcart-small-td" style="display: none !important;">' + cartData[key].id + '</div>';
					//orderPreview += '<div class="jqcart-small-td jqcart-item-img"><img src="' + cartData[key].img + '" alt=""></div>';
          orderPreview += '<div class="jqcart_op_title">';
		  orderPreview += cartData[key].title;
		  if(cartData[key].back == 'true') {
			orderPreview += '<span>';
			  orderPreview += 'Со спинкой';
			orderPreview += '</span>';
		  }
		  if(cartData[key].title == 'Диван') {
			orderPreview += '<span>';
			  orderPreview += cartData[key].selectedtext;
			orderPreview += '</span>';
		  }
		  if(cartData[key].slide == 'true') {
			orderPreview += '<span>';
			  orderPreview += 'С выдвижной частью';
			orderPreview += '</span>';
		  }
		  if(cartData[key].title == 'Пуфик') {
			orderPreview += '<span>';
			  orderPreview += cartData[key].material;
			orderPreview += '</span>';
		  }
		  if(cartData[key].title == 'Офисная мебель') {
			orderPreview += '<span>';
			  orderPreview += cartData[key].selectedtext;
			orderPreview += '</span>';
		  }
		  if(cartData[key].title == 'Матрас') {
			orderPreview += '<span>';
			  orderPreview += cartData[key].material;
			orderPreview += '</span>';
		  }
		  if(cartData[key].title == 'Ковры') {
			orderPreview += '<span>';
			  orderPreview += cartData[key].dlina + 'x' + cartData[key].shirina + 'см';
			orderPreview += '</span>';
		  }
		  if(cartData[key].title == 'Остальное') {
			orderPreview += '<span>';
			  orderPreview += cartData[key].selectedtext;
			orderPreview += '</span>';
		  }
		  orderPreview += '</div>';
          orderPreview += '<div class="jqcart_op_price jqcart-price" style="display: none !important;">' + cartData[key].price + '</div>';
          orderPreview += '<div class="jqcart_op_quantity"><div class="jqcart_op_quantity--inside"><span class="jqcart-incr" data-incr="-1">-</span><input type="text" class="jqcart-amount" value="' + cartData[key].quantity + '"><span class="jqcart-incr" data-incr="1">+</span></div><div class="jqcart_op_quantity--txt">шт.</div></div>';
          orderPreview += '<div class="jqcart_op_total jqcart-sum">' + sum + ' ' + opts.currency + '</div>';
					orderPreview += '<div class="jqcart_op_remove jqcart-small-td"><span class="jqcart-del-item"><svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.92828 0.0195312L1.01828 0.929531L6.08828 5.99953L0.988281 11.1095L1.88828 12.0095L6.99828 6.90953L12.0983 12.0095L13.0083 11.0995L7.90828 5.99953L12.9783 0.929531L12.0683 0.0195312L6.99828 5.08953L1.92828 0.0195312Z" fill="#91A5BE"/></svg></span></div>';
          orderPreview += '</div>';
        }
      }
      orderPreview += '</div></div></div></div></div>';
      orderPreview += '<div class="jqcart_orders_result"><div class="jqcart-subtotal">Итого: <strong class="total_price">' + subtotal + ' <em>' + opts.currency + '</em></strong> <strong class="price_dis"> <em>' + opts.currency + '</em></strong></div><div class="jqcart_orders_coupon"><input type="text" name="cart_coupon" class="cart_coupon" placeholder="Ввести промокод"/></div></div>';
	  orderPreview += '<div class="jqcart_open_order"><a href="#modal_order" id="jqcart-submit" class="open_modal submit btn_click_custom"><span>Оформить заказ</span></a></div></div>';	
			if(window.location.pathname != '/calculator/') {
				//cartHtml = subtotal ? (orderPreview + orderform) : '<div class="cart_orders_wrapper cart_orders_wrapper_empty"><div class="modal_title">Корзина пуста</div><div class="modal_cart_empty_btn"><a href="/calculator" class="submit btn_click_button"><span>Перейти на страницу калькулятора</span></a></div></div>';
				cartHtml = subtotal ? (orderPreview + orderform) : '<div class="cart_orders_wrapper cart_orders_wrapper_empty cart_orders_wrapper_empty_without_btn"><div class="modal_title">Корзина пуста</div></div>';
			} else {
				cartHtml = subtotal ? (orderPreview + orderform) : '<div class="cart_orders_wrapper cart_orders_wrapper_empty cart_orders_wrapper_empty_without_btn"><div class="modal_title">Корзина пуста</div></div>';
			}
      $(modal).appendTo('body').find('.jqcart-checkout').html(cartHtml);
		$(".modal_select_time--select select").select2({
			minimumResultsForSearch: -1,
			dropdownCssClass: "dropdown_time_select"
		});
    },
    hideCart: function() {
    	$('html').removeClass('overflow-hidden');
      $('.jqcart-layout').fadeOut('fast', function() {
        $(this).remove();
      });
      return false;
    },
    sendOrder: function(e) {
      e.preventDefault();
      var $that = $(this);
      if (($.trim($('[name=user_name]', $that).val()) === '' || $.trim($('[name=user_phone]', $that).val()) === '') && !$('.jqcart-orderform-custom [name="privacy"').prop('checked')) {
        $('<p class="jqcart-error">Пожалуйста, укажите свое имя, контактный телефон и подтвердите согласие на обработку контактных данных</p>').insertBefore($that).delay(3000).fadeOut();
        return false;
      }
      if ($.trim($('[name=user_name]', $that).val()) === '' || $.trim($('[name=user_phone]', $that).val()) === '') {
        $('<p class="jqcart-error">Пожалуйста, укажите свое имя и контактный телефон!</p>').insertBefore($that).delay(3000).fadeOut();
        return false;
      }
	  if(!$('.jqcart-orderform-custom [name="privacy"').prop('checked')) {
        $('<p class="jqcart-error">Вы не дали согласие на обработку персональных данных</p>').insertBefore($that).delay(3000).fadeOut();
        return false;
	  }
	  
      $.ajax({
        url: opts.handler,
		type: 'POST',
				dataType: 'json',
        data: {
		  action: 'post_ajax_add',
          orderlist: $.param(actions.getStorage()),
          userdata: $that.serialize(),
		  discount: $('.jqcart-orderform-custom input[name="discount"]').val(),
		  coupon: $('.jqcart-orderform-custom input[name="coupon"]').val()
        },
        error: function() {},
        success: function(resp) {
			$('.modal_calc_form').addClass('success');
			$('.modal_calc_form').html('<p>' + resp.message + '</p><p>Страница будет перезагружена через 3 секунду...</p>');
			if(!resp.errors) {
				setTimeout(methods.clearCart, 3000);
			}
			setTimeout(function() {window.location.reload();}, 3500);
        }
      });
    },
		printOrder: function (){
			var data = $(this).closest('.jqcart-checkout').prop('outerHTML');
			if(!data) {
				return false;
			}
			var win = window.open('', 'Печать заказа', 'width='+screen.width+',height='+screen.height),
			cssHref = $(win.opener.document).find('link[href$="jqcart.css"]').attr('href'),
			d = new Date(),
			curDate = ('0' + d.getDate()).slice(-2) + '-' + ('0' + (d.getMonth() + 1)).slice(-2) + '-' + d.getFullYear() + ' ' + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ':' + ('0' + d.getSeconds()).slice(-2);
			
			
			win.document.write('<html><head><title>Заказ ' + curDate + '</title>');
			win.document.write('<link rel="stylesheet" href="' + cssHref + '" type="text/css" />');
			win.document.write('</head><body >');
			win.document.write(data);
			win.document.write('</body></html>');
			
			setTimeout(function(){
				win.document.close(); // нужно для IE >= 10
				win.focus(); // нужно для IE >= 10			
				win.print();
				win.close();
			}, 100);
			
			return true;
		},
    setStorage: function(o) {
      localStorage.setItem('jqcart', JSON.stringify(o));
      return false;
    },
    getStorage: function() {
      return JSON.parse(localStorage.getItem('jqcart'));
    }
  };
  var methods = {
		clearCart: function(){
			localStorage.removeItem('jqcart');
			label[opts.visibleLabel ? 'show' : 'hide']().find('.jqcart-total-cnt').text(0);
			actions.hideCart();
		},
		getStorage: actions.getStorage,
		openCart: actions.openCart,
		printOrder: actions.printOrder,
		test: function(){
			actions.getStorage();
		}
	};
  $.jqCart = function(opts) {
    if (methods[opts]) {
      return methods[opts].apply(this, Array.prototype.slice.call(arguments, 1));
    } else if (typeof opts === 'object' || !opts) {
      return actions.init.apply(this, arguments);
    } else {
      $.error('Метод с именем "' + opts + '" не существует!');
    }
  };
})(jQuery);

