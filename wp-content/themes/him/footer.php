<footer>
<?php wp_footer(); ?> 
  <div class="up_btn">
    <div class="up_btn_icon">
      <img src="/wp-content/themes/him/img/up.svg" alt="arrow">
    </div>
    <div class="up_btn_txt">
      наверх
    </div>
  </div>
        <div class="footer_row1">
            <div class="wrapper">
                <div class="footer_row1_items">
                    <div class="footer_logo">
<?php 
$logo = get_field('logo', 'option');
if( !empty($logo) ): ?>
                        <a href="<?php echo get_home_url(); ?>"><img src="<?php echo $logo['url']; ?>" alt="logo"></a>
<?php endif; ?>
                    </div>
                    <div class="footer_menu_wrapper">
						<div class="footer_menu_inside">
							<div class="col col1">
								<?php wp_nav_menu(array( 'theme_location' => 'primary', 'menu_class' => 'menu', 'theme_location' => 'foot_menu_1', 'container' => false )); ?>
							</div>
							<div class="col col2">
								<?php wp_nav_menu(array( 'theme_location' => 'primary', 'menu_class' => 'menu', 'theme_location' => 'foot_menu_2', 'container' => false )); ?>
							</div>
							<div class="col col3">
								<?php wp_nav_menu(array( 'theme_location' => 'primary', 'menu_class' => 'menu', 'theme_location' => 'foot_menu_3', 'container' => false )); ?>
							</div>
						</div>
                    </div>
                    <div class="footer_info_wrapper">
						<div class="footer_info_inside">
							<div class="footer_phone">
								<a href="tel:<?php the_field('phone_link', 'option'); ?>"><?php the_field('phone', 'option'); ?><span> <?php the_field('phone1', 'option'); ?></span></a>
								<p>E-mail: <?php the_field('email', 'option'); ?></p>
							</div>
							<div class="footer_social">
								<a target="_blank" href="<?php the_field('youtube', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/youtube.svg" alt="youtube"></a>
								<a target="_blank" href="<?php the_field('vk', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/vk.svg" alt="vk"></a>
							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_row2">
            <div class="wrapper">
                <div class="footer_row2_items">
                    <div class="footer_row2_item1">
                        <?php echo date('Y'); ?> © Все права защищены
                    </div>
                    <div class="footer_row2_item2">
                        <div class="footer_row2_item2_item"><a href="<?php echo get_home_url(); ?>/privacy-policy">Политика конфиденциальности</a></div>
                        <div class="footer_row2_item2_item"><a href="https://franshiza-kaplya.ru/" target="_blank">Франшиза</a></div>
                        <div class="footer_row2_item2_item"><a href="#modal_testim" class="open_modal">Оставить отзыв о нас</a></div>
                    </div>
                    <div class="footer_row2_item3">
                        <div class="stars">
                            <?php
                            $currentRatingAll = null;
                            $countStarsAll = null;
                            switch_to_blog(1);
                            $argsText = array(
                                'posts_per_page' => -1,
                                'category_name' => 'otzyvy',
                                'meta_query' => array(
                                    array(
                                        'key' => 'otz_video_true',
                                        'value' => '0',
                                    )
                                )
                            );
                            $queryText = new WP_Query($argsText);
                            ?>
                            <?php
                            $arFieldsStarsArr = [];
                            while ($queryText->have_posts()) : $queryText->the_post(); ?>
                                <?php
                                    $starsInt = intval(get_field('star_rating'));
                                    $arFieldsStarsArr[] = $starsInt;
                                ?>
                            <?php endwhile;
                            wp_reset_postdata();
                            $sumStars = array_sum($arFieldsStarsArr);
                            $countStars = count($arFieldsStarsArr);
                            $currentRating = round($sumStars / $countStars, 2);

                            $countStarsInt = intval($currentRating);
                            for ($iStars = 1; $iStars <= $countStarsInt; $iStars++) {
                                $contentStarsIcons .= '<i class="fa fa-star" aria-hidden="true"></i>';
                            }
                            if ($countStarsInt < 5) {
                                for ($jStars = 1; $jStars <= (5 - $countStarsInt); $jStars++) {
                                    $contentStarsIcons .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                }
                            }
                            $currentRatingAll = $currentRating;
                            $countStarsAll = $countStars;
                            ?>
                            <?php if(!empty($arFieldsStarsArr)):?>
                                <div class="stars_icons">
                                    <?= $contentStarsIcons; ?>
                                </div>
                                <div class="stars_text">
                                    <div class="footer_stars"><a href="/otzyvy/"><?=$currentRating;?> из 5</a> на основе</div>
                                    <div><?=$countStars;?> оценок покупателей</div>
                                </div>
                            <?php endif;
                            restore_current_blog(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</footer>
	<div class="open_cart"></div>
	<div id="overlay">
		<?php if( is_page_template( 'calc-page.php' ) ) { ?>
			<?php get_template_part( 'parts/calcs'); ?>
		<?php } ?> 
		<div class="modal_window modal_search" id="modal_search">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Поиск по сайту</div>
				<div class="modal_form">
					<form action="<?php bloginfo( 'url' ); ?>" method="get">
						<div class="modal_form_fields">
							<div class="modal_form_field">
								<input type="text" name="s" placeholder="Поиск по сайту" value="<?php if(!empty($_GET['s'])){echo $_GET['s'];}?>"/>
							</div>
						</div>
						<div class="modal_form_submit">
							<button type="submit" class="submit btn_click_custom">
								<span>Найти</span>
								<input type="submit" class="submit" value="Найти"/>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal_window modal_order" id="modal_prof">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Узнать подробнее</div>
				<div class="modal_desc">Заполните форму, и мы свяжемся с вами!</div>
				<div class="modal_form">
					<?php echo do_shortcode('[contact-form-7 id="743" title="Профилактическая чистка"]'); ?>
				</div>
			</div>
		</div>
		<div class="modal_window modal_order" id="modal_newza">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">оставить заявку</div>
				<div class="modal_desc">Заполните форму, и мы свяжемся с вами!</div>
				<div class="modal_form">
					<?php echo do_shortcode('[contact-form-7 id="819" title="Оставить заявку"]'); ?>
				</div>
			</div>
		</div>
		<div class="modal_window modal_order" id="modal_profs">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Порекомендовать другу</div>
				<div class="modal_form">
					<?php echo do_shortcode('[contact-form-7 id="797" title="Узнать подробнее"]'); ?>
				</div>
			</div>
		</div>
		<div class="modal_window modal_order" id="modal_order">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Оставить заявку</div>
				<div class="modal_desc">Заполните форму, и мы свяжемся с вами!</div>
				<div class="modal_form">
					<?php echo do_shortcode(get_field('modal_order_shortcode', 'option')); ?>
				</div>
			</div>
		</div>
		<div class="modal_window modal_order" id="modal_ruk">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Отправить сообщение руководителям</div>
				<div class="modal_form">
					<?php echo do_shortcode('[contact-form-7 id="653" title="Отправить сообщение руководителям"]'); ?>
				</div>
			</div>
		</div>
		<div class="modal_window modal_order" id="modal_ech">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Оформление заказа</div>
				<div class="modal_desc">Заполните форму, и мы свяжемся с вами!</div>
				<div class="modal_form">
					<?php echo do_shortcode('[contact-form-7 id="651" title="Оформление заказа (цены)"]'); ?>
				</div>
			</div>
		</div></div>
		<div class="modal_window modal_order" id="modal_testim">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Оставить отзыв</div>
				<div class="modal_desc">Ваш отзыв очень важен для нас</div>
				<div class="modal_form">
					<?php echo do_shortcode(get_field('modal_testim_shortcode', 'option')); ?>
				</div>
			</div>
		</div>
		<div class="modal_window modal_cities" id="select_city">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Выберите город</div>
				<div class="modal_cities_wrapper">
					<div class="mcw_inside">		
						<?php $blog_list = get_sites_alphabet(); ?>
						<div class="mcw_cols">
							<?php 
								$blocks = array_chunk($blog_list, 5);
								$i = 0;
								$wrap_count = 5;
							?>
							<?php foreach ($blog_list as $key=>$blog_items) { ?>
								<?php 
									$i++; 
									if($i % $wrap_count == 1) echo '<div class="col col-4">';
								?>
								<div class="mcw_item">
									<div class="mcw_title"><?php echo mb_strtoupper( $key, 'utf-8' ); ?></div>
									<ul>
                                        <?php
                                            $baseDomain = "https://" . $_SERVER['HTTP_HOST'];
                                            $actualSessionLink = "https://" . $_SERVER['HTTP_HOST'].$_SESSION['urlCurrentSite'];
                                            if (get_site_url() == 'https://reflection-web.ru/' ||
                                                get_site_url() == 'https://himchistka-kaplya.ru/') {
                                                $getSiteUrls = get_site_url();
                                            } else {
                                                $getSiteUrls = get_site_url() . '/';
                                            }
                                        ?>
										<?php foreach ($blog_items as $blog) { ?>
                                            <?php
                                            $actual_links = $baseDomain . $blog['blog_path'];
                                            ?>
                                                <?php
                                                if($actual_links != $getSiteUrls && $actual_links == $actualSessionLink && get_current_blog_id() != $blog['blog_id']):?>
                                                    <li class="active"><a href="<?php echo $blog['blog_path']; ?>" data-site="<?=$blog['blog_id'];?>"><?php echo $blog['blog_city']; ?></a></li>
                                               <?php elseif($actual_links == $getSiteUrls && $actual_links == $actualSessionLink && get_current_blog_id() == $blog['blog_id']):?>
                                                    <li class="active"><a href="<?php echo $blog['blog_path']; ?>" data-site="<?=$blog['blog_id'];?>"><?php echo $blog['blog_city']; ?></a></li>
                                                <?php else: ?>
                                                    <li><a href="<?php echo $blog['blog_path']; ?>" data-site="<?=$blog['blog_id'];?>"><?php echo $blog['blog_city']; ?></a></li>
                                                <?php endif; ?>
										<?php } ?>
									</ul>
								</div>
								<?php 
									if($i % $wrap_count == 0) { echo '</div>'; $i = 0; }
									//if($i % $wrap_count != 0) { echo '</div>'; $i = 0; }
								?>
							<?php } ?>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal_window modal_success" id="modal_success">
			<div class="modal_close"></div>
			<div class="modal_inside">
				<div class="modal_title">Спасибо за вашу заявку, <br>мы скоро свяжемся с вами!</div>
			</div>
		</div>
		<div class="modal_window modal_success modal_order" id="coment">
			<div class="modal_close"></div>
			<div class="modal_inside">
			<div id="respond">
				<!-- тут нужно обратить внимание также на атрибуты name -->
				<a id="cancel-comment-reply-link" style="display:none;">Отменить ответ</a>
<div class="modal_form_fields">
<?php if ( $user_ID ) : ?>
<div class="modal_title">Оставить комментарий</div>
<div class="modal_desc">Вы вошли как <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Выйти из этого аккаунта">Выйти &raquo;</a></div>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" id="commentform" method="post">
		<div class="modal_form_field">
			<textarea name="comment" id="comment" placeholder="Комментарии:" ></textarea>
		</div>

		<div class="modal_form_submit">
			<input name="submit" type="submit" id="submit" value="Отправить" class="btn_click_custom submit button"/>
		</div>
<?php comment_id_fields();
do_action('comment_form', $post->ID); ?>
</form>
<?php else : ?>
<div class="modal_title">Оставить комментарий</div>
<div class="modal_desc">Заполните форму и ваш комментарий 
появится на сайте </div>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" id="commentform" method="post">
		<div class="modal_form_field">
			<input name="author" id="author" type="text" placeholder="Ваше имя:" alt="Name"/>
		</div>
		<div class="modal_form_field">
			<input name="email" id="email" type="email" placeholder="email:" alt="Email"/>
		</div>
		<div class="modal_form_field">
			<textarea name="comment" id="comment" placeholder="Комментарии:" ></textarea>
		</div>

		<div class="modal_form_submit">
			<input name="submit" type="submit" id="submit" value="Отправить" class="btn_click_custom submit button"/>
		</div>
<?php comment_id_fields();
do_action('comment_form', $post->ID); ?>
</form>
<?php endif;?>
</div>
			</div>
			</div>
		</div>
	</div>

	<script>
		var url_ajax = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
	</script>
<?php if( is_page_template( 'calc-page.php' ) ) { ?>
	<script>
		jQuery(document).ready(function($){
			function numberFormatPrice(n) {
				n += "";
				n = new Array(4 - n.length % 3).join("U") + n;
				return n.replace(/([0-9U]{3})/g, "$1 ").replace(/U/g, "");
			}
			$(document).on('keypress keyup blur', '.cart_coupon', function(eventObject){
				var searchTerm = $(this).val();
				// проверим, если в поле ввода более 2 символов, запускаем ajax
				if(searchTerm.length >= 5){
					$.ajax({
						url : '/wp-admin/admin-ajax.php',
						type: 'POST',
						data:{
							'action':'codyshop_ajax_search',
							'term': searchTerm
						},
						success:function(result){
							if(parseFloat(result) != 0) {
								$('.jqcart-orderform-custom input[name="coupon"]').val(searchTerm);
								$('.jqcart-orderform-custom input[name="discount"]').val(parseFloat(result).toFixed(0));
								$('.jqcart_orders_coupon input').attr('data-discount', parseFloat(result).toFixed(0));
								var curPrice = parseFloat($('.jqcart_orders_result .total_price').text());
								var curPriceDis = curPrice * ((100 - parseFloat(result)) / 100);
                $('.jqcart_orders_coupon input').removeClass('invalid').addClass('valid');
								$('.jqcart_orders_result .total_price').addClass('dis');
								$('.jqcart_orders_result .price_dis').html(numberFormatPrice(curPriceDis.toFixed(0)) + ' <em>₽</em>').show();
							} else {
								$('.jqcart-orderform-custom input[name="coupon"]').val(0);
								$('.jqcart-orderform-custom input[name="discount"]').val(parseFloat(result).toFixed(0));
								$('.jqcart_orders_coupon input').attr('data-discount', 0);
								var curPrice = parseFloat($('.jqcart_orders_result .total_price').text());
								var curPriceDis = curPrice * ((100 - parseFloat(result)) / 100);
                $('.jqcart_orders_coupon input').removeClass('valid').addClass('invalid');
								$('.jqcart_orders_result .total_price').removeClass('dis');
								$('.jqcart_orders_result .price_dis').html(numberFormatPrice(curPriceDis.toFixed(0)) + ' <em>₽</em>').hide();
							}
						}
					});
				}
			});
		});
	</script>
<?php } ?>
<script src="/wp-content/themes/him/js/lvovich.sity.min.js"></script>
<script src="/wp-content/themes/him/js/jquery-3.1.1.min.js"></script>

<?php
global $post; if(  is_singular( 'service') ) :?>
    <?php
        $minPrice = [];
        while (have_rows('serv_prices_loop')): the_row(); ?>
            <?php $minPrice[] = substr(get_sub_field('serv_price_price'), 5, -3); ?>
        <?php endwhile; ?>
    <?php
        $tags = get_meta_tags(get_page_link());
    ?>
    <script type="application/ld+json">{
            "@context": "https://schema.org",
            "@type": "Product",
            "name": "<?php the_title(); ?> | Выездная химчистка Капля",
            "description": "<?php echo $tags['description']; ?>",
            "url": "<?php echo get_page_link( $post->ID );?>",
            "aggregateRating": {
                "@type": "AggregateRating",
                "bestRating": 5,
                "ratingCount": "<?php echo $countStarsAll; ?>",
                "ratingValue": "<?php echo $currentRatingAll; ?>",
            },
            "offers": {
                "@type": "AggregateOffer",
                "priceCurrency": "RUB",
                "availability": "https://schema.org/InStock",
                "lowPrice": "<?php echo min($minPrice); ?>",
                "highPrice": "<?php echo max($minPrice); ?>",
                "offerCount": "1",
                "seller": {
                    "@context": "https://schema.org",
                    "@type": "Organization",
                    "name": "Химчистка Капля",
                    "description": "Химчистка мягкой мебели и ковров",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "https://himchistka-kaplya.ru/wp-content/uploads/2020/10/logo2-1.svg"
                    },
                    "email": "info@himchistka-kaplya.ru",
                    "address": {
                        "@type": "PostalAddress",
                        "addressCountry": "Россия",
                        "addressLocality": "<?php if(isset($_SESSION['currentActiveSity']) && !empty($_SESSION['currentActiveSity'])){
                                    echo 'г.'. $_SESSION['currentActiveSity'];
                                } else {
                                    echo 'г.'. get_option( 'options_city_for_list' );
                                } ?>",
                        "streetAddress": "ул. тут надо адрес написать"
                    },
                    "contactPoint": {
                        "@type": "ContactPoint",
                        "contactType": "customer support",
                        "telephone": "<?php the_field('phone', 'option'); ?>",
                        "email": "info@himchistka-kaplya.ru",
                        "productSupported": "Сервис himchistka-kaplya.ru",
                        "areaServed": "Россия",
                        "availableLanguage": "русский",
                        "contactOption": "TollFree"
                    }
                }
            }
        }
    </script>
