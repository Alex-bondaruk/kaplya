<?php
require_once(dirname(__DIR__) . '/him/vendor/autoload.php');
add_action('init', 'start_session', 1);

function start_session()
{
    if (!session_id()) {
        session_start();
        $actual_link = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $getSiteUrl = get_site_url() . '/';
        if (empty($_SESSION['curIdSite']) ) {//|| $getSiteUrl == $actual_link
            $getBlogDetail = get_blog_details(get_current_blog_id());
            $_SESSION['curIdSite'] = $getBlogDetail->blog_id;
            $_SESSION['currentActiveSity'] = $getBlogDetail->blogname;
            $_SESSION['urlCurrentSite'] = $getBlogDetail->path;
        }
    }
}

add_action('wp_ajax_my_actions', 'truemisha_ajax');
add_action('wp_ajax_nopriv_my_actions', 'truemisha_ajax');

function truemisha_ajax()
{
    $_SESSION['curIdSite'] = $_POST['idSite'];
    $_SESSION['currentActiveSity'] = $_POST['currentActiveSity'];
    $_SESSION['urlCurrentSite'] = $_POST['urlCurrentSite'];
    echo $_SESSION['urlCurrentSite'];
    wp_die();
}

function imports_titles()
{
    if($_FILES['file']['name'] == 'titles.csv'){
        $filename = $_FILES['file']['name'];
        $location = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/csv/'.$filename;
        move_uploaded_file($_FILES['file']['tmp_name'], $location);
    }
    $_SESSION['issetImports'] = $_POST['nameImports'];
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/csv/titles.csv')) {
        $_csv_file = $_SERVER["DOCUMENT_ROOT"] . '/wp-content/uploads/csv/titles.csv';
        $handle = fopen($_csv_file, "r"); //Открываем csv для чтения
        $array_line_full = array(); //Массив будет хранить данные из csv
        //Проходим весь csv-файл, и читаем построчно. 3-ий параметр разделитель поля
        while (($line = fgetcsv($handle, 0, ";")) !== FALSE) {
            $array_line_full[] = $line; //Записываем строчки в массив
        }
        fclose($handle); //Закрываем файл

        $keys = $array_line_full[0]; //first element with names of TVs and fields of resource
        unset($array_line_full[0]);
        foreach ($array_line_full as $key => &$row) {
            foreach ($row as $keysPr => $prop) {
                if ($prop) {
                    $arImport[$key][$keys[$keysPr]] = iconv("windows-1251", "utf-8", $prop);
                }
            }
        }
        $sitesImport = get_sites();
        $sitesBlogIdsImport = [];
        foreach ($sitesImport as $k => $site) {
            $sitesBlogIdsImport[$k]['id'] = $site->blog_id;
            $sitesBlogIdsImport[$k]['url'] = $site->path;
        }
        foreach ($sitesBlogIdsImport as $blogId) {
            switch_to_blog($blogId['id']);
            foreach ($arImport as $resource) {
                if ($resource['site_id'] == get_current_blog_id()) {
                    update_post_meta($resource['id'], '_yoast_wpseo_title', $resource['title']);
                    $yoast_indexables_update = $GLOBALS['wpdb']->update(
                        'wp_' . get_current_blog_id() . '_yoast_indexable',
                        array( 'title' => $resource['title'] ),
                        array(
                            'object_id'       => $resource['id']
                        )
                    );
                }
            }
            restore_current_blog();
        }
    }
}

add_action('wp_ajax_imports', 'imports_titles', 9999);
add_action('wp_ajax_nopriv_imports', 'imports_titles', 9999);


add_filter('wpseo_metadesc', 'custom_meta');
function custom_meta($desc)
{

    if (is_singular('service')) {
        $minPrice = [];
        while (have_rows('serv_prices_loop')): the_row(); ?>
            <?php $minPrice[] = substr(get_sub_field('serv_price_price'), 5, -3); ?>
        <?php endwhile; ?>
        <?php $sityName = morphos\Russian\GeographicalNamesInflection::getCase($_SESSION['currentActiveSity'], 'предложный');
        $desc = get_the_title() . "➤в " . $sityName . " на дому. " . get_the_title() . " ➦от " . min($minPrice) . "руб. Если не понравится, ✔вернем деньги! Скидка 10% при заказе от 5000 руб. Звоните ☎! Наша сеть - 80 городов РФ!";
    }
    return $desc;
}

/* function to create sitemap.xml file in root directory of site  */
/*add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");*/
add_action("save_post", "eg_create_sitemap");
function eg_create_sitemap()
{
    $sitesSitemap = get_sites();
    $sitesBlogIdsSitemap = [];
    $fpAll = [];
    foreach ($sitesSitemap as $k => $site) {
        $sitesBlogIdsSitemap[$k]['id'] = $site->blog_id;
        $sitesBlogIdsSitemap[$k]['url'] = $site->path;
    }
    foreach ($sitesBlogIdsSitemap as $blogId) {
        switch_to_blog($blogId['id']);
        if ($blogId['id'] == get_current_blog_id()) {
            if (str_replace('-', '', get_option('gmt_offset')) < 10) {
                $tempo = '-0' . str_replace('-', '', get_option('gmt_offset'));
            } else {
                $tempo = get_option('gmt_offset');
            }
            if (strlen($tempo) == 3) {
                $tempo = $tempo . ':00';
            }
            $postsForSitemap = get_posts(array(
                'numberposts' => -1,
                'orderby' => 'modified',
                'post_type' => array('post', 'page', 'service'),
                'order' => 'DESC'
            ));
            $blogId = $blogId['id'];
            $sitemap[$blogId] .= '<?xml version="1.0" encoding="UTF-8"?>';
            $sitemap[$blogId] .= "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            $sitemap[$blogId] .= "\t" . '<url>' . "\n" .
                "\t\t" . '<loc>' . esc_url(home_url('/')) . '</loc>' .
                "\n\t\t" . '<lastmod>' . date("Y-m-d\TH:i:s", current_time('timestamp', 0)) . $tempo . '</lastmod>' .
                "\n\t\t" . '<changefreq>daily</changefreq>' .
                "\n\t\t" . '<priority>1.0</priority>' .
                "\n\t" . '</url>' . "\n";
            $priority = 0.6;

            foreach ($postsForSitemap as $post) {
                setup_postdata($post);
                $postdate = explode(" ", $post->post_modified);
                $sitemap[$blogId] .= "\t" . '<url>' . "\n" .
                    "\t\t" . '<loc>' . get_permalink($post->ID) . '</loc>' .
                    "\n\t\t" . '<lastmod>' . $postdate[0] . 'T' . $postdate[1] . $tempo . '</lastmod>' .
                    "\n\t\t" . '<changefreq>Weekly</changefreq>' .
                    "\n\t\t" . '<priority>' . $priority . '</priority>' .
                    "\n\t" . '</url>' . "\n";
            }
            $sitemap[$blogId].= '</urlset>';
            $fp = fopen(ABSPATH . "/sitemap_" . get_current_blog_id() . ".xml", 'w+');
            $fpAll[] = get_site_url(1) . "/sitemap_" . get_current_blog_id() . ".xml";
            fwrite($fp, $sitemap[$blogId]);
            fclose($fp);
        }
        restore_current_blog();
    }
    $sitemapBase .= '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:html="http://www.w3.org/TR/REC-html40" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"><head><title>XML Sitemap</title><style type="text/css">
				body {
					font-family: Helvetica, Arial, sans-serif;
					font-size: 13px;
					color: #545353;
				}
				table {
					border: none;
					border-collapse: collapse;
				}
				#sitemap tr:nth-child(odd) td {
					background-color: #eee !important;
				}
				#sitemap tbody tr:hover td {
					background-color: #ccc;
				}
				#sitemap tbody tr:hover td, #sitemap tbody tr:hover td a {
					color: #000;
				}
				#content {
					margin: 0 auto;
					width: 1000px;
				}
				a {
					color: #000;
					text-decoration: none;
				}
				a:visited {
					color: #777;
				}
				a:hover {
					text-decoration: underline;
				}
				td {
					font-size:11px;
				}
				th {
					text-align:left;
					padding-right:30px;
					font-size:11px;
				}
				thead th {
					border-bottom: 1px solid #000;
				}
			</style></head><body><div><h1>XML Sitemap</h1><table id="sitemap" cellpadding="3"><thead><tr><th width="75%">Sitemap</th><th width="25%">Last Modified</th></tr></thead><tbody>';
    foreach ($fpAll as $fpAllItem) {
        $sitemapBase .= "\t" . '<tr>' . "\n" .
            "\t\t" . '<td><a href="'.$fpAllItem.'">'.$fpAllItem.'</a></td>' .
            "\n\t\t" . '<td>'.date("Y-m-d\TH:i:s", current_time('timestamp', 0)) . $tempo .'</td>' .
            "\n\t" . '</tr>' . "\n";
    }
    $sitemapBase .= '</tbody></table></div></body></html>';
    $baseSitemapFopen = fopen(ABSPATH . "sitemap.xml", 'w+');
    fwrite($baseSitemapFopen, $sitemapBase);
    fclose($baseSitemapFopen);
}

