<?php
/*
Template Name: Калькулятор
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
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="contact_subtitle" style="margin-top: 20px;">
            <?php the_content(); ?>
        </div>
        <?php endwhile; ?>
		<div class="calculator_items_wrapper">
			<div class="service_price_items_title">Что вам нужно почистить?</div>
			<div class="calculator_items">
				<?php
					$calcs_query = new WP_Query(); 
					$calcs_query->query(
						array(
							'posts_per_page' => -1, 
							'post_type' => 'calcs_items'
						)
					); 
					while ($calcs_query->have_posts()) : $calcs_query->the_post(); 
				?>
				<div class="col">
					<div class="item">
						<a href="#<?php the_field('calc_link'); ?> " class="open_modal btn_click_custom">
						    <div class="item_inside">
    							<div class="item_image"><span><img src="<?php the_post_thumbnail_url(); ?>" alt=""/></span></div>
    							<div class="item_title"><?php the_title(); ?></div>
    						</div>
						</a>
						<div class="item_overflow">
							<div class="item_btn s4_btn"><a href="#<?php the_field('calc_link'); ?>" class="open_modal btn_click_custom"><span>Выбрать</span></a></div>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
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
