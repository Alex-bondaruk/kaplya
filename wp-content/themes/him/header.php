<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title(''); ?></title>

    <link href="/wp-content/themes/him/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="/wp-content/themes/him/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/wp-content/themes/him/slick/slick-theme.css"/>
    <link href="/wp-content/themes/him/css/jquery.fancybox.min.css" rel="stylesheet"/>
    <link href="/wp-content/themes/him/css/twentytwenty.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="/wp-content/themes/him/css/jqcart.css" rel="stylesheet"/>
    <meta name="yandex-verification" content="3221d2f24facbf69"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css"/>
    <link href="/wp-content/themes/him/css/styles.css?v=<?= time() ?>" rel="stylesheet"/>
    <link href="/wp-content/themes/him/css/custom.css?v=<?= time() ?>" rel="stylesheet"/>
    <link href="/wp-content/themes/him/css/lity.min.css?v=<?= time() ?>" rel="stylesheet"/>
    <script charset="utf-8" src="https://api-maps.yandex.ru/1.1/index.xml" type="text/javascript"></script>
    <?php wp_head(); ?>
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(80275114, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/80275114" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
<header>
    <img class="sh1" src="/wp-content/themes/him/img/l1.svg" alt="sheet">
    <div class="wrapper">
        <div class="header_row1">
            <div class="header_menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class' => 'menu',
                    'theme_location' => 'основное_меню',
                    'container' => false,
                    'walker' => new macho_bootstrap_walker()
                ));
                ?>
            </div>
            <div class="header_search">
                <a href="#modal_search" class="header_search_ico open_modal">
                    <img class="img_svg" src="/wp-content/themes/him/img/search.svg" alt="search">
                </a>
            </div>
        </div>
        <div class="header_row2">
            <div class="header_row2_left">
                <div class="header_logo">
                    <?php
                    $logo = get_field('logo', 'option');
                    if (!empty($logo)): ?>
                        <a href="<?php if (empty($_SESSION['urlCurrentSite'])) {
                            echo get_home_url();
                        } else {
                            echo $_SESSION['urlCurrentSite'];
                        } ?>"><img src="<?php echo $logo['url']; ?>" alt="logo"></a>
                    <?php endif; ?>
                </div>
                <div class="header_city">
                    <div class="header_city_title">Ваш город:</div>
                    <div class="header_city_items">
                        <a href="#select_city" class="this-town open_modal"><?php
                            if (isset($_SESSION['currentActiveSity']) && !empty($_SESSION['currentActiveSity'])) {
                                echo $_SESSION['currentActiveSity'];
                            } else {
                                echo get_option('options_city_for_list');
                            }
                            ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="header_row2_right">
                <div class="header_social">
                    <div class="header_social_items">
                        <a target="_blank" href="<?php the_field('instagram', 'option'); ?>"><img class="img_svg"
                                                                                                  src="/wp-content/themes/him/img/instagram.svg"
                                                                                                  alt="instagram"></a>
                        <a target="_blank" href="<?php the_field('vk', 'option'); ?>"><img class="img_svg"
                                                                                           src="/wp-content/themes/him/img/vk.svg"
                                                                                           alt="vk"></a>
                        <a target="_blank" href="<?php the_field('whatsapp', 'option'); ?>"><img class="img_svg"
                                                                                                 src="/wp-content/themes/him/img/whatsapp.svg"
                                                                                                 alt="whatsapp"></a>
                        <a target="_blank" href="<?php the_field('viber', 'option'); ?>"><img class="img_svg"
                                                                                              src="/wp-content/themes/him/img/viber.svg"
                                                                                              alt="viber"></a>
                    </div>
                </div>
                <div class="header_phone">
                    <a href="tel:<?php the_field('phone_link', 'option'); ?>"><?php the_field('phone', 'option'); ?>
                        <span> <?php the_field('phone1', 'option'); ?></span></a>
                    <p>Время работы: <span><?php the_field('time', 'option'); ?></span></p>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="header_mob">
    <div class="wrapper">
        <div class="header_mob_items">
            <div class="logo">
                <?php if (!empty($logo)): ?>
                    <a href="<?php echo get_home_url(); ?>"><img src="<?php echo $logo['url']; ?>" alt="logo"></a>
                <?php endif; ?>
            </div>
            <div class="burger_wrapper">
                <div class="burger">
                    <div class="burger_icon"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mob_menu">
    <div class="wrapper">
        <div class="mob_menu_row1">
            <div class="logo">
                <a href="<?php echo get_home_url(); ?>"><img src="/wp-content/uploads/2020/10/logo2-1.svg"
                                                             alt="logo"></a>
            </div>
            <div class="mob_menu_close">
                <a href="#" class="header_close_btn">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <div class="mob_menu_row2">
            <div class="header_city">
                <div class="header_city_title">Ваш город:</div>
                <div class="header_city_items">
                    <a href="#select_city" class="open_modal"><?php echo get_option('options_city_for_list'); ?></a>
                </div>
            </div>
            <div class="header_phone">
                <a href="tel:<?php the_field('phone_link', 'option'); ?>"><?php the_field('phone', 'option'); ?>
                    <span> <?php the_field('phone1', 'option'); ?></span></a>
                <p>Время работы: <span><?php the_field('time', 'option'); ?></span></p>
            </div>
        </div>
        <div class="header_social_items">
            <a target="_blank" href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none"
                     class="img_svg replaced-svg">
                    <path d="M7.52637 3.28125C5.19617 3.28125 3.28125 5.1936 3.28125 7.52637V13.4736C3.28125 15.8038 5.1936 17.7188 7.52637 17.7188H13.4736C15.8038 17.7188 17.7188 15.8064 17.7188 13.4736V7.52637C17.7188 5.19617 15.8064 3.28125 13.4736 3.28125H7.52637ZM7.52637 4.59375H13.4736C15.0963 4.59375 16.4062 5.90369 16.4062 7.52637V13.4736C16.4062 15.0963 15.0963 16.4062 13.4736 16.4062H7.52637C5.90369 16.4062 4.59375 15.0963 4.59375 13.4736V7.52637C4.59375 5.90369 5.90369 4.59375 7.52637 4.59375ZM14.376 6.0293C14.0453 6.0293 13.7812 6.29334 13.7812 6.62402C13.7812 6.95471 14.0453 7.21875 14.376 7.21875C14.7067 7.21875 14.9707 6.95471 14.9707 6.62402C14.9707 6.29334 14.7067 6.0293 14.376 6.0293ZM10.5 6.5625C8.33386 6.5625 6.5625 8.33386 6.5625 10.5C6.5625 12.6661 8.33386 14.4375 10.5 14.4375C12.6661 14.4375 14.4375 12.6661 14.4375 10.5C14.4375 8.33386 12.6661 6.5625 10.5 6.5625ZM10.5 7.875C11.9586 7.875 13.125 9.04138 13.125 10.5C13.125 11.9586 11.9586 13.125 10.5 13.125C9.04138 13.125 7.875 11.9586 7.875 10.5C7.875 9.04138 9.04138 7.875 10.5 7.875Z"
                          fill="#7491A5" fill-opacity="0.6"></path>
                </svg>
            </a>
            <a target="_blank" href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none"
                     class="img_svg replaced-svg">
                    <g clip-path="url(#clip0)">
                        <path d="M15.9152 10.9516C15.8958 10.9125 15.8777 10.88 15.861 10.854C15.5834 10.3853 15.0529 9.80997 14.2698 9.12788L14.2533 9.11227L14.245 9.10461L14.2366 9.09676H14.2282C13.8728 8.77914 13.6478 8.56559 13.5535 8.45625C13.3811 8.24798 13.3425 8.03716 13.4367 7.82354C13.5033 7.66215 13.7534 7.32132 14.1865 6.80057C14.4143 6.52459 14.5947 6.30341 14.7279 6.13676C15.6888 4.93919 16.1053 4.17392 15.9775 3.84066L15.9279 3.76279C15.8946 3.7159 15.8085 3.67301 15.6698 3.63389C15.5308 3.59486 15.3531 3.5884 15.1365 3.61442L12.7373 3.62995C12.6985 3.61704 12.643 3.61825 12.5707 3.63389C12.4985 3.64954 12.4623 3.65739 12.4623 3.65739L12.4206 3.67695L12.3874 3.70044C12.3597 3.71598 12.3291 3.74331 12.2958 3.78237C12.2626 3.8213 12.2348 3.86698 12.2127 3.91903C11.9515 4.54903 11.6545 5.13477 11.3212 5.67623C11.1157 5.99909 10.927 6.2789 10.7546 6.51581C10.5825 6.75265 10.4381 6.92714 10.3215 7.03899C10.2048 7.15096 10.0995 7.24065 10.0049 7.30841C9.91046 7.37619 9.83836 7.40483 9.78844 7.39435C9.7384 7.38388 9.69128 7.37348 9.64666 7.36309C9.56896 7.3162 9.50646 7.25244 9.45934 7.17174C9.41201 7.09105 9.38015 6.98948 9.36349 6.86713C9.34692 6.74469 9.33711 6.63937 9.33431 6.55083C9.33171 6.46239 9.33291 6.3373 9.33854 6.17591C9.34432 6.01444 9.34692 5.90518 9.34692 5.8479C9.34692 5.65002 9.35103 5.43526 9.35929 5.20357C9.36769 4.97188 9.37449 4.7883 9.38018 4.65306C9.38584 4.51768 9.38847 4.37446 9.38847 4.22346C9.38847 4.07246 9.37866 3.95405 9.35929 3.8681C9.34015 3.78226 9.31077 3.69894 9.27205 3.61816C9.23309 3.53747 9.17608 3.47504 9.10127 3.43073C9.02631 3.38647 8.93311 3.35135 8.82221 3.32525C8.52783 3.2628 8.15298 3.22902 7.69748 3.22377C6.66455 3.21337 6.00084 3.2759 5.70649 3.41128C5.58987 3.46848 5.48433 3.54663 5.38997 3.64549C5.28998 3.76008 5.27603 3.82261 5.34821 3.8329C5.68149 3.8797 5.91742 3.99166 6.05628 4.16867L6.10632 4.26247C6.14524 4.33014 6.18411 4.44996 6.223 4.62174C6.26184 4.79353 6.2869 4.98356 6.29793 5.19172C6.32565 5.57187 6.32565 5.89728 6.29793 6.16798C6.27012 6.43878 6.24386 6.6496 6.2188 6.8006C6.19374 6.9516 6.15627 7.07395 6.10632 7.16764C6.05628 7.26136 6.02299 7.31864 6.0063 7.33943C5.98964 7.36022 5.97575 7.37332 5.96472 7.37846C5.89253 7.40439 5.81746 7.41761 5.73975 7.41761C5.66194 7.41761 5.56757 7.38111 5.45652 7.30819C5.3455 7.23526 5.23028 7.13509 5.11085 7.00751C4.99143 6.8799 4.85674 6.70158 4.70674 6.47251C4.55685 6.24345 4.40133 5.97272 4.24027 5.66033L4.10701 5.43378C4.02371 5.28804 3.90991 5.07582 3.76551 4.79733C3.62102 4.51872 3.49331 4.24923 3.38229 3.9889C3.33791 3.87956 3.27124 3.79632 3.18239 3.73904L3.14069 3.71554C3.11297 3.69476 3.06848 3.67268 3.00744 3.64916C2.94631 3.62566 2.88253 3.60881 2.81582 3.59844L0.533257 3.61398C0.300008 3.61398 0.141747 3.66352 0.0584144 3.76246L0.0250639 3.80926C0.00840327 3.83533 0 3.87696 0 3.93427C0 3.99155 0.0166606 4.06185 0.0500111 4.14509C0.383224 4.87928 0.745586 5.58735 1.1371 6.26941C1.52861 6.95146 1.86882 7.50087 2.15754 7.91715C2.44631 8.33373 2.74066 8.7269 3.04058 9.09645C3.3405 9.46615 3.53903 9.70307 3.63617 9.80715C3.73342 9.91142 3.8098 9.98938 3.86533 10.0414L4.07363 10.2288C4.20692 10.3538 4.40264 10.5035 4.6609 10.6779C4.91921 10.8524 5.20518 11.0242 5.51896 11.1935C5.8328 11.3626 6.19791 11.5006 6.61448 11.6073C7.031 11.7141 7.4364 11.757 7.83074 11.7363H8.78877C8.98307 11.7206 9.13027 11.6633 9.23032 11.5644L9.26347 11.5253C9.28576 11.4942 9.30662 11.4459 9.32588 11.381C9.34537 11.3159 9.35506 11.2442 9.35506 11.1662C9.34937 10.9424 9.36755 10.7406 9.40909 10.561C9.45061 10.3815 9.49794 10.2461 9.55087 10.1549C9.60377 10.0638 9.66347 9.98695 9.72991 9.92464C9.79649 9.86219 9.84394 9.82435 9.87177 9.81133C9.89943 9.79823 9.92152 9.78934 9.93818 9.78401C10.0715 9.74237 10.2283 9.78269 10.409 9.90516C10.5895 10.0275 10.7588 10.1786 10.9172 10.3581C11.0755 10.5379 11.2657 10.7395 11.4878 10.9633C11.71 11.1873 11.9044 11.3537 12.0709 11.4632L12.2375 11.5569C12.3487 11.6195 12.4931 11.6767 12.6708 11.7288C12.8483 11.7808 13.0037 11.7938 13.1372 11.7678L15.2698 11.7366C15.4807 11.7366 15.6448 11.7039 15.7612 11.6389C15.8779 11.5739 15.9472 11.5022 15.9695 11.4242C15.9918 11.3461 15.993 11.2575 15.9738 11.1585C15.954 11.0597 15.9346 10.9907 15.9152 10.9516Z"
                              fill="white"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0">
                            <rect width="16" height="15" fill="white"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </a>
            <a target="_blank" href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"
                     class="img_svg replaced-svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M15.3149 4.68994C13.9038 3.27881 12.0288 2.5 10.0317 2.5C5.91553 2.5 2.56348 5.84961 2.56348 9.96582C2.56103 11.2817 2.90527 12.5659 3.55957 13.6987L2.5 17.5684L6.45996 16.5283C7.54883 17.124 8.7793 17.4365 10.0293 17.439H10.0317C14.1479 17.439 17.4976 14.0894 17.5 9.9707C17.5 7.97607 16.7236 6.10107 15.3149 4.68994ZM10.0317 16.1768H10.0293C8.91602 16.1768 7.82227 15.8765 6.87012 15.3125L6.64307 15.1782L4.29199 15.7935L4.91943 13.5034L4.77295 13.269C4.15039 12.2803 3.82324 11.1377 3.82324 9.96582C3.82324 6.54541 6.60889 3.76221 10.0342 3.76221C11.6919 3.76221 13.2495 4.40918 14.4214 5.58106C15.5933 6.75537 16.2378 8.31299 16.2378 9.9707C16.2378 13.3936 13.4521 16.1768 10.0317 16.1768ZM13.4351 11.5283C13.2495 11.4355 12.3315 10.9839 12.1606 10.9229C11.9897 10.8594 11.8652 10.8301 11.7407 11.0156C11.6162 11.2036 11.2598 11.6235 11.1499 11.748C11.0425 11.8701 10.9326 11.8872 10.7471 11.7944C10.5591 11.7017 9.9585 11.5039 9.24561 10.8667C8.69141 10.3735 8.31543 9.76074 8.20801 9.5752C8.09814 9.38721 8.1958 9.28711 8.28857 9.19434C8.37402 9.11133 8.47656 8.97705 8.56934 8.86719C8.66211 8.75977 8.69385 8.68164 8.75732 8.55713C8.81836 8.43262 8.78662 8.32275 8.74023 8.22998C8.69385 8.13721 8.32031 7.2168 8.16406 6.84326C8.0127 6.47949 7.85889 6.53076 7.74414 6.52344C7.63672 6.51856 7.51221 6.51856 7.3877 6.51856C7.26318 6.51856 7.06055 6.56494 6.88965 6.75293C6.71875 6.93848 6.23779 7.39014 6.23779 8.30811C6.23779 9.22607 6.90674 10.1147 6.99951 10.2393C7.09228 10.3613 8.31543 12.2461 10.188 13.0542C10.6323 13.2471 10.979 13.3618 11.25 13.4473C11.6968 13.5889 12.1045 13.5693 12.4268 13.5229C12.7856 13.4692 13.5303 13.0713 13.6865 12.6343C13.8403 12.1997 13.8403 11.8262 13.7939 11.748C13.7476 11.6699 13.623 11.6235 13.4351 11.5283Z"
                          fill="#7491A5" fill-opacity="0.6"></path>
                </svg>
            </a>
            <a target="_blank" href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none"
                     class="img_svg replaced-svg">
                    <path d="M9.81209 2.5C8.62459 2.5 5.68734 2.62476 4.12484 4.12476C2.99984 5.18726 2.56258 6.8125 2.50008 8.75C2.37508 11.8125 3.06209 13.7498 4.18709 14.7498C4.43709 14.9373 5.06258 15.438 6.25008 15.813V17.3755C6.25008 17.3755 6.24984 18 6.62484 18.125C6.68734 18.125 6.75032 18.1873 6.81282 18.1873C7.18782 18.1873 7.49959 17.7495 7.93709 17.312C8.31209 16.8745 8.62484 16.5625 8.81234 16.25H9.68758H10.1881C11.3756 16.25 14.3128 16.1252 15.8753 14.6252C17.0003 13.5002 17.4378 11.8745 17.4378 9.81201C17.5003 9.49951 17.5001 9.125 17.5001 8.75C17.4376 6.4375 16.7506 4.87524 15.8131 4.00024C15.4381 3.68774 13.8126 2.5 10.3126 2.5H9.81209ZM9.68758 3.68774H10.1246H10.1881H10.2503C13.5628 3.68774 14.8128 4.75049 14.9378 4.87549C15.6878 5.50049 16.1253 6.87524 16.1878 8.68774V8.93799C16.2503 9.31299 16.2501 9.62451 16.2501 9.81201C16.1876 11.687 15.8123 12.9375 15.0623 13.75C13.7498 14.9375 11.0003 15 10.2503 15H9.81209H9.74984H9.68758H9.06258L8.06282 16.1255L7.43782 16.8127L7.31209 16.9995C7.18709 17.1245 7.00008 17.3752 6.87508 17.4377V17.312V14.6252C5.62508 14.3127 5.12508 13.875 5.00008 13.75C4.12508 13 3.62508 11.1875 3.75008 8.75V8.125C3.87508 6.625 4.25057 5.62524 4.87557 4.93774C6.18807 3.75024 8.93758 3.68774 9.68758 3.68774ZM9.62532 5.06226C9.31282 5.06226 9.31282 5.50049 9.62532 5.50049C11.9378 5.50049 13.9381 7.0625 13.9381 10C13.9381 10.3125 14.3751 10.3125 14.3751 10C14.3751 6.8125 12.2503 4.99976 9.62532 5.06226ZM7.14852 5.64087C7.01571 5.62524 6.87557 5.65576 6.75057 5.74951C6.12557 6.06201 5.49984 6.68799 5.68734 7.37549C5.68734 7.37549 5.81282 7.93726 6.50032 9.12476C6.87532 9.68726 7.18758 10.1877 7.50008 10.5627C7.81258 11.0002 8.31234 11.5 8.81234 11.875C9.81234 12.6875 11.3756 13.5002 12.0631 13.6877C12.6881 13.8752 13.3753 13.2495 13.6878 12.6245C13.8128 12.3745 13.7498 12.0625 13.4998 11.875C13.1248 11.5 12.5006 11.063 12.0631 10.813C11.7506 10.6255 11.3751 10.75 11.2501 10.9375L10.9376 11.3123C10.8126 11.4998 10.5006 11.5002 10.5006 11.5002C8.43807 10.9377 7.87484 8.81226 7.87484 8.81226C7.87484 8.81226 7.87532 8.56274 8.06282 8.37524L8.43758 8.06274C8.62508 7.93774 8.74959 7.56226 8.56209 7.24976C8.43709 7.06226 8.25032 6.68774 8.06282 6.50024C7.87532 6.25024 7.50008 5.81299 7.50008 5.81299C7.40633 5.71924 7.28133 5.65649 7.14852 5.64087ZM10.0623 6.31226C9.74984 6.24976 9.68758 6.75049 10.0001 6.75049C11.7501 6.87549 12.7506 8.06299 12.6881 9.56299C12.6256 9.87549 13.1251 9.87549 13.1251 9.56299C13.1876 7.81299 12.0623 6.37476 10.0623 6.31226ZM10.2503 7.5C9.93782 7.4375 9.93782 7.93701 10.2503 7.93701C11.0003 7.93701 11.3746 8.37476 11.3746 9.12476C11.4371 9.43726 11.8751 9.43726 11.8751 9.12476C11.8126 8.12476 11.2503 7.5 10.2503 7.5Z"
                          fill="#7491A5" fill-opacity="0.6"></path>
                </svg>
            </a>
        </div>
    </div>
    <div id="menu_mob" class="fix_menu">
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'menu_class' => 'menu',
            'theme_location' => 'head_menu_mobile',
            'container' => false,
            'walker' => new macho_bootstrap_walker()
        ));
        ?>
    </div>
</div>
<div id="detect-town">
    <div class="wrapper">
        <div class="detect-town-inner">
            <div class="detect-town-title">Ваш город - <span><?php echo get_option('options_city_for_list'); ?>?</span>
            </div>
            <div class="detect-town-buttons">
                <a href="#" class="btn-town-yes">Да</a>
                <a href="#select_city" class="open_modal btn-town-no">Выбрать другой регион</a>
            </div>
        </div>
    </div>
</div>