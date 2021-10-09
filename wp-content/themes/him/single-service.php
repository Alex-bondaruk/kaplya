<?php get_header(); ?>
<?php $sityName = morphos\Russian\GeographicalNamesInflection::getCase($_SESSION['currentActiveSity'], 'предложный'); ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="single_ service services__page">
        <div class="breadcrumbs_wrapper">
            <div class="wrapper">
				<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
            </div>
        </div>
        <div class="wrapper">
            <?php
                $sityName = morphos\Russian\GeographicalNamesInflection::getCase($_SESSION['currentActiveSity'], 'предложный');
            ?>
            <h1><?php echo get_the_title() . ' в '. $sityName ?></h1>
            <div class="service_items">
                <div class="service_items_left">
                    <div class="service_thumb" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>);">
                        
                    </div>
                </div>
                <div class="service_items_right">
                    <div class="content">
                        <?php the_field('serv_desc'); ?>
                    </div>
                    <div class="service_items_right_btns">
                        <div class="s2_btns">
                            <a href="#modal_order" class="to_call_m open_modal btn_click_custom"><em>Оставить заявку</em></a>
                            <a href="<?php echo get_home_url(); ?>/calculator" class="to_calc btn_click_custom"><em><span><img class="img_svg" src="/wp-content/themes/him/img/to_calc.svg" alt="icon"></span>Калькулятор стоимости</em></a>
                        </div>
                    </div>
                </div>
            </div>

<?php if( get_field('serv_s2_show') ): ?>
            <div class="service_price section">
                <h2 class="title"><?php echo get_field('serv_s2_title').' в '.$sityName ?></h2>
                <div class="service_price_subtitle">
                    <?php the_field('serv_s2_subtitle'); ?>
                </div>
				<?php if( have_rows('serv_prices_loop') ): ?>
                <div class="service_price_items">
					<?php while( have_rows('serv_prices_loop') ): the_row(); ?>
                    <div class="service_price_item">
					<a href="#modal_ech" class="open_modal"></a>
                        <div class="service_price_item_img">
                            <img src="<?php the_sub_field('serv_price_image'); ?>" alt="icon">
                        </div>
                        <div class="service_price_item_title">
                            <?php the_sub_field('serv_price_title'); ?>
                        </div>
						<?php if(get_sub_field('serv_price_desc')) { ?>
							<div class="service_price_item_subtitle">
								<?php the_sub_field('serv_price_desc'); ?>
							</div>
						<?php } else { ?>
							<div class="service_price_item_subtitle">
								&nbsp;
							</div>
						<?php } ?>
                        <div class="service_price_item_price">
                            <?php the_sub_field('serv_price_price'); ?>
                        </div>
                    </div>
					<?php endwhile; ?>
                </div>
				<?php endif; ?>
            </div>
<?php endif; ?>
<?php if( get_field('serv_s3_show') ): ?>
            <div class="service_about section">
                <h2 class="title"><?php the_field('serv_s3_title'); ?></h2>
<?php 
if( have_rows('serv_s3_items') ):
?>
                <div class="service_about_items">
<?php while( have_rows('serv_s3_items') ): the_row(); 
    $serv_s3_item_ico = get_sub_field('serv_s3_item_ico');
    $serv_s3_item_title = get_sub_field('serv_s3_item_title');
    $serv_s3_item_desc = get_sub_field('serv_s3_item_desc');
?>
                    <div class="service_about_item">
                        <div class="service_about_item_ico">
                            <img src="<?php echo $serv_s3_item_ico['url']; ?>" alt="icon">
                        </div>
                        <div class="service_about_item_title">
                            <?php echo $serv_s3_item_title; ?>
                        </div>
                        <div class="service_about_item_desc">
                            <?php echo $serv_s3_item_desc; ?>
                        </div>
                    </div>
<?php endwhile; ?>
        </div> 
        <?php endif; ?>
            </div>
<?php endif; ?>
<?php if( get_field('serv_s4_show') ): ?>
            <div class="s7 section">
                    <h2 class="title"><?php the_field('serv_s4_title'); ?></h2>
                    <div class="subtitle" style="margin-bottom: 40px;"><?php the_field('serv_s4_subtitle'); ?></div>
