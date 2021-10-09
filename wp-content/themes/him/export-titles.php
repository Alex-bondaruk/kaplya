<?php /* Template Name: Test */ ?>
<?php get_header();
?>
    <div id="export_titles_wrap">
        <div class="wrapper">
            <div class="title">Экспорт titles</div>
            <form id="export_titles" method="post" action="/export-titles/">
                <div class="modal_form_field">
                    <label for="file_name">Путь расположение файла:</label>
                    <input type="text" name="file_name" value="/wp-content/uploads/csv/titles.csv">
                </div>
                <div class="modal_form_submit">
                    <input class="submit" type="submit" value="Экспортировать">
                </div>
            </form>

<?php
if (!$_REQUEST['file_name']) {
    echo '</div></div>';
    get_footer();
    return '';
}
$sites = get_sites();
$currentSite = get_current_blog_id();
$sitesBlogIds = [];
foreach ($sites as $site) {
    $sitesBlogIds[] = $site->blog_id;
}

$pagesArr = [];
foreach ($sitesBlogIds as $blogId) {
    switch_to_blog($blogId);
    $detailCurrentBlog = get_blog_details($blogId);
    $sitesBlogIdsImplode = implode(',', $sitesBlogIds);
    $args = [
        'post_status' => 'publish',
        'post__not_in' => array(1619),
        'category__not_in' => array(1, 20, 44, 45),
        'posts_per_page' => -1,
        'post_type' => array('service', 'page', 'post')
    ];
    $pages = new WP_Query($args);
    foreach ($pages->posts as $key => $post) {
        $pagesArr[$key . '_' . $blogId]['site_url'] = $detailCurrentBlog->domain . $detailCurrentBlog->path;
        $pagesArr[$key . '_' . $blogId]['site_id'] = $blogId;
        $pagesArr[$key . '_' . $blogId]['id'] = $post->ID;
        $pagesArr[$key . '_' . $blogId]['name'] = iconv("utf-8", "windows-1251", $post->post_title);
        $pagesArr[$key . '_' . $blogId]['url'] = iconv("utf-8", "windows-1251", $post->post_name);
        $pagesArr[$key . '_' . $blogId]['title'] = iconv("utf-8", "windows-1251", YoastSEO()->meta->for_post($post->ID)->title);
    }
    restore_current_blog();
}
wp_reset_postdata();
$firstLine = array('site_url', 'site_id', 'id', 'name', 'url', 'title');
array_unshift($pagesArr, $firstLine);

$file = fopen($_SERVER["DOCUMENT_ROOT"] . "/wp-content/uploads/csv/titles.csv", "w");
//add BOM to fix UTF-8 in Excel
fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
foreach ($pagesArr as $line) {
    fputcsv($file, $line, ";");
}
fclose($file);
echo 'Файл создан по пути - /wp-content/uploads/csv/titles.csv <br>';
echo 'Скачать файл - <a style="color:blue;" href="/wp-content/uploads/csv/titles.csv" download>titles.csv</a></div></div>';

get_footer();