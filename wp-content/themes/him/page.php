<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="archive_post archive_post__recent">
		<div class="breadcrumbs_wrapper">
			<div class="wrapper">
				<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
			</div>
		</div>
        <div class="post_content">
            <div class="wrapper">
                <h1 class="title_page"><?php the_title(); ?></h1>
				<?php if(has_post_thumbnail()) { ?>
                <div class="post_content_thumb">
                    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="">
                </div>
				<?php } ?>
                <div class="post_content_inside post_content_inside--single">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
