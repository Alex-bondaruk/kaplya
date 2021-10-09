<?php
/*
Template Name: Место химчистки
*/
?>
<?php get_header(); ?>
<div class="org service forg__page">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="wrapper">
        <h1><?php the_title(); ?></h1>
        <div class="service_items service_cols">
            <div class="service_items_left">
                <div class="service_thumb" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>);">
                    
                </div>
            </div>
            <div class="service_items_right">
                <div class="content">
                    <?php the_field('org_subtitle'); ?>
                </div>
            </div>
        </div>
        <div class="org_banner">
            <div class="org_banner_left">
                <div class="org_banner_title content">
                    Перед заключением договора мы можем приехать на пробную чистку 1 предмета <span>бесплатно</span>
                </div>
                <div class="org_banner_subtitle">
                    чтобы вы могли увидеть качество нашей работы и принять решение о целесообразности чистки.
                </div>
            </div>
            <div class="org_banner_right">
                <a href="#modal_order" class="org_banner_btn open_modal btn_click_custom"><span>Оставить заявку</span></a>
            </div>
        </div>
        <div class="org_how">
            <h2 class="title">Как мы работаем</h2>
            <div class="org_how_items">
                <div class="org_how_item">
                    <div class="org_how_item_img">
                        <img src="/wp-content/themes/him/img/org_ico1.png" alt="icon">
                    </div>
                    <div class="org_how_item_title">
                        Выезжаем на оценку или рассчитываем стоимость дистанционно
                    </div>
                </div>
                <div class="org_how_item">
                    <div class="org_how_item_img">
                        <img src="/wp-content/themes/him/img/org_ico2.png" alt="icon">
                    </div>
                    <div class="org_how_item_title">
                        Выставляем счет на оплату и составляем договор
                    </div>
                </div>
                <div class="org_how_item">
                    <div class="org_how_item_img">
                        <img src="/wp-content/themes/him/img/org_ico3.png" alt="icon">
                    </div>
                    <div class="org_how_item_title">
                        Приезжаем в назначенное время и оказываем услугу
                    </div>
                </div>
                <div class="org_how_item">
                    <div class="org_how_item_img">
                        <img src="/wp-content/themes/him/img/org_ico4.png" alt="icon">
                    </div>
                    <div class="org_how_item_title">
                        Подписываем акт выполненных работ
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="s4 section" style="background: #fff;padding: 50px 0;">
        <div class="wrapper">
            <h2 class="title"><?php the_field('before_title', 'option'); ?></h2>
            <div class="before_slider">
<?php while( have_rows('befaft_sl', 'option') ): the_row(); 
    $befaft_sl1 = get_sub_field('befaft_sl1');
    $befaft_sl2 = get_sub_field('befaft_sl2');
?>
                <div class="before_item_wr">
                  <div class="before_item before-after">
					<img src="<?php echo $befaft_sl1['url']; ?>" alt=""/>
					<img src="<?php echo $befaft_sl2['url']; ?>" alt=""/>
                  </div>
                </div>
<?php endwhile; ?>
            </div>
			<div class="s4_btn">
				<a href="<?php echo get_home_url(); ?>/do-posle" class="btn_click_custom"><span>Смотреть все работы</span></a>
			</div>
        </div>
    </div>
    <div class="s3 section">
        <div class="wrapper">
            <h2 class="title"><?php the_field('org_s5_title'); ?></h2>
<?php 
if( have_rows('org_s3_item') ):
?>
            <div class="s3_items">
<?php while( have_rows('org_s3_item') ): the_row(); 
    $org_s3_item_ico = get_sub_field('org_s3_item_ico');
    $org_s3_item_title = get_sub_field('org_s3_item_title');
    $org_s3_item_desc = get_sub_field('org_s3_item_desc');
?>
                <div class="s3_item">
                    <div class="s3_item_wr">
                        <div class="s3_item_img">
                            <img src="<?php echo $org_s3_item_ico['url']; ?>" alt="icon">
                        </div>
                        <div class="s3_item_title">
                            <?php echo $org_s3_item_title; ?>
                        </div>
                        <div class="s3_item_desc">
                            <?php echo $org_s3_item_desc; ?>
                        </div>
                    </div>
                </div>
<?php endwhile; ?>
        </div> 
        <?php endif; ?> 
        </div>
    </div>
    <div class="s2 section mobnone" style="padding: 50px 0;">
        <div class="wrapper">
            <h2 class="title">Мы оказываем услуги по очистке</h2>
            <div class="subtitle">Выберите что вам необходимо почистить</div>
            <div class="s2_items">
<?php
$_terms = get_terms( array(
    'parent' => 0,
    'taxonomy'     => 'servicecat',
    'orderby'      => 'name',
    'order'        => 'DESC',
) );

foreach ($_terms as $term) :
    $term_slug = $term->slug;
?>
                <div class="s2_item">
                    <a href="<?php echo get_term_link($term->slug, 'servicecat'); ?>" class="s2_item_link"></a>
                    <div class="s_item_img">
                        <img src="<?php echo z_taxonomy_image_url($term->term_id, 'thumbnail'); ?>" alt="">
                    </div>
                    <div class="s_item_title">
                        <?php echo $term->name; ?>
                    </div>
                </div>
<?php endforeach; ?>
            </div>
			<div class="s2_btns">
				<a href="<?php echo get_home_url(); ?>/service" class="to_call btn_click_custom"><em>посмотреть все услуги</em></a>
				<a href="<?php echo get_home_url(); ?>/calculator" class="to_calc btn_click_custom"><em><span><img class="img_svg" src="/wp-content/themes/him/img/to_calc.svg" alt="icon"></span>Калькулятор стоимости</em></a>
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
</div>
<?php get_footer(); ?>
