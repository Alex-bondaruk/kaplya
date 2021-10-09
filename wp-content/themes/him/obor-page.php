<?php
/*
Template Name: Оборудование
*/
?>
<?php get_header(); ?>
<div class="org service obor">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="wrapper">
        <h1 class="title_page"><?php the_title(); ?></h1>
        <div class="contact_subtitle content" style="margin-top: 20px;">
            <?php the_field('obor_subtitle'); ?>
        </div>
        <?php if( have_rows('obor_loop') ) { ?>
			<div class="obor_wrapper">
				<div class="obor_row">
					<?php while( have_rows('obor_loop') ): the_row();  ?>
						<div class="col">
							<div class="item">
								<div class="item_image"><span><img src="<?php echo wp_get_attachment_image_url( get_sub_field('obor_item_img'), 'full'); ?>" alt=""/></span></div>
								<div class="item_title"><?php the_sub_field('obor_item_title'); ?></div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="obor_desc"><?php the_field('obor_desc'); ?></div>
			</div>
        <?php } ?>
    </div>
    <div class="s2 section" style="padding: 50px 0;">
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
</div>
<?php get_footer(); ?>