add_filter( 'wpcf7_special_mail_tags', 'wpcf7_session_sity', 10, 3 );
function wpcf7_session_sity( $output, $name, $html ) {
    if ( '_wpcf7_session_sity' != $name ) {
        return $output;
    }

    if ( ! $contact_form = WPCF7_ContactForm::get_current() ) {
        return $output;
    }
    if(isset($_SESSION['currentActiveSity']) && !empty($_SESSION['currentActiveSity'])){
        $val = $_SESSION['currentActiveSity'];
    } else {
        $val = get_option( 'options_city_for_list' );
    }

    return $html ? esc_html($val) : $val;
}

add_theme_support('menus');
register_nav_menus(
    array(
        'основное_меню' => 'Основное меню',
        'head_menu_mobile' => 'Мобильное меню',
        'foot_menu_1' => 'Меню в футере - Колонка 1',
        'foot_menu_2' => 'Меню в футере - Колонка 2',
        'foot_menu_3' => 'Меню в футере - Колонка 3'
    )
);

add_theme_support('post-thumbnails', array('post', 'page', 'service', 'calcs_items'));

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Основные настройки',
        'menu_title' => 'Основные настройки',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}
add_action('wpcf7_autop_or_not', '__return_false');
add_filter('widget_text', 'do_shortcode');
function custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;

    return array(
        'index.php', // Консоль
        'theme-general-settings',
    );
}

add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');

function gb_custom_css_admin()
{

    echo PHP_EOL . '<style type="text/css">
#toplevel_page_theme-general-settings{
     background: #30c12f;
}
#toplevel_page_theme-general-settings a{
     color:#fff;
}
#menu-posts-product{
	background: #2981e9;
}
#menu-posts-product:hover{
	background: #2981e9;
}
#menu-posts-product a{
	color:#fff;
}
</style>' . PHP_EOL;

    // endif;
}

add_action('admin_head', 'gb_custom_css_admin');

add_action('admin_head', 'hidden_term_description');

function hidden_term_description()
{
    print '<style>
.term-description-wrap { display:none; }
</style>';
}

function change_wp_search_size($query)
{
    if ($query->is_search)
        $query->query_vars['posts_per_page'] = -1;

    return $query;
}

add_filter('pre_get_posts', 'change_wp_search_size');

add_action('init', 'calcs_items');
function calcs_items()
{
    register_post_type('calcs_items', array(
        'public' => true,
        'supports' => array('title', 'thumbnail'),
        'rewrite' => false,
        'menu_position' => 7,
        'has_archive' => false,
        'exclude_from_search' => true,
        'menu_icon' => admin_url() . 'images/media-button-other.gif',
        'labels' => array(
            'name' => 'Элементы калькулятора',
            'all_items' => 'Все',
            'add_new' => 'Добавить',
            'add_new_item' => 'Добавить'
        )
    ));
}

add_action('init', 'calc_orders');
function calc_orders()
{
    register_post_type('calc_orders', array(
        'public' => true,
        'supports' => array('title', 'thumbnail'),
        'rewrite' => false,
        'menu_position' => 7,
        'has_archive' => false,
        'exclude_from_search' => true,
        'menu_icon' => admin_url() . 'images/media-button-other.gif',
        'labels' => array(
            'name' => 'Заказы',
            'all_items' => 'Все',
            'add_new' => 'Добавить',
            'add_new_item' => 'Добавить'
        )
    ));
}

add_action('admin_head', 'wpds_custom_admin_post_css');
function wpds_custom_admin_post_css()
{

    global $post_type;

    if ($post_type == 'calcs_items' || $post_type == 'calc_orders') {
        echo "<style>#edit-slug-box {display:none;}</style>";
    }
}

add_action('wp_ajax_nopriv_codyshop_ajax_search', 'codyshop_ajax_search');
add_action('wp_ajax_codyshop_ajax_search', 'codyshop_ajax_search');
function codyshop_ajax_search()
{
    if (have_rows('coupons_loop', 'option')) {
        while (have_rows('coupons_loop', 'option')) : the_row();
            if (mb_strtolower($_POST['term']) == mb_strtolower(get_sub_field('coupon_title'))) {
                echo get_sub_field('coupon_value');
                break;
            } else {
                echo 0;
            }
        endwhile;
    }
    exit;
}

