

   <div class="s5 section">
        <div class="s5_img_bg"><img src="/wp-content/themes/him/img/img_bg_akc.jpg" alt=""/></div>
        <img class="sh5_2" src="/wp-content/themes/him/img/l5_2.svg" alt="sheet">
        <div class="wrapper">
            <h2 class="title">Наши акции</h2>
            <div class="s5_items">
<?php 
$sale1_img = get_field('sale1_img', 'option');
if( !empty($sale1_img) ): ?>
                        <div class="s5_left s5_item over" style="background-image: url(<?php echo $sale1_img['url']; ?>);">
                            <div class="content">
                                <?php the_field('sale1_desc', 'option'); ?>
                            </div>
                            <div class="s5_btn s5_btn_inside">
                                <a href="<?php //the_field('sale1_link', 'option'); ?>" class="btn_click_custom"><span>Узнать подробнее</span></a>
                            </div>
                            <a href="<?php //the_field('sale1_link', 'option'); ?>#modal_profs" class="open_modal"></a>
                        </div>
<?php endif; ?>
                        <div class="s5_right">
<?php 
$sale2_img = get_field('sale2_img', 'option');
if( !empty($sale2_img) ): ?>
                            <div class="s5_right1 s5_item over" style="background-image: url(<?php echo $sale2_img['url']; ?>);">
                                <div class="content">
                                    <?php the_field('sale2_desc', 'option'); ?>
                                </div>
                                <div class="s5_btn2 s5_btn_inside">
                                    <a href="<?php the_field('sale2_link', 'option'); ?>" class="btn_click_custom"><span><img src="/wp-content/themes/him/img/arrow_right.svg" alt="arrow"/></span></a>
                                </div>
                                <a href="<?php the_field('sale2_link', 'option'); ?>" class="open"></a> 
                            </div>
<?php endif; ?>
<?php 
$sale3_img = get_field('sale3_img', 'option');
if( !empty($sale3_img) ): ?>
                            <div class="s5_right2 s5_item over" style="background-image: url(<?php echo $sale3_img['url']; ?>);">
                                <div class="content">
                                    <?php the_field('sale3_desc', 'option'); ?>
                                </div>
                                <div class="s5_btn2 s5_btn_inside">
                                    <a href="<?php //the_field('sale3_link', 'option'); ?>" class="btn_click_custom"><span><img src="/wp-content/themes/him/img/arrow_right.svg" alt="arrow"/></span></a>
                                </div>
                                <a href="<?php //the_field('sale1_link', 'option'); ?>#modal_order" class="open_modal"></a>                             
                            </div>
<?php endif; ?>
                        </div>
                    </div>
        </div>
    </div>
