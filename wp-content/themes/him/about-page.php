<?php
/*
Template Name: О нас
*/
?>
<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="archive_post archive_post__recent page_bk">
		<div class="breadcrumbs_wrapper">
			<div class="wrapper">
				<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
			</div>
		</div>
        <div class="post_content post_content--single before_map">
            <div class="wrapper">
                <h1 class="title_page"><?php the_title(); ?></h1>
                <div class="post_content_thumb">
                    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="">
                </div>
                <div class="post_content_inside">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <div class="map_bk section">
            <div class="wrapper">
                <h2 class="title">Капля - крупнейшая федеральная сеть<br>выездных химчисток мебели</h2>
                <div id="map_about"></div>
                <div class="map_btn"><a href="#modal_ruk" class="open_modal submit btn_click_custom"><span>Отправить сообщение руководителям</span></a></div>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
