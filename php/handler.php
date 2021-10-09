<?php
parse_str($_POST['orderlist'], $orderlist);
parse_str($_POST['userdata'], $userdata);
$send_ok = true;
/*
$orderlist - массив со списком заказа
$userdata - данные заказчика
*/

// При желании, можно посмотреть полученные данные, записав их в файл:
// file_put_contents('cart_data_log.txt', var_export($orderlist, 1) . "\r\n");
// file_put_contents('cart_data_log.txt', var_export($userdata, 1), FILE_APPEND);
	$i = 1; foreach($orderlist as $id => $item_data) {
		if($i == 1) { $orderId = $item_data['id']; }
	$i++; }
	
	$post_title = 'Заказ №' . $orderId;
	$post_type = 'calc_orders';

	$new_order = array(
		'post_title' => $post_title,
		'post_content' => '',
		'post_status' => 'pending',
		'post_name' => 'pending',
		'post_type' => $post_type
	);

	$pid = wp_insert_post($new_order);
	add_post_meta($pid, 'meta_key', true);
	$total_sum = 0;
	foreach($orderlist as $id => $item_data) {
		
		$total_sum += (float)$item_data['quantity'] * (float)$item_data['price'];
		
		$additional_info = '';
		$order_item_title = $item_data['title'];
		$order_item_price = $item_data['price'];
		$order_item_quantity = $item_data['quantity'];
		$order_item_total = (float)$item_data['quantity'] * (float)$item_data['price'];
		if($item_data['title'] == 'Стул') {
			$additional_info .= 'Материал: ' . $item_data['material'] . '\n';
			if($item_data['back'] == "true") {
				$additional_info .= 'Стул со спинкой: Да \n';
			} else {
				$additional_info .= 'Стул со спинкой: Нет \n';
			}
		}
		if($item_data['title'] == 'Диван') {
			$order_item_quantity = 1;
			$additional_info .= 'Тип дивана: ' . $item_data['selectedtext'] . '\n';
			$additional_info .= 'Материал: ' . $item_data['material'] . '\n';
			if($item_data['cleanboth'] == "true") {
				$additional_info .= 'Чистить с обеих сторон: Да \n';
			} else {
				$additional_info .= 'Чистить с обеих сторон: Нет \n';
			}
			if($item_data['cleanpad'] == "true") {
				if($item_data['padcount'] != 0) {
					$additional_info .= 'Чистить подушки (Кол-во): ' . $item_data['padcount'] . '\n';
				}
			}
			if($item_data['cleanurina'] == "true") {
				$additional_info .= 'Убрать запах: Да \n';
			} else {
				$additional_info .= 'Убрать запах: Нет \n';
			}
		}
		if($item_data['title'] == 'Кресло') {
			$additional_info .= 'Материал: ' . $item_data['material'] . '\n';
			if($item_data['back'] == "true") {
				$additional_info .= 'Стул со спинкой: Да \n';
			} else {
				$additional_info .= 'Стул со спинкой: Нет \n';
			}
		}
		if($item_data['title'] == 'Пуфик') {
			$additional_info .= 'Материал: ' . $item_data['material'] . '\n';
		}
		if($item_data['title'] == 'Матрас') {
			$additional_info .= 'Тип матраса: ' . $item_data['material'] . '\n';
			if($item_data['cleanboth'] == "true") {
				$additional_info .= 'Чистить с обеих сторон: Да \n';
			} else {
				$additional_info .= 'Чистить с обеих сторон: Нет \n';
			}
			if($item_data['smell'] == "true") {
				$additional_info .= 'Убрать запах: Да \n';
			} else {
				$additional_info .= 'Убрать запах: Нет \n';
			}
		}
		if($item_data['title'] == 'Ковры') {
			$additional_info .= 'Длина: ' . $item_data['dlina'] . '\n';
			$additional_info .= 'Ширина: ' . $item_data['shirina'] . '\n';
			$additional_info .= 'Материал: ' . $item_data['material'] . '\n';
		}
		if($item_data['title'] == 'Остальное') {
			$additional_info .= 'Тип предмета: ' . $item_data['selectedtext'] . '\n';
			$additional_info .= 'Выбранный параметр: ' . $item_data['selecteditem'] . '\n';
		}
		$row = array(
			'orders_title' => $order_item_title,
			'orders_price' => $order_item_price,
			'orders_quantity' => $order_item_quantity,
			'orders_total' => $order_item_total,
			'orders_additional' => $additional_info
		);
		add_row('orders_list', $row, $pid);
	}
	if($userdata['coupon'] != 0) {
		update_field('order_coupon', $userdata['coupon'], $pid);
	}
	if($userdata['discount'] != 0) {
		$total_sum_dis = $total_sum * ((100 - $userdata['discount']) / 100);
		update_field('order_total', $total_sum . ' (со скидкой в ' . $userdata['discount'] . '%: ' . $total_sum_dis, $pid);
	} else {
		update_field('order_total', $total_sum, $pid);
	}
