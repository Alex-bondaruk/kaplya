<?php get_header(); ?>
<div class="archive_post">
	<div class="breadcrumbs_wrapper">
		<div class="wrapper">
			<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
		</div>
	</div>
    <div class="s6 section" style="padding: 0;">
        <div class="wrapper">
            <h1 style="margin-bottom: 30px;">Вы искали «<?php echo $_GET['s'];?>»</h1>
				<?php if ( have_posts() ) : ?>
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
				<?php else: ?>
					<div class="m_content search_page empty">
						<p>Простите, но ничего не найдено</p>
					</div>
				<?php endif; ?>
        </div>
    </div>
    </div>
<?php get_footer(); ?>