<?php 
if( have_rows('serv_s4_item') ):
?>
<?php $serv_s4_item_id = 0; ?>
                    <div class="s7_items">
<?php while( have_rows('serv_s4_item') ): the_row(); 
    $serv_s4_item_img = get_sub_field('serv_s4_item_img');
    $serv_s4_item_link = get_sub_field('serv_s4_item_link');
    $serv_s4_item_id++;
?>
                        <div class="s7_item" style="background: url(<?php echo $serv_s4_item_img['url']; ?>);">
                            <a href="<?php echo $serv_s4_item_link; ?>" class="s7_item_btn <?php// btn_popup echo $main_sl_id;?>" data-fancybox="gallery_opin">
                                <div class="s7_item_btn_play">
                                    <img class="img_svg" src="/wp-content/themes/him/img/play2.svg" alt="play">
                                </div>
                            </a>
                        </div>
<?php endwhile; ?>
        </div> 
        <?php endif; ?> 
            </div>
<?php endif; ?>

<?php if(get_field('serv_s5_show')) { ?>
<?php // вставка блока Акции
include('parts/section5-akcii.php');?>
<?php } ?>
<?php 
if( have_rows('befaft_sl', 'option') ):
?>
<?php if(get_field('serv_result_show')) { ?>
            <div class="s4 section">
                    <h2 class="title"><?php echo get_field('serv_result_title').' в '.$sityName ?></h2>
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
                    <div class="s6_btn">
                        <a href="<?php echo get_home_url(); ?>/do-posle" class="btn_click_custom"><span>Смотреть все работы</span></a>
                    </div>
            </div>
<?php } ?>
<?php endif; ?>
<?php if(get_field('serv_master_show')) { ?>
            <div class="master">
                <div class="master_items">
<?php 
$master_img = get_field('master_img');
if( !empty($master_img) ): ?>
                    <div class="master_img">
                        <img src="<?php echo $master_img['url']; ?>" alt="<?php echo $master_img['alt']; ?>">
                    </div>
<?php endif; ?>
                    <div class="master_desc">
                        <h2><?php the_field('master_title'); ?></h2>
                        <div class="content">
                            <?php the_field('master_desc'); ?>
                        </div>
                    </div>
                </div>
            </div>
<?php } ?>
<?php 
if( have_rows('quest', 'option') ):
?>
<?php if(get_field('serv_faq_show')) { ?>
    <div class="s8 section">
            <h2 class="title"><?php the_field('serv_faq_title'); ?></h2>
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
<?php } ?>
<?php endif; ?> 
            <div class="s6 section" style="background: none;">
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
                    <a href="<?php echo get_home_url(); ?>/stati" class="btn_click_custom"><span>Смотреть все</span></a>
                </div>
        </div>
        </div>
    </div>
<?php endwhile; ?>
<?php get_footer(); ?>
<?php /*
if( have_rows('serv_s4_item') ):
     $serv_s4_item_id = 0; 

     while( have_rows('serv_s4_item') ): the_row(); 
        $serv_s4_item_link = get_sub_field('serv_s4_item_link');
        $serv_s4_item_id++;

<div class="popup popup<?echo $main_sl_id;?>">
  <div class="close1"></div>
  <div class="popup-block">
    <div class="close2"><i class="fa fa-times-circle" aria-hidden="true"></i></div> 
    <div class="popup_video_wr">
        <iframe width="100%" height="100%" src="<?php echo $serv_s4_item_link; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(".btn_popup<?echo $main_sl_id;?>").click(function(){
      $(".popup<?echo $main_sl_id;?>").css("display", "block");
  });
  $(".close1").click(function(){
      $(".popup<?echo $main_sl_id;?>").css("display", "none");
  });
  $(".close2").click(function(){
      $(".popup<?echo $main_sl_id;?>").css("display", "none");
  }); 
</script>
<?php endwhile; 

 endif; */?> 
