<?php
/*
Template Name: Цены
*/
?>
<?php get_header(); ?>
<div class="price service">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="wrapper">
        <h1><?php the_title(); ?></h1>
        <div class="contact_subtitle" style="margin-top: 20px;">
            <?php the_field('price_subtitle'); ?>
        </div>
        <div class="service_price section">
<?php 
if( have_rows('price_bl') ):
?>
<?php while( have_rows('price_bl') ): the_row(); 
    $price_bl_title = get_sub_field('price_bl_title');
    $price_bl_item = get_sub_field('price_bl_item');
?>
<div class="service_price_items_title"><?php echo $price_bl_title; ?></div>
<?php 
if( have_rows('price_bl_item') ):
?>
                <div class="service_price_items">
<?php while( have_rows('price_bl_item') ): the_row(); 
    $price_bl_item_img = get_sub_field('price_bl_item_img');
    $price_bl_item_title = get_sub_field('price_bl_item_title');
    $price_bl_item_desc = get_sub_field('price_bl_item_desc');
    $price_bl_item_price = get_sub_field('price_bl_item_price');
?>
<? if($price_bl_title == 'Подарочные сертификаты'){ ?> 
                    <div class="service_price_item">
						<a href="#modal_newza" class="open_modal"></a>
                        <div class="service_price_item_img">
                            <img src="<?php echo $price_bl_item_img['url']; ?>" alt="icon">
                        </div>
                        <div class="service_price_item_title">
                            <?php echo $price_bl_item_title; ?>
                        </div>
                        <div class="service_price_item_subtitle">
							<?php if($price_bl_item_desc != '') { ?>
                            <?php echo $price_bl_item_desc; ?>
							<?php } else { echo '&nbsp;'; } ?>
                        </div>
                        <div class="service_price_item_price">
                            <?php echo $price_bl_item_price; ?>
                        </div>
                    </div>
<? }else{ ?>
                    <div class="service_price_item">
						<a href="#modal_ech" class="open_modal"></a>
                        <div class="service_price_item_img">
                            <img src="<?php echo $price_bl_item_img['url']; ?>" alt="icon">
                        </div>
                        <div class="service_price_item_title">
                            <?php echo $price_bl_item_title; ?>
                        </div>
                        <div class="service_price_item_subtitle">
							<?php if($price_bl_item_desc != '') { ?>
                            <?php echo $price_bl_item_desc; ?>
							<?php } else { echo '&nbsp;'; } ?>
                        </div>
                        <div class="service_price_item_price">
                            <?php echo $price_bl_item_price; ?>
                        </div>
                    </div>	
<? }?>

<?php endwhile; ?>
                </div>
<?php endif; ?> 
<?php endwhile; ?>
<?php endif; ?> 
            </div>
            <div class="s1_left_btns">
            	<a href="#modal_order" class="to_call btn_click_custom open_modal"><em>Заказать химчистку</em></a>
                <a href="<?php echo get_home_url(); ?>/calculator" class="to_calc"><em><span><img class="img_svg" src="/wp-content/themes/him/img/to_calc.svg" alt="icon"></span>Калькулятор стоимости</em></a>
            </div>
    </div>
    <?php 
if( have_rows('quest', 'option') ):
?>
    <div class="s8 section" style="margin-top: 100px;">
        <img class="sh8" src="/wp-content/themes/him/img/l8.svg" alt="sheet">
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
<?php endif; ?>
</div>
<?php get_footer(); ?>
