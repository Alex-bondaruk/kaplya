<?php
/*
Template Name: Полезное 
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
<div class="s6 section pad">
    <div class="wrapper">
        <div class="s6_items">
<?php if(get_field('повторитель')){ $i=0;
	foreach(get_field('повторитель') as $row)
	{ $i++ ; ?>
            <a href="<? echo $row['ссылка'] ?>" class="s6_item">
                <div class="s6_item_img">
                    <img src="<? echo $row['изображение'] ?>" alt="">
                </div>
                <div class="s6_item_desc">
                    <? echo $row['текст'] ?> </div>
            </a>
<?}} ?>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>
