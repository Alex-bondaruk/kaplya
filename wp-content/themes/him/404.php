<?php get_header(); ?>
<div class="wrapper">
    <div class="error">
        <div class="error_title">Ошибка</div>
        <div class="error_subtitle">404</div>
        <p>Такая страница не существует</p>
        <div class="error_btns">
            <a class="to_main btn_click_custom" href="<?php echo get_home_url(); ?>"><span>На главную</span></a>
            <a class="back btn_click_custom" onclick="javascript:history.back(); return false;"><span>назад</span></a>
        </div>
    </div>
</div>
<?php get_footer(); ?>
