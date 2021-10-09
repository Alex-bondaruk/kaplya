<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="archive_post archive_post__recent">
        <div class="breadcrumbs_wrapper">
            <div class="wrapper">
				<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
            </div>
        </div>
        <div class="post_content post_content--single">
            <div class="wrapper">
                <h1 class="title_page"><?php the_title(); ?></h1>
				<?php if(has_post_thumbnail()) { ?>
                
				<?php } ?>
                <div class="post_content_inside post_content_inside--single">
                    <?php the_content(); ?>
                </div>
			<?
			//if ( comments_open() || get_comments_number() ) :
			//	comments_template();
			//endif;
			?>
            </div>
        </div>
    <div class="s6 section" style="background: #fff;">
        <div class="wrapper">
            <h2 class="title">Похожие статьи</h2>
            <div class="s6_items">
<?php 
	$categories = get_the_category($post->ID);
	$category_ids = array();
	if ($categories) {
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	}
?>
<?php $post_cat = new WP_Query(array('category__in' => $category_ids, 'posts_per_page' => 3,'post__not_in' => array($post->ID),'post_type' => 'post'));?>
<?php if ( $post_cat->have_posts() ) : ?>
    <?php while ( $post_cat->have_posts() ) : $post_cat->the_post(); ?> 
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
<?php endwhile; endif;
wp_reset_postdata(); ?>
                </div>
            <div class="s6_btn">
                <a href="<?php echo get_home_url(); ?>/stati" class="btn_click_custom"><span>Все статьи</span></a>
            </div>
        </div>
    </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
