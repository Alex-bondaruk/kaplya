<?php
/*
Template Name: Главная страница
*/
?>
<?php get_header(); ?>
<?php $sityName = morphos\Russian\GeographicalNamesInflection::getCase($_SESSION['currentActiveSity'], 'предложный');  ?>
<div class="home">
<div class="s1">
        <img class="sh2" src="/wp-content/themes/him/img/l1_1.svg" alt="sheet">
        <div class="s1_right_bg">
            <div class="s1_right_link">
                <a>
                    <span class="s1_right_link_arrow"><img class="img_svg" src="/wp-content/themes/him/img/arrow_down1.svg" alt="arrow"></span>
                    <span class="s1_right_link_title">Листайте ниже</span>
                </a>
            </div>
        </div>
        <div class="wrapper">
            <div class="s1_items">
                <div class="s1_left">
                        <h1><?php the_field('main_s1_title'); ?><span><?php the_field('main_s1_subtitle'); ?></span></h1>
                        <?php the_field('main_s1_ul'); ?>
<?php 
if( have_rows('main_s1_item') ):
?>
                        <div class="s1_left_items">
<?php while( have_rows('main_s1_item') ): the_row(); 
    $main_s1_item_ico = get_sub_field('main_s1_item_ico');
    $main_s1_item_desc = get_sub_field('main_s1_item_desc');
?>
                            <div class="s1_left_item">
                                <div class="s1_left_item_ico">
                                    <img src="<?php echo $main_s1_item_ico['url']; ?>" alt="icon">
                                </div>
                                <div class="s1_left_item_desc">
                                    <?php echo $main_s1_item_desc; ?>
                                </div>
                            </div>
<?php endwhile; ?>
        </div> 
        <?php endif; ?> 
                        <div class="s1_left_btns">
                            <a href="<?php echo get_home_url(); ?>/calculator" class="to_calc btn_click_custom"><em><span><img class="img_svg" src="/wp-content/themes/him/img/to_calc.svg" alt="icon"></span>Калькулятор стоимости</em></a>
                            <a href="#modal_order" class="to_call вopen_modal btn_click_custom open_modal"><em>Оставить заявку</em></a>
                        </div>
                </div>
                <div class="s1_right">
                    <img class="s1_1" src="/wp-content/themes/him/img/s1_11.png" alt="">
                    <img class="s1_2" src="/wp-content/themes/him/img/s1_2.png" alt="">
                    <a href="<?php the_field('main_youtube_link'); ?>" class="popup_video" data-lity>
                        <img class="img_svg" src="/wp-content/themes/him/img/play1.svg" alt="play">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="s2 section home">
        <img class="sh3_1" src="/wp-content/themes/him/img/s2_img1.svg" alt="sheet">
        <!-- <img class="sh3_2" src="/wp-content/themes/him/img/s2_img2.svg" alt="sheet"> -->
        <img class="sh3" src="/wp-content/themes/him/img/l2.svg" alt="sheet">
        <img class="sh_new" src="/wp-content/themes/him/img/bg_services_new_2.jpg" alt="sheet">
        <div class="wrapper">
            <h2 class="title">Мы оказываем услуги по чистке</h2>
            <div class="subtitle">Что вам необходимо почистить?</div>
            <div class="s2_items">
<?php
$count = 1;
$_terms = get_terms( array(
    'parent' => 0,
    'taxonomy'     => 'servicecat',
    'orderby'      => 'name',
    'order'        => 'DESC',
) );

foreach ($_terms as $term) :
    $term_slug = $term->slug;
?>
                <?php if($count < 9) { ?>
                <div class="s2_item">
                    <a href="<?php /*echo get_term_link($term->slug, 'servicecat'); */ echo the_field('ссылка_на_страницу', $term) ?>" class="s2_item_link"></a>
                    <div class="s_item_img">
                        <?php
                            $imageTermImage = z_taxonomy_image_url($term->term_id, 'thumbnail');
                            $imageTermPath = parse_url($imageTermImage);
                        ?>
                        <img src="<?php echo $imageTermPath['path']; ?>" alt="">
                    </div>
                    <div class="s_item_title">
                        <?php echo $term->name; ?>
                    </div>
                </div>
                <?php } ?>