add_action('wp_ajax_nopriv_post_ajax_add', 'post_ajax_add');
add_action('wp_ajax_post_ajax_add', 'post_ajax_add');
function post_ajax_add()
{

    if (is_multisite()) {
        switch_to_blog(get_current_blog_id());
    }

    $city_option = get_option('options_city_for_list');
    $mail_option = get_option('options_email_for_order_cart');


    parse_str($_POST['orderlist'], $orderlist);
    parse_str($_POST['userdata'], $userdata);
    $i = 1;
    foreach ($orderlist as $id => $item_data) {
        if ($i == 1) {
            $orderId = $item_data['id'];
        }
        $i++;
    }

    $order_username = $userdata['user_name'];
    $order_phone = $userdata['user_phone'];
    $order_address = $userdata['user_address'];
    $order_time = $userdata['time_clean'];
    if ($order_time == 'morning') {
        $order_time_txt = 'Утро';
    }
    if ($order_time == 'day') {
        $order_time_txt = 'День';
    }
    if ($order_time == 'evening') {
        $order_time_txt = 'Вечер';
    }
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
    foreach ($orderlist as $id => $item_data) {

        $total_sum += (float)$item_data['quantity'] * (float)$item_data['price'];

        $additional_info = '';
        $order_item_title = $item_data['title'];
        $order_item_price = $item_data['price'];
        $order_item_quantity = $item_data['quantity'];
        $order_item_total = (float)$item_data['quantity'] * (float)$item_data['price'];
        if ($item_data['title'] == 'Стул') {
            $additional_info .= "Материал: " . $item_data['material'] . "\n";
            if ($item_data['back'] == "true") {
                $additional_info .= "Стул со спинкой: Да \n";
            } else {
                $additional_info .= "Стул со спинкой: Нет \n";
            }
        }
        if ($item_data['title'] == 'Диван') {
            $order_item_quantity = 1;
            $additional_info .= "Тип дивана: " . $item_data['selectedtext'] . "\n";
            $additional_info .= "Материал: " . $item_data['material'] . "\n";
            if ($item_data['cleanboth'] == "true") {
                $additional_info .= "Чистить с обеих сторон: Да \n";
            } else {
                $additional_info .= "Чистить с обеих сторон: Нет \n";
            }
            if ($item_data['cleanpad'] == "true") {
                if ($item_data['padcount'] != 0) {
                    $additional_info .= "Чистить подушки (Кол-во): " . $item_data['padcount'] . "\n";
                }
            }
            if ($item_data['cleanurina'] == "true") {
                $additional_info .= "Убрать запах: Да \n";
            } else {
                $additional_info .= "Убрать запах: Нет \n";
            }
        }
        if ($item_data['title'] == 'Кресло') {
            $additional_info .= "Материал: " . $item_data['material'] . "\n";
            if ($item_data['slide'] == "true") {
                $additional_info .= "Выдвижная часть: Да \n";
            } else {
                $additional_info .= "Выдвижная часть: Нет \n";
            }
        }
        if ($item_data['title'] == 'Пуфик') {
            $additional_info .= "Материал: " . $item_data['material'] . "\n";
        }
        if ($item_data['title'] == 'Матрас') {
            $additional_info .= "Тип матраса: " . $item_data['material'] . "\n";
            if ($item_data['cleanboth'] == "true") {
                $additional_info .= "Чистить с обеих сторон: Да \n";
            } else {
                $additional_info .= "Чистить с обеих сторон: Нет \n";
            }
            if ($item_data['smell'] == "true") {
                $additional_info .= "Убрать запах: Да \n";
            } else {
                $additional_info .= "Убрать запах: Нет \n";
            }
        }
        if ($item_data['title'] == 'Офисная мебель') {
            $additional_info .= "Тип мебели: " . $item_data['selectedtext'] . "\n";
            $additional_info .= "Материал: " . $item_data['material'] . "\n";
        }
        if ($item_data['title'] == 'Ковры') {
            $additional_info .= "Длина: " . $item_data['dlina'] . "\n";
            $additional_info .= "Ширина: " . $item_data['shirina'] . "\n";
            $additional_info .= "Материал: " . $item_data['material'] . "\n";
        }
        if ($item_data['title'] == 'Остальное') {
            $additional_info .= "Тип предмета: " . $item_data['selectedtext'] . "\n";
            $additional_info .= "Выбранный параметр: " . $item_data['selecteditem'] . "\n";
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
    if ($userdata['discount'] != 0) {
        $total_sum_dis = $total_sum * ((100 - $userdata['discount']) / 100);
        update_field('order_total', $total_sum . ' (со скидкой в ' . $userdata['discount'] . '%: ' . $total_sum_dis . ')', $pid);
        update_field('order_coupon', $userdata['coupon'], $pid);
    } else {
        update_field('order_total', $total_sum, $pid);
    }
    update_field('order_username', $order_username, $pid);
    update_field('order_phone', $order_phone, $pid);
    update_field('order_address', $order_address, $pid);
    update_field('order_time', $order_time_txt, $pid);

    $subject = 'Заказ №' . $orderId;
    // ваш Email
    $admin_mail = $mail_option;
    $to = !empty($userdata['user_mail']) ? $userdata['user_mail'] : $admin_mail;
    $tbl = '<table style="width: 100%; border-collapse: collapse;">
		<tr>
			<th style="border: 1px solid #333333; padding: 5px;">Наименование</th>
			<th style="border: 1px solid #333333; padding: 5px;">Цена</th>
			<th style="border: 1px solid #333333; padding: 5px;">Кол-во</th>
		</tr>';
    $total_sum = 0;
    foreach ($orderlist as $id => $item_data) {
        $total_sum += (float)$item_data['quantity'] * (float)$item_data['price'];
        $tbl .= '
		<tr>
			<td style="border: 1px solid #333333; padding: 5px;">' . $item_data['title'] . '</td>
			<td style="border: 1px solid #333333; padding: 5px;">' . $item_data['price'] . '</td>
			<td style="border: 1px solid #333333; padding: 5px;">' . $item_data['quantity'] . '</td>
		</tr>';
    }
    if ($userdata['discount'] != 0) {
        $tbl .= '<tr>
				<td  style="border: 1px solid #333333; padding: 5px;" colspan="3">Итого:</td>
				<td style="border: 1px solid #333333; padding: 5px;"><b>' . $total_sum . ' (со скидкой в ' . $userdata['discount'] . '%: ' . $total_sum_dis . ')' . '</b></td>
				<td style="border: 1px solid #333333;">&nbsp;</td>
			</tr>
		</table>';
    } else {
        $tbl .= '<tr>
				<td  style="border: 1px solid #333333; padding: 5px;" colspan="3">Итого:</td>
				<td style="border: 1px solid #333333; padding: 5px;"><b>' . $total_sum . '</b></td>
				<td style="border: 1px solid #333333;">&nbsp;</td>
			</tr>
		</table>';
    }
    $body = '
	<html>
	<head>
	  <title>' . $subject . '</title>
	</head>
	<body>
	  <p>Информация о заказчике:</p>
		<ul>
			<li><b>Имя:</b> ' . $userdata['user_name'] . '</li>
			<li><b>Тел.:</b> ' . $userdata['user_phone'] . '</li>
			<!-- <li><b>Адрес:</b> ' . $userdata['user_address'] . '</li>
			<li><b>Город:</b> ' . $city_option . '</li>-->
		</ul>
		<p>Информация о заказе:</p>
	  ' . $tbl . '
		<p>Письмо создано автоматически. Пожалуйста, не отвечайте на него</p>
	</body>
	</html>';

    $headers = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: Best Shop <noreply@best-shop.piva.net>';
    $headers[] = 'Bcc: Admin <' . $admin_mail . '>';
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    $send_ok = wp_mail($to, $subject, $body, implode("\r\n", $headers));

    $response = [
        'errors' => !$send_ok,
        'message' => $send_ok ? 'Заказ принят в обработку!' : 'Хьюстон! У нас проблемы!'
    ];
    exit(json_encode($response));
}

class macho_bootstrap_walker extends Walker_Nav_Menu
{

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        if (strcasecmp($item->attr_title, 'divider') == 0 && $depth === 1) {
            $output .= $indent . '<li role="presentation" class="divider">';
        } else if (strcasecmp($item->title, 'divider') == 0 && $depth === 1) {
            $output .= $indent . '<li role="presentation" class="divider">';
        } else if (strcasecmp($item->attr_title, 'dropdown-header') == 0 && $depth === 1) {
            $output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr($item->title);
        } else if (strcasecmp($item->attr_title, 'disabled') == 0) {
            $output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr($item->title) . '</a>';
        } else {

            $class_names = $value = '';

            $classes = empty($item->classes) ? array() : (array)$item->classes;
            $classes[] = 'menu-item-' . $item->ID;

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));

            if ($args->has_children)
                $class_names .= ' dropdown';

            if (in_array('current-menu-item', $classes))
                $class_names .= ' active';

            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names . '>';

            $atts = array();
            $atts['title'] = !empty($item->title) ? $item->title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';


            $atts['custom'] = !empty($item->custom) ? $item->custom : '';

            // If item has_children add atts to a.
            if ($args->has_children && $depth === 0) {
                if (!in_array('special_menu', $item->classes)) {
                    $parseUrl = parse_url($item->url);
                    $explodePathUrl = explode('/', $parseUrl['path']);
                    $explodePathUrlNew = [];
                    $sessionUrlPathSite = str_replace('/', '', $_SESSION['urlCurrentSite']);
                    foreach ($explodePathUrl as $kUrl => $explodePathUrlItem) {
                        if ($kUrl == 1 && !empty($sessionUrlPathSite)) {
                            $explodePathUrlNew[$kUrl] = $sessionUrlPathSite;
                        } elseif ($kUrl == 1 && empty($sessionUrlPathSite)) {
                            unset($explodePathUrlNew[$kUrl]);
                        } else {
                            $explodePathUrlNew[$kUrl] = $explodePathUrlItem;
                        }
                    }
                    $implodePathUrl = implode('/', $explodePathUrlNew);
                    $fullimplodeUrl = $parseUrl['scheme'] . '://' . $parseUrl['host'] . $implodePathUrl;
                    $pathDomainWithoutSlash = substr($_SESSION['urlCurrentSite'],0,-1);
                    $fullimplodeUrlOther = get_site_url() . $pathDomainWithoutSlash . $parseUrl['path'];
                    if ($_SESSION['urlCurrentSite'] == '/') {
                        $atts['href'] = $item->url;
                    } else {
                        $actual_link = "https://" . $_SERVER['HTTP_HOST'].$_SESSION['urlCurrentSite'];
                        if(get_site_url() == 'https://reflection-web.ru/' ||
                            get_site_url() == 'https://himchistka-kaplya.ru/'){
                            $getSiteUrl = get_site_url();
                        } else {
                            $getSiteUrl = get_site_url() .'/';
                        }

                        if($actual_link != $getSiteUrl) {
                            $atts['href'] = $fullimplodeUrlOther;
                        } else {
                            $atts['href'] = $fullimplodeUrl;
                        }
                    }
                } else {
                    if ($_SESSION['urlCurrentSite'] == '/') {
                        $baseUrlSitePages = $item->url;
                    } else {
                        $baseUrlSitePages = str_replace($_SESSION['urlCurrentSite'], '/', $item->url);
                    }
                    $atts['href'] = $baseUrlSitePages;
                }
                //$atts['href'] = $item->url;
                $atts['data-toggle'] = 'dropdown';
                $atts['class'] = 'dropdown-toggle';
                $atts['aria-haspopup'] = 'true';
            } else {
                if (!in_array('special_menu', $item->classes)) {
                    $parseUrl = parse_url($item->url);
                    $explodePathUrl = explode('/', $parseUrl['path']);
                    $explodePathUrlNew = [];
                    $sessionUrlPathSite = str_replace('/', '', $_SESSION['urlCurrentSite']);
                    foreach ($explodePathUrl as $kUrl => $explodePathUrlItem) {
                        if ($kUrl == 1 && !empty($sessionUrlPathSite)) {
                            $explodePathUrlNew[$kUrl] = $sessionUrlPathSite;
                        } elseif ($kUrl == 1 && empty($sessionUrlPathSite)) {
                            unset($explodePathUrlNew[$kUrl]);
                        } else {
                            $explodePathUrlNew[$kUrl] = $explodePathUrlItem;
                        }
                    }
                    $implodePathUrl = implode('/', $explodePathUrlNew);
                    $fullimplodeUrl = $parseUrl['scheme'] . '://' . $parseUrl['host'] . $implodePathUrl;
                    $pathDomainWithoutSlash = substr($_SESSION['urlCurrentSite'],0,-1);
                    $fullimplodeUrlOther = $parseUrl['scheme'] . '://' . $parseUrl['host'] . $pathDomainWithoutSlash . $parseUrl['path'];
                    if ($_SESSION['urlCurrentSite'] == '/') {
                        $atts['href'] = $item->url;
                    } else {
                        $actual_link = "https://" . $_SERVER['HTTP_HOST'].$_SESSION['urlCurrentSite'];
                        if(get_site_url() == 'https://reflection-web.ru/' ||
                            get_site_url() == 'https://himchistka-kaplya.ru/'){
                            $getSiteUrl = get_site_url();
                        } else {
                            $getSiteUrl = get_site_url() .'/';
                        }

                        if($actual_link != $getSiteUrl) {
                            $atts['href'] = $fullimplodeUrlOther;
                        } else {
                            $atts['href'] = $fullimplodeUrl;
                        }
                    }
                } else {
                    if ($_SESSION['urlCurrentSite'] == '/') {
                        $baseUrlSitePages = str_replace($_SESSION['urlCurrentSite'], '', $item->url);
                    } else {
                        $baseUrlSitePages = str_replace($_SESSION['urlCurrentSite'], '/', $item->url);
                    }
                    if ($_SESSION['urlCurrentSite'] == '/') {
                        $atts['href'] = !empty($item->url) ? $item->url : '';
                    } else {
                        $atts['href'] = !empty($baseUrlSitePages) ? $baseUrlSitePages : '';
                    }
                }
                //$atts['href'] = !empty($item->url) ? $item->url : '';
            }

            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);


            $attributes = '';
            foreach ($atts as $attr => $value) {


                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $item_output = $args->before;

            /*
             * Glyphicons
             * ===========
             * Since the the menu item is NOT a Divider or Header we check the see
             * if there is a value in the attr_title property. If the attr_title
             * property is NOT null we apply it as the class name for the glyphicon.
             */
            if (!empty($item->attr_title))
                $item_output .= '<a' . $attributes . '><span class="glyphicon ' . esc_attr($item->attr_title) . '"></span>&nbsp;';
            else
                $item_output .= '<a' . $attributes . '>';


            $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
            $item_output .= ($args->has_children && 0 === $depth) ? ' <span class="caret"></span></a>' : '</a>';
            $item_output .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }
    }

    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element)
            return;

        $id_field = $this->db_fields['id'];

        // Display this element.
        if (is_object($args[0]))
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }

    public static function fallback($args)
    {
        if (current_user_can('manage_options')) {

            extract($args);

            $fb_output = null;

            if ($container) {
                $fb_output = '<' . $container;

                if ($container_id)
                    $fb_output .= ' id="' . $container_id . '"';

                if ($container_class)
                    $fb_output .= ' class="' . $container_class . '"';

                $fb_output .= '>';
            }

            $fb_output .= '<ul';

            if ($menu_id)
                $fb_output .= ' id="' . $menu_id . '"';

            if ($menu_class)
                $fb_output .= ' class="' . $menu_class . '"';

            $fb_output .= '>';
            $fb_output .= '<li><a href="' . admin_url('nav-menus.php') . '">Add a menu</a></li>';
            $fb_output .= '</ul>';

            if ($container)
                $fb_output .= '</' . $container . '>';

            echo $fb_output;
        }
    }
}

