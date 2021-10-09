<?php
/*
Template Name: До/После
*/
?>
<?php get_header(); ?>
<div class="opin before__page">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="s7 section">
        <div class="wrapper">
            <h1 style="margin-bottom: 30px;">До\после</h1>
<?php 
if( have_rows('bef_link') ):
?>
            <div class="s7_items">
<?php while( have_rows('bef_link') ): the_row(); 
    $bef_link_img = get_sub_field('bef_link_img');
?>
                <div class="s7_item" style="background: url(<?php echo $bef_link_img['url']; ?>);">
                    <a href="<?php echo $bef_link_img['url']; ?>" class="s7_item_btn" data-fancybox="gallery_opin">
                    </a>
                </div>
<?php endwhile; ?>
        </div> 
        <?php endif; ?>
            <div class="s2_btns">
                <!--<a href="#" class="to_call">Показать еще</a>-->
                <a href="#modal_order" class="to_calc open_modal btn_click_custom"><span>Оставить заявку</span></a>
            </div>
        </div>
    </div>
    <div class="s8 section">
        <div class="wrapper">
            <h2 class="title">Часто задаваемые вопросы</h2>
            <div class="s8_items">
<?php while( have_rows('quest', 'option') ): the_row(); 
    $quest1 = get_sub_field('quest1');
    $quest2 = get_sub_field('quest2');
?>
                <div class="s8_item">
                    <div class="s8_item_title">
                        <div class="s8_item_title_icon">
                            ?
                        </div>
                        <div class="s8_item_title_arrow">
                            <img src="/wp-content/themes/him/img/arrow_down2.svg" alt="arrow">
                        </div>
                        <p><?php echo $quest1; ?></p>
                    </div>
                    <div class="s8_item_desc">
                        <?php echo $quest2; ?>
                    </div>
                </div>
<?php endwhile; ?>
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
