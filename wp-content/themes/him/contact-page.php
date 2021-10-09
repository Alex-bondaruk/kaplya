<?php
/*
Template Name: Контакты
*/
?>
<?php get_header(); ?>
<div class="services contact__page">
		<div class="breadcrumbs_wrapper">
			<div class="wrapper">
				<?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' > '); ?>
			</div>
		</div>
        <div class="wrapper">
            <div class="contact_page">
            <h1>Контакты</h1>
                <div class="contact_items">
                    <div class="contact_left">
                        <div class="contact_subtitle">
                            Вы можете обратиться к нам по телефону, по электронной почте или договориться о встрече в нашем офисе. Будем рады помочь и ответить на все ваши вопросы.
                        </div>
                        <h4>Контакты в Новосибирске</h4>
                        <div class="contact_phone">
                            <div class="contact_phone_ico">
                                <img src="/wp-content/themes/him/img/phone_ico.svg" alt="phone">
                            </div>
                            <div class="contact_phone_right">
                                <p>Телефон:</p>
                                <a href="tel:<?php the_field('phone_link', 'option'); ?>"><?php the_field('phone', 'option'); ?> <span><?php the_field('phone1', 'option'); ?></span></a>
                            </div>
                        </div>
                        <div class="contact_social">
                            <p>Соц. сети</p>
                            <div class="contact_social_items">
                                <a target="_blank" href="<?php the_field('instagram', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/instagram.svg" alt="instagram"></a>
                                <a target="_blank" href="<?php the_field('vk', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/vk.svg" alt="vk"></a>
                                <a target="_blank" href="<?php the_field('whatsapp', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/whatsapp.svg" alt="whatsapp"></a>
                                <a target="_blank" href="<?php the_field('viber', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/viber.svg" alt="viber"></a>
                            </div>
                        </div>
                        <h4>Контакты для связи по всем городам</h4>
                        <div class="contact_email">
                            <div class="contact_email_ico">
                                <img src="/wp-content/themes/him/img/mail_ico.svg" alt="email">
                            </div>
                            <div class="contact_email_right">
                                <p>Почта:</p>
                                <a href="mailto:<?php the_field('email', 'option'); ?>"><?php the_field('email', 'option'); ?></a>
                            </div>
                        </div>
                        <div class="contact_social">
                            <p>Соц. сети</p>
                            <div class="contact_social_items">
                                <a target="_blank" href="<?php the_field('vk', 'option'); ?>"><img class="img_svg" src="/wp-content/themes/him/img/vk.svg" alt="vk"></a>
                               </div>
                        </div>
                    </div>
                    <div class="contact_right">
                        <?php echo do_shortcode('[contact-form-7 id="5" title="Контактная форма (страница контакты)"]'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