function get_posts_4_st($query)
{
    if (!is_admin() && $query->is_main_query() && is_category(19)) {
        $query->set('posts_per_page', 9);
    }
}

add_action('pre_get_posts', 'get_posts_4_st');

function true_load_testim()
{
    $args = json_decode($_POST['query'], true);
    $args['paged'] = $_POST['page'] + 1; // следующая страница
    $args['post_status'] = 'publish';
    $args['post_type'] = 'post';
    $args['category_name'] = 'otzyvy';
    $args['posts_per_page'] = 4;
    $args['meta_query'] = array(
        array(
            'key' => 'otz_video_true',
            'value' => '1',
            'compare' => '',
        )
    );
    // обычно лучше использовать WP_Query, но не здесь
    query_posts($args);
    // если посты есть
    if (have_posts()) :
        ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php $otz_link = get_field('otz_link'); ?>
        <div class="s7_item" data-id="<?php echo get_the_ID(); ?>"
             style="background: url(<?php the_post_thumbnail_url('full'); ?>);">
            <?php if (!empty($otz_link)): ?>
                <a href="<?php echo $otz_link; ?>" class="s7_item_btn" data-fancybox="gallery_opin">
                    <div class="s7_item_btn_play">
                        <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                    </div>
                </a>
            <?php else: ?>
                <a href="<?php the_post_thumbnail_url('full'); ?>" class="s7_item_btn" data-fancybox="gallery_opin"></a>
            <?php endif; ?>
        </div>
    <?php endwhile;
        wp_reset_postdata(); ?>
    <?php endif;
    die();
}

