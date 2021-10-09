<?php
/*
Template Name: Профилактическая чистка
*/
?>
<?php get_header(); ?>
<div class="org service forg__page prof__page">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="wrapper">
        <h1><?php the_title(); ?></h1>
        <div class="contact_subtitle content" style="margin-top: 20px;">
            <?php the_field('org_smalldesc'); ?>
        </div>
        <div class="service_items service_cols">
            <div class="service_items_left">
                <div class="service_thumb" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>);">
                    
                </div>
            </div>
            <div class="service_items_right">
                <div class="content">
                    <?php the_field('org_subtitle'); ?>
                </div>
				<div class="service_items_btn">
					<a href="#modal_prof" class="to_calc open_modal btn_click_custom">УЗНАТЬ ПОДРОБНЕЕ</a>
				</div>
            </div>
        </div>
    </div>
	<?php if( have_rows('preim_loop') ): ?>
	<div class="prof_clean_bk">
		<div class="wrapper">
            <h2 class="title"><?php the_field('preim_title'); ?></h2>
			<div class="prof_cols d_flex j_content_center f_wrap">
				<?php while( have_rows('preim_loop') ): the_row(); ?>
					<div class="col">
						<div class="item">
							<div class="item_image"><span><img src="<?php the_sub_field('preim_item_image'); ?>" alt=""/></span></div>
							<div class="item_title"><?php the_sub_field('preim_item_title'); ?></div>
							<div class="item_desc"><?php the_sub_field('preim_item_desc'); ?></div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php if( have_rows('dog_loop') ): ?>
	<div class="dog_prof_clean">
        <div class="wrapper">
            <h2 class="title"><?php the_field('dog_title'); ?></h2>
            <div class="subtitle"><?php the_field('dog_desc'); ?></div>
			<div class="dog_prof_cols d_flex j_content_center f_wrap">
				<?php while( have_rows('dog_loop') ): the_row(); ?>
					<div class="col">
						<div class="item">
							<div class="item_image"><span><img src="<?php the_sub_field('dog_item_image'); ?>" alt=""/></span></div>
							<div class="item_title"><?php the_sub_field('dog_item_desc'); ?></div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<div class="prof_desc">
		<div class="wrapper">
			<div class="prof_desc_cols d_flex a_items_center f_wrap">
				<div class="col">
					<div class="prof_desc--desc"><?php the_field('bk_4_desc'); ?></div>
				</div>
				<div class="col">
					<div class="prof_desc--image"><img src="<?php the_field('bk_4_image'); ?>" alt=""/></div>
				</div>
			</div>
			<div class="prof_desc_btn">
				<a  href="#modal_prof" class="to_calc open_modal btn_click_custom">УЗНАТЬ ПОДРОБНЕЕ
ПРО ПРОФИЛАКТИЧЕСКУЮ ЧИСТКУ</a>
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
	<?php if( get_field('main_op_display') ): ?>
		<div class="s7 section">
			<div class="wrapper">
				<h2 class="title">Отзывы о нашей работе</h2>
				<div class="s7_items">
	<?php 
	if( have_rows('main_op_item') ):
	?>      
	<?php $main_otz_id = 0; ?>          
	<?php while( have_rows('main_op_item') ): the_row(); 
		$main_op_item_link = get_sub_field('main_op_item_link');
		$post = $main_op_item;
		setup_postdata( $post ); 
		$main_otz_id++;
		if( $main_op_item_link ): 
		$post = $main_op_item_link;
		setup_postdata( $post );
		$otz_link = get_field('otz_link');
	?>
					<div class="s7_item" style="background: url(<?php the_post_thumbnail_url('full'); ?>);">
						<a class="s7_item_btn btn_otz<?echo $main_otz_id;?>">
	<?php 
	if( !empty($otz_link) ): ?>
							<div class="s7_item_btn_play">
								<img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
							</div>
	<?php endif; ?>
						</a>
					</div>
	<?php wp_reset_postdata(); ?>
	<?php endif; ?>
	<?php endwhile; ?>
	<?php endif; ?>
				</div>
				<div class="s7_btn">
					<a href="<?php echo get_home_url(); ?>/otzyvy" class="btn_click_custom"><span>поcмотреть все отзывы</span></a>
				</div>
			</div>
		</div>
	<?php endif; ?>
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