// Заголовок письма
/*$subject = 'Заказ от '.date('d.m.Y').'г.';
// ваш Email
$admin_mail = 'admin@best-shop.piva.net';
// Email заказчика (как fallback - ваш же Email)
$to = !empty($userdata['user_mail']) ? $userdata['user_mail'] : $admin_mail;

// Формируем таблицу с заказанными товарами
$tbl = '<table style="width: 100%; border-collapse: collapse;">
	<tr>
		<th style="width: 1%; border: 1px solid #333333; padding: 5px;">ID</th>
		<th style="width: 1%; border: 1px solid #333333; padding: 5px;"></th>
		<th style="border: 1px solid #333333; padding: 5px;">Наименование</th>
		<th style="border: 1px solid #333333; padding: 5px;">Цена</th>
		<th style="border: 1px solid #333333; padding: 5px;">Кол-во</th>
	</tr>';
$total_sum = 0;
foreach($orderlist as $id => $item_data) {
	$total_sum += (float)$item_data['quantity'] * (float)$item_data['price'];
	$tbl .= '
	<tr>
		<td style="border: 1px solid #333333; padding: 5px;">'.$item_data['id'].'</td>
		<td style="border: 1px solid #333333;"><img src="'.$item_data['img'].'" alt="" style="max-width: 64px; max-height: 64px;"></td>
		<td style="border: 1px solid #333333; padding: 5px;">'.$item_data['title'].'</td>
		<td style="border: 1px solid #333333; padding: 5px;">'.$item_data['price'].'</td>
		<td style="border: 1px solid #333333; padding: 5px;">'.$item_data['quantity'].'</td>
	</tr>';
}
$tbl .= '<tr>
		<td  style="border: 1px solid #333333; padding: 5px;" colspan="3">Итого:</td>
		<td style="border: 1px solid #333333; padding: 5px;"><b>'.$total_sum.'</b></td>
		<td style="border: 1px solid #333333;">&nbsp;</td>
	</tr>
</table>';
// Тело письма
$body = '
<html>
<head>
  <title>'.$subject.'</title>
</head>
<body>
  <p>Информация о заказчике:</p>
	<ul>
		<li><b>Ф.И.О.:</b> '.$userdata['user_name'].'</li>
		<li><b>Тел.:</b> '.$userdata['user_phone'].'</li>
		<li><b>Email:</b> '.$userdata['user_mail'].'</li>
		<li><b>Адрес:</b> '.$userdata['user_address'].'</li>
		<li><b>Комментарий:</b> '.$userdata['user_comment'].'</li>
	</ul>
	<p>Информация о заказае:</p>
  '.$tbl.'
	<p>Письмо создано автоматически. Пожалуйста, не отвечайте на него, т.к. все ушли на пляж!</p>
</body>
</html>';

// Заголовки
$headers   = []; // или $headers = array() для версии ниже 5.4
$headers[] = 'MIME-Version: 1.0'; // Обязательный заголовок
$headers[] = 'Content-type: text/html; charset=utf-8'; // Обязательный заголовок. Кодировку изменить при необходимости
$headers[] = 'From: Best Shop <noreply@best-shop.piva.net>'; // От кого
$headers[] = 'Bcc: Admin <'.$admin_mail.'>'; // скрытая копия админу сайта, т.е. вам
$headers[] = 'X-Mailer: PHP/'.phpversion();
// Отправка
$send_ok = mail($to, $subject, $body, implode("\r\n", $headers));

*/
// Ответ на запрос
$response = [
	'errors' => !$send_ok,
	'message' => $send_ok ? 'Заказ принят в обработку!' : 'Хьюстон! У нас проблемы!'
];
// ! Для версий PHP < 5.4 использовать традиционный синтаксис инициализации массивов:
/*
$response = array (
	'errors' => !$send_ok,
	'message' => $send_ok ? 'Заказ принят в обработку!' : 'Хьюстон! У нас проблемы!'
);
*/
exit( json_encode($response) );