add_action('wp_ajax_load_testim', 'true_load_testim');
add_action('wp_ajax_nopriv_load_testim', 'true_load_testim');

function true_load_testim_text()
{
    $args = json_decode($_POST['query'], true);
    $args['paged'] = $_POST['page_text'] + 1; // следующая страница
    $args['post_status'] = 'publish';
    $args['post_type'] = 'post';
    $args['category_name'] = 'otzyvy';
    $args['posts_per_page'] = 3;
    $args['meta_query'] = array(
        array(
            'key' => 'otz_video_true',
            'value' => '0',
            'compare' => '',
        )
    );
    // обычно лучше использовать WP_Query, но не здесь
    query_posts($args);
    // если посты есть
    if (have_posts()) :
        ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php $i = 1;
        $j = 1;
        $star_rating = null; ?>
        <div class="s7_item_text" data-id="<?php echo get_the_ID(); ?>">
            <div class="otz_name"><? the_field('text_review_name'); ?></div>
            <div class="otz_date"><? the_field('date_reviews'); ?></div>
            <div class="otz_stars">
                <div class="starsItems">
                    <?php
                    $starsInt = intval(get_field('star_rating'));
                    for ($i; $i <= $starsInt; $i++) {
                        $star_rating .= '<i class="fa fa-star" aria-hidden="true"></i>';
                    }
                    if ($starsInt < 5) {
                        for ($j; $j <= (5 - $starsInt); $j++) {
                            $star_rating .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                        }
                    }
                    echo $star_rating;
                    ?>
                </div>
            </div>
            <div class="otz_text"><? the_field('text_otzv'); ?></div>
        </div>
    <?php endwhile;
        wp_reset_postdata(); ?>
    <?php endif;
    die();
}

add_action('wp_ajax_load_testim_text', 'true_load_testim_text');
add_action('wp_ajax_nopriv_load_testim_text', 'true_load_testim_text');

function true_load_posts()
{
    $args = json_decode($_POST['query'], true);
    $args['paged'] = $_POST['page'] + 1; // следующая страница
    $args['post_status'] = 'publish';
    $args['post_type'] = 'post';
    $args['category_name'] = 'stati';
    $args['posts_per_page'] = 9;
    // обычно лучше использовать WP_Query, но не здесь
    query_posts($args);
    // если посты есть
    if (have_posts()) :
        ?>
        <?php while (have_posts()) : the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="s6_item">
            <div class="s6_item_img">
                <img src="<?php the_post_thumbnail_url('full'); ?>" alt=""/>
            </div>
            <div class="s6_item_date">
                <?php $mydate = the_time('d.m.Y'); ?>
            </div>
            <div class="s6_item_desc">
                <?php the_title(); ?>
            </div>
        </a>
    <?php endwhile;
        wp_reset_postdata(); ?>
    <?php endif;
    die();
}

add_action('wp_ajax_load_posts', 'true_load_posts');
add_action('wp_ajax_nopriv_load_posts', 'true_load_posts');

add_filter('network-media-library/site_id', function ($site_id) {
    return 1;
});

function get_sites_alphabet()
{
    $blog_list = wp_get_sites(0, 'all');
    $array = [];
    $i = 0;
    foreach ($blog_list as $blog) {
        $array[$i] = [
            "blog_id" => $blog['blog_id'],
            "blog_path" => $blog['path'],
            "blog_city" => get_blog_option($blog['blog_id'], 'options_city_for_list')
        ];
        $i++;
    }

    usort($array, function ($v1, $v2) {
        return strcmp($v1['blog_city'], $v2['blog_city']);
    });
    $memory = NULL;
    $sorting = array();
    foreach ($array as $key => $item) {
        $letter = mb_substr($item['blog_city'], 0, 1, 'utf-8');
        if ($letter != $memory) {
            $memory = $letter;
            $sorting[$memory] = array();
        }
        $sorting[$memory][$key] = $item;
    }
    $array = $sorting;
    return $array;
}

function kama_breadcrumbs($sep = ' » ', $l10n = array(), $args = array())
{
    $kb = new Kama_Breadcrumbs;
    echo $kb->get_crumbs($sep, $l10n, $args);
}

class Kama_Breadcrumbs
{

    public $arg;

