<?php get_header(); ?>
<div class="services service__page_cat">
        <div class="breadcrumbs_wrapper">
            <div class="wrapper">
				<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
            </div>
        </div>
        <div class="wrapper">
            <h1><?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); echo $term->name; ?></h1>
            <div class="services_items">
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
                <div class="s2_item">
                    <a href="<?php the_permalink(); ?>" class="s2_item_link"></a>
                    <div class="s_item_img">
                        <img src="<?php the_post_thumbnail_url('full'); ?>" alt="">
                    </div>
                    <div class="s_item_title">
                        <?php the_title(); ?>
                    </div>
                </div>
<?php endwhile; endif;
wp_reset_postdata(); ?>
            </div>
<?php 
if( have_rows('quest', 'option') ):
?>
    <div class="s8 section">
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
<?php endif; ?> 
        </div>
    </div>
<?php get_footer(); ?>
