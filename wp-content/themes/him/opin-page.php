<?php
/*
Template Name: Отзывы
*/
?>
<?php get_header(); ?>
<div class="opin">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="s7">
        <div class="wrapper">
            <h1 style="margin-bottom: 30px;">Отзывы</h1>
            <div class="s7_items">
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op1.jpg);">
                    <a href="https://youtu.be/7AkbUfZjS5k" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op2.jpg);">
                    <a href="https://youtu.be/7AkbUfZjS5k" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op3.jpg);">
                    <a href="img/op3.jpg" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play" style="display: none;">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op4.jpg);">
                    <a href="https://youtu.be/7AkbUfZjS5k" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op5.jpg);">
                    <a href="https://youtu.be/7AkbUfZjS5k" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op6.jpg);">
                    <a href="img/op6.jpg" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play" style="display: none;">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op7.jpg);">
                    <a href="https://youtu.be/7AkbUfZjS5k" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
                <div class="s7_item" style="background: url(/wp-content/themes/him/img/op8.jpg);">
                    <a href="https://youtu.be/7AkbUfZjS5k" class="s7_item_btn" data-fancybox="gallery_opin">
                        <div class="s7_item_btn_play">
                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                        </div>
                    </a>
                </div>
            </div>
            <div class="s2_btns">
                <a href="#" class="to_call btn_click_custom"><span>Показать еще</span></a>
                <a href="#modal_order" class="to_calc open_modal btn_click_custom"><span>Оставить заявку</span></a>
            </div>
        </div>
    </div>
    <div class="s10 section">
        <div class="wrapper">
            <img class="sh10" src="/wp-content/themes/him/img/s10_img.png" alt="sheet">
            <h2 class="title"><?php the_field('bottom_desc_title', 'option'); ?></h2>
            <div class="s10_content" style="text-align: center;">
                <?php the_field('bottom_desc_text', 'option'); ?>
            </div>
        </div>
    </div>
    </div>
<?php get_footer(); ?>