    // Локализация
    static $l10n = array(
        'home' => 'Главная',
        'paged' => 'Страница %d',
        '_404' => 'Ошибка 404',
        'search' => 'Результаты поиска по запросу - <b>%s</b>',
        'author' => 'Архив автора: <b>%s</b>',
        'year' => 'Архив за <b>%d</b> год',
        'month' => 'Архив за: <b>%s</b>',
        'day' => '',
        'attachment' => 'Медиа: %s',
        'tag' => 'Записи по метке: <b>%s</b>',
        'tax_tag' => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
        // tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
        // Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
    );

    // Параметры по умолчанию
    static $args = array(
        'on_front_page' => true,  // выводить крошки на главной странице
        'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
        'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
        'title_patt' => '<span class="kb_title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
        'last_sep' => true,  // показывать последний разделитель, когда заголовок в конце не отображается
        'markup' => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
        // или можно указать свой массив разметки:
        // array( 'wrappatt'=>'<div class="breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
        'priority_tax' => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
        'priority_terms' => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
        // Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
        // 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
        // порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
        'nofollow' => false, // добавлять rel=nofollow к ссылкам?

        // служебные
        'sep' => '',
        'linkpatt' => '',
        'pg_end' => '',
    );

    function get_crumbs($sep, $l10n, $args)
    {
        global $post, $wp_query, $wp_post_types;

        self::$args['sep'] = $sep;

        // Фильтрует дефолты и сливает
        $loc = (object)array_merge(apply_filters('kama_breadcrumbs_default_loc', self::$l10n), $l10n);
        $arg = (object)array_merge(apply_filters('kama_breadcrumbs_default_args', self::$args), $args);

        $arg->sep = '<span class="sep">' . $arg->sep . '</span>'; // дополним

        // упростим
        $sep = &$arg->sep;
        $this->arg = &$arg;

        // микроразметка ---
        if (1) {
            $mark = &$arg->markup;

            // Разметка по умолчанию
            if (!$mark) $mark = array(
                'wrappatt' => '<div class="breadcrumbs">%s</div>',
                'linkpatt' => '<a href="%s">%s</a>',
                'sep_after' => '',
            );
            // rdf
            elseif ($mark === 'rdf.data-vocabulary.org') $mark = array(
                'wrappatt' => '<div class="breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
                'linkpatt' => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
                'sep_after' => '</span>', // закрываем span после разделителя!
            );
            // schema.org
            elseif ($mark === 'schema.org') $mark = array(
                'wrappatt' => '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
                'linkpatt' => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
                'sep_after' => '',
            );

            elseif (!is_array($mark))
                die(__CLASS__ . ': "markup" parameter must be array...');

            $wrappatt = $mark['wrappatt'];
            $arg->linkpatt = $arg->nofollow ? str_replace('<a ', '<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
            $arg->sep .= $mark['sep_after'] . "\n";
        }

        $linkpatt = $arg->linkpatt; // упростим

        $q_obj = get_queried_object();

        // может это архив пустой таксы?
        $ptype = null;
        if (empty($post)) {
            if (isset($q_obj->taxonomy))
                $ptype = &$wp_post_types[get_taxonomy($q_obj->taxonomy)->object_type[0]];
        } else $ptype = &$wp_post_types[$post->post_type];

        // paged
        $arg->pg_end = '';
        if (($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')))
            $arg->pg_end = $sep . sprintf($loc->paged, (int)$paged_num);

        $pg_end = $arg->pg_end; // упростим

        $out = '';

        if (is_front_page()) {
            return $arg->on_front_page ? sprintf($wrappatt, ($paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home)) : '';
        } // страница записей, когда для главной установлена отдельная страница.
        elseif (is_home()) {
            $out = $paged_num ? (sprintf($linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title)) . $pg_end) : esc_html($q_obj->post_title);
        } elseif (is_404()) {
            $out = $loc->_404;
        } elseif (is_search()) {
            $out = sprintf($loc->search, esc_html($GLOBALS['s']));
        } elseif (is_author()) {
            $tit = sprintf($loc->author, esc_html($q_obj->display_name));
            $out = ($paged_num ? sprintf($linkpatt, get_author_posts_url($q_obj->ID, $q_obj->user_nicename) . $pg_end, $tit) : $tit);
        } elseif (is_year() || is_month() || is_day()) {
            $y_url = get_year_link($year = get_the_time('Y'));

            if (is_year()) {
                $tit = sprintf($loc->year, $year);
                $out = ($paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit);
            } // month day
            else {
                $y_link = sprintf($linkpatt, $y_url, $year);
                $m_url = get_month_link($year, get_the_time('m'));

                if (is_month()) {
                    $tit = sprintf($loc->month, get_the_time('F'));
                    $out = $y_link . $sep . ($paged_num ? sprintf($linkpatt, $m_url, $tit) . $pg_end : $tit);
                } elseif (is_day()) {
                    $m_link = sprintf($linkpatt, $m_url, get_the_time('F'));
                    $out = $y_link . $sep . $m_link . $sep . get_the_time('l');
                }
            }
        } // Древовидные записи
        elseif (is_singular() && $ptype->hierarchical) {
            $out = $this->_add_title($this->_page_crumbs($post), $post);
        } // Таксы, плоские записи и вложения
        else {
            $term = $q_obj; // таксономии
            // определяем термин для записей (включая вложения attachments)
            if (is_singular()) {
                // изменим $post, чтобы определить термин родителя вложения
                if (is_attachment() && $post->post_parent) {
                    $save_post = $post; // сохраним
                    $post = get_post($post->post_parent);
                }

                // учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
                $taxonomies = get_object_taxonomies($post->post_type);
                // оставим только древовидные и публичные, мало ли...
                $taxonomies = array_intersect($taxonomies, get_taxonomies(array('hierarchical' => true, 'public' => true)));

                if ($taxonomies) {
                    // сортируем по приоритету
                    if (!empty($arg->priority_tax)) {
                        usort($taxonomies, function ($a, $b) use ($arg) {
                            $a_index = array_search($a, $arg->priority_tax);
                            if ($a_index === false) $a_index = 9999999;

                            $b_index = array_search($b, $arg->priority_tax);
                            if ($b_index === false) $b_index = 9999999;

                            return ($b_index === $a_index) ? 0 : ($b_index < $a_index ? 1 : -1); // меньше индекс - выше
                        });
                    }

                    // пробуем получить термины, в порядке приоритета такс
                    foreach ($taxonomies as $taxname) {
                        if ($terms = get_the_terms($post->ID, $taxname)) {
                            // проверим приоритетные термины для таксы
                            $prior_terms = &$arg->priority_terms[$taxname];
                            if ($prior_terms && count($terms) > 2) {
                                foreach ((array)$prior_terms as $term_id) {
                                    $filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
                                    $_terms = wp_list_filter($terms, array($filter_field => $term_id));

                                    if ($_terms) {
                                        $term = array_shift($_terms);
                                        break;
                                    }
                                }
                            } else
                                $term = array_shift($terms);

                            break;
                        }
                    }
                }

                if (isset($save_post)) $post = $save_post; // вернем обратно (для вложений)
            }

            // вывод

            // все виды записей с терминами или термины
            if ($term && isset($term->term_id)) {
                $term = apply_filters('kama_breadcrumbs_term', $term);

                // attachment
                if (is_attachment()) {
                    if (!$post->post_parent)
                        $out = sprintf($loc->attachment, esc_html($post->post_title));
                    else {
                        if (!$out = apply_filters('attachment_tax_crumbs', '', $term, $this)) {
                            $_crumbs = $this->_tax_crumbs($term, 'self');
                            $parent_tit = sprintf($linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent));
                            $_out = implode($sep, array($_crumbs, $parent_tit));
                            $out = $this->_add_title($_out, $post);
                        }
                    }
                } elseif ($term->taxonomy == 'servicecat') {

                    if (!$out = apply_filters('post_tax_crumbs', '', $term, $this)) {
                        global $blog_id;
                        $current_blog_details = get_blog_details(array('blog_id' => $blog_id));
                        $_crumbs = $this->_tax_crumbs($term, 'self');
                        $out = $current_blog_details->blogname . ' > ' . $this->_add_title($_crumbs, $post);
                    }
                    //print_r($out);
                } // single
                elseif (is_single()) {
                    if (!$out = apply_filters('post_tax_crumbs', '', $term, $this)) {
                        $_crumbs = $this->_tax_crumbs($term, 'self');
                        $out = $this->_add_title($_crumbs, $post);
                    }
                } // не древовидная такса (метки)
                elseif (!is_taxonomy_hierarchical($term->taxonomy)) {
                    // метка
                    if (is_tag())
                        $out = $this->_add_title('', $term, sprintf($loc->tag, esc_html($term->name)));
                    // такса
                    elseif (is_tax()) {
                        $post_label = $ptype->labels->name;
                        $tax_label = $GLOBALS['wp_taxonomies'][$term->taxonomy]->labels->name;
                        $out = $this->_add_title('', $term, sprintf($loc->tax_tag, $post_label, $tax_label, esc_html($term->name)));
                    }
                } // древовидная такса (рибрики)
                else {
                    if (!$out = apply_filters('term_tax_crumbs', '', $term, $this)) {
                        $_crumbs = $this->_tax_crumbs($term, 'parent');
                        $out = $this->_add_title($_crumbs, $term, esc_html($term->name));
                    }
                }
            } // влоежния от записи без терминов
            elseif (is_attachment()) {
                $parent = get_post($post->post_parent);
                $parent_link = sprintf($linkpatt, get_permalink($parent), esc_html($parent->post_title));
                $_out = $parent_link;

                // вложение от записи древовидного типа записи
                if (is_post_type_hierarchical($parent->post_type)) {
                    $parent_crumbs = $this->_page_crumbs($parent);
                    $_out = implode($sep, array($parent_crumbs, $parent_link));
                }

                $out = $this->_add_title($_out, $post);
            } // записи без терминов
            elseif (is_singular()) {
                $out = $this->_add_title('', $post);
            }
        }

        // замена ссылки на архивную страницу для типа записи
        $home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype);

        if ('' === $home_after) {
            // Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
            if ($ptype && $ptype->has_archive && !in_array($ptype->name, array('post', 'page', 'attachment'))
                && (is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)))
            ) {
                $pt_title = $ptype->labels->name;

                // первая страница архива типа записи
                if (is_post_type_archive() && !$paged_num)
                    $home_after = sprintf($this->arg->title_patt, $pt_title);
                // singular, paged post_type_archive, tax
                else {
                    $home_after = sprintf($linkpatt, get_post_type_archive_link($ptype->name), $pt_title);

                    $home_after .= (($paged_num && !is_tax()) ? $pg_end : $sep); // пагинация
                }
            }
        }

        if(get_current_blog_id() == 1){
            $before_out = sprintf($linkpatt, home_url(), $loc->home) . ($home_after ? $sep . $home_after : ($out ? $sep : ''));
        } elseif(get_current_blog_id() != 1 && (is_singular( 'service') || is_tax('servicecat')) ) {
            $before_out = sprintf($linkpatt, home_url(), $loc->home) . ($home_after ? $sep . $home_after : ($out ? $sep : '')).'<span itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="'.$_SESSION['urlCurrentSite'].'" itemprop="item"><span itemprop="name">'.$_SESSION['currentActiveSity'].'</span></a></span><span class="sep">  >  </span>';
        }

        $out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg);

        $out = sprintf($wrappatt, $before_out . $out);

        return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg);
    }

    function _page_crumbs($post)
    {
        $parent = $post->post_parent;

        $crumbs = array();
        while ($parent) {
            $page = get_post($parent);
            $crumbs[] = sprintf($this->arg->linkpatt, get_permalink($page), esc_html($page->post_title));
            $parent = $page->post_parent;
        }

        return implode($this->arg->sep, array_reverse($crumbs));
    }

    function _tax_crumbs($term, $start_from = 'self')
    {
        $termlinks = array();
        $term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
        while ($term_id) {
            $term = get_term($term_id, $term->taxonomy);
            $termlinks[] = sprintf($this->arg->linkpatt, get_term_link($term), esc_html($term->name));
            $term_id = $term->parent;
        }

        if ($termlinks)
            return implode($this->arg->sep, array_reverse($termlinks)) /*. $this->arg->sep*/ ;
        return '';
    }

    // добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
    function _add_title($add_to, $obj, $term_title = '')
    {
        $arg = &$this->arg; // упростим...
        $title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
        $show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

        // пагинация
        if ($arg->pg_end) {
            $link = $term_title ? get_term_link($obj) : get_permalink($obj);
            $add_to .= ($add_to ? $arg->sep : '') . sprintf($arg->linkpatt, $link, $title) . $arg->pg_end;
        } // дополняем - ставим sep
        elseif ($add_to) {
            if ($show_title)
                $add_to .= $arg->sep . sprintf($arg->title_patt, $title);
            elseif ($arg->last_sep)
                $add_to .= $arg->sep;
        } // sep будет потом...
        elseif ($show_title)
            $add_to = sprintf($arg->title_patt, $title);

        return $add_to;
    }

}


