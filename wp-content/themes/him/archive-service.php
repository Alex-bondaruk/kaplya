<?php get_header(); ?>
<div class="services services__page">
    <div class="breadcrumbs_wrapper">
        <div class="wrapper">
            <?php if (function_exists('kama_breadcrumbs')) kama_breadcrumbs(' > '); ?>
        </div>
    </div>
    <div class="wrapper">
        <h1>Услуги</h1>
        <div class="page_subtitle content">
            <p><strong>Чем мы можем быть вам полезны?</strong></p>
            <p>У нас есть несколько направлений - это химчистка мебели, различных текстильных изделий и химчистка
                ковровых покрытий. Про каждое направление вы можете почитать подробнее:</p>
        </div>
        <div class="services_items">
            <?php
            $_terms = get_terms(array(
                'parent' => 0,
                'taxonomy' => 'servicecat',
                'orderby' => 'name',
                'order' => 'DESC',
            ));

            foreach ($_terms as $term) :
                $term_slug = $term->slug;
                $imageTermImage = z_taxonomy_image_url($term->term_id, 'thumbnail');
                $imageTermPath = parse_url($imageTermImage);
                ?>
                <div class="s2_item">
                    <div class="s2_item_inside">
                        <a href="<?php echo get_term_link($term->slug, 'servicecat'); ?>" class="s2_item_link"></a>
                        <div class="s_item_img">
                            <img src="<?php echo $imageTermPath['path']; ?>" alt="">
                        </div>
                        <div class="s_item_title">
                            <?php echo $term->name; ?>
                        </div>
                        <div class="services_item_menu">
                            <div class="services_item_btn">
                                <img src="/wp-content/themes/him/img/arrow_down2.svg" alt="arrow">
                            </div>
                            <?php
                            $_posts = new WP_Query(array(
                                'post_type' => 'service',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'servicecat',
                                        'field' => 'slug',
                                        'terms' => $term_slug,
                                    ),
                                ),
                            ));


                            if ($_posts->have_posts()) :

                                ?>
                                <ul>
                                    <?php while ($_posts->have_posts()) : $_posts->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif;
                            wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <?php
        if (have_rows('quest', 'option')):
            ?>
            <div class="s8 section">
                <h2 class="title">Часто задаваемые вопросы</h2>
                <div class="s8_items">
                    <?php while (have_rows('quest', 'option')): the_row();
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
