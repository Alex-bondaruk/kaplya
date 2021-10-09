<?php get_header(); ?>
<div class="archive_post">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="s6 section" style="padding: 0;">
        <div class="wrapper">
            <h1 style="margin-bottom: 30px;">Статьи</h1>
            <div class="s6_items">
<?php while ( have_posts() ) : the_post(); ?>
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
<?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="s6_btn">
				<?php if (  $wp_query->max_num_pages > 1 ) : ?>
					<script>
						var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
						var true_posts = '<?php echo json_encode($wp_query->query_vars); ?>';
						var current_page = <?php echo (get_query_var('paged')) ? get_query_var('paged') : 1; ?>;
						var max_pages = '<?php echo $wp_query->max_num_pages; ?>';
						var action = 'load_posts';
					</script>
					<a href="#" class="loadmore_posts btn_click_custom"><span>Показать еще</span></a>
				<?php endif; ?>
            </div>
        </div>
    </div>
    </div>
<?php get_footer(); ?>