if (!function_exists('my_comment')) :
    function my_comments($comment, $args, $depth)
    {
        global $commentnumber;
        $GLOBALS['comment'] = $comment;
        switch ($comment->comment_type) :
            case 'pingback' :
            case 'trackback' : ?>
                <li class="post pingback">
                    <p><?php _e('Pingback:', 'my_press'); ?><?php comment_author_link(); ?></p>
                    <?php edit_comment_link(__('Edit', 'my_press'), '<span class="edit-link">', '</span>'); ?>
                </li>
                <?php break;
            default :
                $commentnumber++; ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
                <div id="comment-<?php comment_ID(); ?>" class="comment">

                    <div class="comment-content">
                        <?
                        /* translators: 1: comment author, 2: date and time */
                        printf(__('%1$s %2$s', 'my_press'),
                            sprintf('<span class="fn">%s</span>', get_comment_author_link()),
                            sprintf('<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                esc_url(get_comment_link($comment->comment_ID)),
                                get_comment_time('c'),
                                /* translators: 1: date, 2: time */
                                sprintf(__('%1$s %2$s', 'my_press'), get_comment_date(), get_comment_time())
                            )
                        );
                        ?>
                        <?php comment_text(); ?>
                    </div>
                </div><!-- #comment-## -->
                <?php
                break;
        endswitch;
    }