<?php endif; ?>


<?php if(is_page_template('about-page.php')) { ?>

	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZuJpH6NhINA_CW547PwgVDvq_gUImL20"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript">
		const createHTMLMapMarker = ({
		  OverlayView = google.maps.OverlayView,
		  ...args
		}) => {
		  class HTMLMapMarker extends OverlayView {
		    constructor() {
		      super();
		      this.latlng = args.latlng;
		      this.html = args.html;
		      this.setMap(args.map);
		    }

		    createDiv() {
		      this.div = document.createElement("div");
		      this.div.style.position = "absolute";
		      if (this.html) {
		        this.div.innerHTML = this.html;
		      }
		      google.maps.event.addDomListener(this.div, "click", event => {
		        google.maps.event.trigger(this, "click");
		      });
		    }

		    appendDivToOverlay() {
		      const panes = this.getPanes();
		      panes.overlayImage.appendChild(this.div);
		    }

		    positionDiv() {
		      const point = this.getProjection().fromLatLngToDivPixel(this.latlng);
		      let offset = 25;
		      if (point) {
		        this.div.style.left = `${point.x - offset}px`;
		        this.div.style.top = `${point.y - offset}px`;
		      }
		    }

		    draw() {
		      if (!this.div) {
		        this.createDiv();
		        this.appendDivToOverlay();
		      }
		      this.positionDiv();
		    }

		    remove() {
		      if (this.div) {
		        this.div.parentNode.removeChild(this.div);
		        this.div = null;
		      }
		    }

		    getPosition() {
		      return this.latlng;
		    }

		    getDraggable() {
		      return false;
		    }
		  }

		  return new HTMLMapMarker();
		};

		google.maps.event.addDomListener(window, 'load', init);

		var iconTxt = $('.footer_map').attr('data-icon-txt');

		function init() {
			<?php while ( have_posts() ) : the_post(); ?>
			const latLng = new google.maps.LatLng(<?php the_field('map_coords'); ?>);

			var mapOptions = {
				zoom: 4,
				scrollwheel: false,
				disableDefaultUI: true,
				zoomControl: true,
				center: latLng,

				 styles: [{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#d3d3d3"}]},{"featureType":"transit","stylers":[{"color":"#808080"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#b3b3b3"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"weight":1.8}]},{"featureType":"road.local","elementType":"geometry.stroke","stylers":[{"color":"#d7d7d7"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#ebebeb"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#a7a7a7"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#efefef"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#696969"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"visibility":"on"},{"color":"#737373"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry.stroke","stylers":[{"color":"#d6d6d6"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"color":"#dadada"}]}]
			};

			var mapElement = document.getElementById('map_about');

			var map = new google.maps.Map(mapElement, mapOptions);

			<?php if( have_rows('maps_items_coords') ) { ?>
				<?php $i = 1; while( have_rows('maps_items_coords') ): the_row(); ?>

					const latLng_<?php echo $i; ?> = new google.maps.LatLng(<?php the_sub_field('maps_item_coords'); ?>);
					let markerNew_<?php echo $i; ?> = createHTMLMapMarker({
					  latlng: latLng_<?php echo $i; ?>,
					  map: map,
					  html: '<div class="placemark_layout_container"><div class="circle_wrapper"><div class="circle_layout"><svg width="16" height="26" viewBox="0 0 16 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 0.1875C3.6875 0.1875 0.1875 3.6875 0.1875 8C0.1875 12.3125 7 20.0117 7 25.8125H9C9 20.0273 15.8125 11.9648 15.8125 8C15.8125 3.6875 12.3125 0.1875 8 0.1875ZM8 11.2031C6.23047 11.2031 4.79688 9.76562 4.79688 8C4.79688 6.23438 6.23047 4.79688 8 4.79688C9.76953 4.79688 11.2031 6.23047 11.2031 8C11.2031 9.76953 9.76953 11.2031 8 11.2031Z" fill="#E23936"/></svg></div></div></div>'
					});
				<?php $i++; endwhile; ?>
			<?php } ?>
			<?php endwhile; ?>

		}
	</script>
<?php } ?>
<script src="/wp-content/themes/him/js/jquery.event.move.js"></script>   
<script src="/wp-content/themes/him/slick/slick.min.js"></script> 
<script src="/wp-content/themes/him/js/jquery.fancybox.min.js"></script>  
<script src="/wp-content/themes/him/js/jquery.twentytwenty.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="/wp-content/themes/him/js/jqcart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>
<script src="/wp-content/themes/him/js/lity.min.js"></script>
<script src="/wp-content/themes/him/js/js.js"></script>
<div class="popup popup1">
  <div class="close1"  id="pauseYoutube1"></div>
  <div class="popup-block">
    <div class="close2"  id="pauseYoutube2"><i class="fa fa-times-circle" aria-hidden="true"></i></div> 
    <div class="popup_video_wr"> 
		<div id="play"></div>
		<script src="//www.youtube.com/player_api"></script>
		<script>
			
			function onYouTubePlayerAPIReady() {
			var play;
			  play = new YT.Player('play', {
				videoId: '7AkbUfZjS5k',
				playerVars: { 'autoplay': 0},
			  });
				document.getElementById('pauseYoutube1').onclick = function() {play.pauseVideo();};
				document.getElementById('pauseYoutube2').onclick = function() {play.pauseVideo();};
			}		
		</script>
	</div>
  </div>
</div>

<script type="text/javascript">
  $(".btn_popup").click(function(){
      $(".popup1").css("display", "block");
  });
  $(".close1").click(function(){
      $(".popup1").css("display", "none");
  });
  $(".close2").click(function(){
      $(".popup1").css("display", "none");
  }); 
  $(".popup_btn").click(function(){
      $(".popup-block1").css("display", "none");
  }); 
   $("i.fa.fa-times-circle").click(function(){
	  $("div#overlay").css("display", "none");
  });
	$('form.wpcf7-form input[type="checkbox"]').prop('checked', true);
</script>
<?php
   /* Всегда используйте wp_footer() перед закрывающим тегом </body>
	* иначе множество плагинов не будут работать корректно, потому что
	* они используют этот хук для вставки различных JS и других кодов.
	*/

	
  wp_footer();
?>
</body>
    </html>
