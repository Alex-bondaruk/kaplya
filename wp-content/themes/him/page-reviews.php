<?php /*Template name: Страница "Отзывы"*/ ?>
<?php get_header(); ?>
<div class="opin testimonials_page testimonials__page">
    <div class="breadcrumbs_wrapper">
        <div class="wrapper">
            <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' > '); ?>
        </div>
    </div>
    <div class="s7 section" style="padding: 0;">
        <div class="wrapper">
            <h1 style="margin-bottom: 34px;">Отзывы</h1>
            <div class=""><!--s7_items-->
                <?php
                $argsVideo = array(
                    'posts_per_page' => 2,
                    'category_name' => 'video-otzyvy',
                    'post_type' => 'reviews',
                );
                $queryVideo = new WP_Query( $argsVideo );
                ?>
                <ul class="tabs">
                    <li class="tab-link current" data-tab="tab-1">Видео отзывы</li>
                    <li class="tab-link" data-tab="tab-2">Текстовые отзывы</li>
                </ul>

                <div id="tab-1" class="tab-content current">
                    <div class="s7_items">
                        <?php while ($queryVideo->have_posts()) : $queryVideo->the_post();
                            $otz_link = get_field('otz_link');
                            ?>
                            <?php if (!empty($otz_link)): ?>
                                <div class="s7_item" data-id="<?php echo get_the_ID(); ?>"
                                     style="background: url(<?php the_post_thumbnail_url('full'); ?>);">
                                    <a href="<?php echo $otz_link; ?>" class="s7_item_btn" data-fancybox="gallery_opin">
                                        <div class="s7_item_btn_play">
                                            <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                                        </div>
                                    </a>
                                </div>
                            <?php elseif (empty($otz_link) && !(have_rows('text_reviews_group'))): ?>
                                <div class="s7_item" data-id="<?php echo get_the_ID(); ?>"
                                     style="background: url(<?php the_post_thumbnail_url('full'); ?>);">
                                    <a href="<?php the_post_thumbnail_url('full'); ?>" class="s7_item_btn"
                                       data-fancybox="gallery_opin">
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?print_r(get_query_var( 'paged' ));?>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                    <div class="s2_btns">
                        <?php if ($queryVideo->max_num_pages > 1) : ?>
                            <script>
                                var ajaxurl = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                                var true_posts = '<?php echo json_encode($queryVideo->query_vars); ?>';
                                var current_page = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                                var max_pages = '<?php echo $queryVideo->max_num_pages; ?>';
                                var action = 'load_testim';
                            </script>
                            <a href="#" class="to_call loadmore_posts">Показать еще</a>
                        <?php endif; ?>
                        <a href="#modal_order" class="to_calc open_modal btn_click_custom"><span class="to_calc_inner">Оставить заявку</span></a>
                    </div>
                </div>
                <div id="tab-2" class="tab-content">
                    <div class="s7_items_text">
                        <?php $i = 1; $j = 1; while ($queryText->have_posts()) : $queryText->the_post();?>
                            <?php if (have_rows('text_reviews_group')):
                                while (have_rows('text_reviews_group')) : the_row(); ?>
                                    <div class="s7_item_text" data-id="<?php echo get_the_ID(); ?>">
                                        <div class="otz_name"><? the_sub_field('text_review_name'); ?></div>
                                        <div class="otz_date"><? the_sub_field('date_reviews'); ?></div>
                                        <div class="otz_stars">
                                            <div class="starsItems">
                                                <?php
                                                $starsInt = intval(get_sub_field('star_rating'));
                                                for ($i; $i <= $starsInt; $i++) {
                                                    $star_rating .= '<i class="fa fa-star" aria-hidden="true"></i>';
                                                }
                                                if ($starsInt < 5) {
                                                    for ($j; $j <= (5 - $starsInt); $j++) {
                                                        $star_rating .= '<i class="fa fa-star-o" aria-hidden="true"></i>';
                                                    }
                                                }
                                                echo $star_rating;
                                                ?>
                                            </div>
                                        </div>
                                        <div class="otz_text"><?php the_sub_field('text_otzv'); ?></div>
                                    </div>
                                <?php endwhile;
                            endif; ?>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                    <div class="s2_btns">
                        <?php if ($queryText->max_num_pages > 1) : ?>
                            <script>
                                var ajaxurl_text = '<?php echo site_url() ?>/wp-admin/admin-ajax.php';
                                var true_posts_text = '<?php echo json_encode($queryText->query_vars); ?>';
                                var current_page_text = <?php echo ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; ?>;
                                var max_pages_text = '<?php echo $queryText->max_num_pages; ?>';
                                var action_text = 'load_testim_text';
                            </script>
                            <a href="#" class="to_call loadmore_posts_text">Показать еще</a>
                        <?php endif; ?>
                        <a href="#modal_order" class="to_calc open_modal btn_click_custom"><span class="to_calc_inner">Оставить заявку</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="s10 section">
        <div class="wrapper">
            <img class="sh10" src="/wp-content/themes/him/img/s10_img.png" alt="sheet">
            <h2 class="title">Химчистка мебели и ковров</h2>
            <div class="s10_content" style="text-align: center;">
                <?php the_field('bottom_desc_text', 'option'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>