endif;


function true_add_ajax_comment()
{
    global $wpdb;
    $comment_post_ID = isset($_POST['comment_post_ID']) ? (int)$_POST['comment_post_ID'] : 0;

    $post = get_post($comment_post_ID);

    if (empty($post->comment_status)) {
        do_action('comment_id_not_found', $comment_post_ID);
        exit;
    }
    $status = get_post_status($post);

    $status_obj = get_post_status_object($status);
    if (!comments_open($comment_post_ID)) {
        do_action('comment_closed', $comment_post_ID);
        wp_die(__('Sorry, comments are closed for this item.'));
    } elseif ('trash' == $status) {
        do_action('comment_on_trash', $comment_post_ID);
        exit;
    } elseif (!$status_obj->public && !$status_obj->private) {
        do_action('comment_on_draft', $comment_post_ID);
        exit;
    } elseif (post_password_required($comment_post_ID)) {
        do_action('comment_on_password_protected', $comment_post_ID);
        exit;
    } else {
        do_action('pre_comment_on_post', $comment_post_ID);
    }

    $comment_author = (isset($_POST['author'])) ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = (isset($_POST['email'])) ? trim($_POST['email']) : null;
    $comment_author_url = (isset($_POST['url'])) ? trim($_POST['url']) : null;
    $comment_content = (isset($_POST['comment'])) ? trim($_POST['comment']) : null;

    $user = wp_get_current_user();
    if ($user->exists()) {
        if (empty($user->display_name))
            $user->display_name = $user->user_login;
        $comment_author = $wpdb->escape($user->display_name);
        $comment_author_email = $wpdb->escape($user->user_email);
        $comment_author_url = $wpdb->escape($user->user_url);
        $user_ID = get_current_user_id();
        if (current_user_can('unfiltered_html')) {
            if (wp_create_nonce('unfiltered-html-comment_' . $comment_post_ID) != $_POST['_wp_unfiltered_html_comment']) {
                kses_remove_filters();
                kses_init_filters();
            }
        }
    } else {
        if (get_option('comment_registration') || 'private' == $status)
            wp_die('Вы должны зарегистрироваться или войти, чтобы оставлять комментарии.');
    }

    $comment_type = '';

    if (get_option('require_name_email') && !$user->exists()) {
        if (6 > strlen($comment_author_email) || '' == $comment_author)
            wp_die('Ошибка: заполните необходимые поля (Имя, Email).');
        elseif (!is_email($comment_author_email))
            wp_die('Ошибка: введенный вами email некорректный.');
    }

    if ('' == trim($comment_content) || '<p><br></p>' == $comment_content)
        wp_die('Вы забыли про комментарий.');


    $comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');
    $comment_id = wp_new_comment($commentdata);
    $comment = get_comment($comment_id);

    do_action('set_comment_cookies', $comment, $user);

    $comment_depth = 1;
    while ($comment_parent) {
        $comment_depth++;
        $parent_comment = get_comment($comment_parent);
        $comment_parent = $parent_comment->comment_parent;
    }

    $GLOBALS['comment'] = $comment;
    $GLOBALS['comment_depth'] = $comment_depth;

    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
                <?php echo get_avatar($comment, 40); ?>
                <cite class="fn"><?php echo get_comment_author_link(); ?></cite>
            </div>
            <?php if ($comment->comment_approved == '0') : ?>
                <em class="comment-awaiting-moderation">Комментарий отправлен на проверку</em>
                <br/>
            <?php endif; ?>
            <div class="comment-meta commentmetadata"><a
                        href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                    <?php printf('%1$s в %2$s', get_comment_date(), get_comment_time()); ?></a><?php edit_comment_link('ред.', ' '); ?>
            </div>
            <div class="comment-body"><?php comment_text(); ?></div>
        </div>
    </li>
    <?php
    die();
}

add_action('wp_ajax_ajaxcomments', 'true_add_ajax_comment');


if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Основные настройки',
        'menu_title' => 'Настройки темы',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}
add_action('wp_ajax_nopriv_ajaxcomments', 'true_add_ajax_comment');


add_shortcode('sity', 'pad_embed_shortcode');
function pad_embed_shortcode($atts)
{
    extract(shortcode_atts(array(
        'pad' => ''
    ), $atts));

    ob_start();

    $args = array(
        'post_type' => 'sklonenie',
        'meta_query' => array(
            array(
                'key' => 'wpcf-pad',
                'value' => $pad,
                'compare' => '='
            )
        )
    );
    query_posts($args); ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_title(); ?>
<?php endwhile; endif; ?>
    <?php wp_reset_query();

    return ob_get_clean();
}

function dump_log($text)
{
    $file = 'filter.log';
    $text .= "\n";
    file_put_contents(dirname(__FILE__) . '/logs/' . $file, $text, FILE_APPEND | LOCK_EX);
}

function selectprice_acf_format_value($value, $post_id, $field)
{

    dump_log($value);

    return $value;
}

add_filter('acf/format_value/type=select', 'selectprice_acf_format_value', 10, 3);


function my_acf_format_value($value, $post_id, $field)
{
    dump_log('post_id == ' . $post_id);
    dump_log('field == ' . implode(';', $field));
    dump_log($value);
    // Render shortcodes in all textarea values.
    return do_shortcode($value);
}

// Apply to all fields.
add_filter('acf/format_value/name=serv_price_price', 'my_acf_format_value', 10, 3);


function save_posted_data($posted_data)
{
    /*$wpcf7 = WPCF7_ContactForm::get_current();

    $form_id = $wpcf7->id();*/

    if (WPCF7_ContactForm::get_current()->id() === 1575) {
        $args = array(
            'post_type' => 'post',
            'post_status' => 'draft',
            'category_name' => 'otzyvy',
            'post_title' => $posted_data['your-name'],
            'post_content' => $posted_data['textarea-737'],
        );
        $post_id = wp_insert_post($args);

        if (!is_wp_error($post_id)) {

            $today = date("d/m/Y");
            update_field('field_6122974394274', $today, $post_id);

            if (isset($posted_data['your-name'])) {
                update_post_meta($post_id, 'your-name', $posted_data['your-name']);
                update_field('field_6122954dde41b', $posted_data['your-name'], $post_id);
            }
            if (isset($posted_data['starrating-253'])) {
                update_field('field_6122958ede41d', $posted_data['starrating-253'], $post_id);
            }
            if (isset($posted_data['textarea-737'])) {
                update_post_meta($post_id, 'textarea-737', $posted_data['textarea-737']);
                update_field('field_6122956ade41c', $posted_data['textarea-737'], $post_id);
            }
            wp_set_object_terms($post_id, 20, 'category');
            return $posted_data;
        }
    } else {
        return $posted_data;
    }
}

add_filter('wpcf7_posted_data', 'save_posted_data');