<?php $count++; endforeach; ?>
            </div>
            <div class="s2_btns">
                <a href="<?php echo get_home_url(); ?>/service" class="to_call btn_click_custom"><em>посмотреть все услуги</em></a>
                <a href="<?php echo get_home_url(); ?>/calculator" class="to_calc btn_click_custom"><em><span><img class="img_svg" src="/wp-content/themes/him/img/to_calc.svg" alt="icon"></span>Калькулятор стоимости</em></a>
            </div>
        </div>
    </div>
<?php wp_reset_postdata(); ?>
<?php if( get_field('main_s3_show') ): ?>
    <div class="s3 section">
        <img class="sh4" src="/wp-content/themes/him/img/l3.svg" alt="sheet">
        <div class="wrapper">
            <h2 class="title"><?php the_field('main_s3_title'); ?></h2>
<?php 
if( have_rows('main_s3_item') ):
?>
            <div class="s3_items">
<?php while( have_rows('main_s3_item') ): the_row(); 
    $main_s3_item_ico = get_sub_field('main_s3_item_ico');
    $main_s3_item_title = get_sub_field('main_s3_item_title');
    $main_s3_item_desc = get_sub_field('main_s3_item_desc');
?>
                <div class="s3_item">
                    <div class="s3_item_wr">
                        <div class="s3_item_img">
                            <img src="<?php echo $main_s3_item_ico['url']; ?>" alt="icon">
                        </div>
                        <div class="s3_item_title">
                            <?php echo $main_s3_item_title; ?>
                        </div>
                        <div class="s3_item_desc">
                            <?php echo $main_s3_item_desc; ?>
                        </div>
                    </div>
                </div>
<?php endwhile; ?>
        </div> 
        <?php endif; ?> 
        </div>
    </div>
<?php endif; ?>
<?php 
if( have_rows('befaft_sl', 'option') ):
?>
    <div class="s4 section">
        <img class="sh5" src="/wp-content/themes/him/img/l4.svg" alt="sheet">
        <div class="wrapper">
            <h2 class="title"><?php echo get_field('before_title', 'option') .' в '.$sityName?></h2>
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
<?php endif; ?>
 
<?php // вставка блока Акции
include('parts/section5-akcii.php');?>


    <div class="s6 section">
        <div class="wrapper">
            <h2 class="title">Последние статьи</h2>
            <div class="s6_items">

<?php
$args = array(
    'post_type' => 'post',
    'cat' => 19,
    'posts_per_page' => 3,
    'meta_query' => array(
      array(
        'key' => 'show_on_main',
        'value' => '1',
      )
    )
  );
$post_cat = new WP_Query($args);?>
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
                    <a href="<?php echo $otz_link; ?>" class="s7_item_btn" data-fancybox="gallery_opin">
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
<?php 
if( have_rows('quest', 'option') ):
?>
    <div class="s8 section">
        <img class="sh8" src="/wp-content/themes/him/img/l8.svg" alt="sheet">
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
<?php endif; ?> 
    <div class="s9">
        <div class="wrapper">
            <?php switch_to_blog(1); ?>
            <?php echo do_shortcode('[contact-form-7 id="176" title="Форма на главной"]'); ?>
            <?php restore_current_blog(); ?>
        </div>
    </div>
    <div class="s10 section">
        <div class="wrapper">
            <img class="sh10" src="/wp-content/themes/him/img/s10_img.png" alt="sheet">
            <h2 class="title"><?php echo get_field('bottom_desc_title', 'option').' в '.$sityName ?></h2>
            <div class="s10_content" style="text-align: center;">
                <?php the_field('bottom_desc_text', 'option'); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>