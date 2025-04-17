<?php
/*
Plugin Name: 文章寫作好幫手
Description: 能在標題或內文使用 [year] 自動帶入當下年份、能在文章中使用 [postlink]內部連結[/postlink] 產生文章標題超連結，未來就不用手動更新年份與超連結了。
Version: 1.0
Author: 老K＆BRAND 自媒體課程
*/

// [year] 短代碼
if ( !shortcode_exists('year') ) {
    add_shortcode('year', function() {
        return date('Y');
    });
}

// [postlink] 短代碼
if ( !shortcode_exists('postlink') ) {
    function postlink_shortcode( $atts, $content = null ) {
        $post_id = url_to_postid( $content );
        $post_title = get_the_title( $post_id );
        return '<a href="' . esc_url($content) . '" target="_blank">' . esc_html( $post_title ) . '</a>';
    }
    add_shortcode( 'postlink', 'postlink_shortcode' );
}

// 支援 Rank Math 的 SEO 標題使用 [year]
add_filter('rank_math/frontend/title', function ($title) {
    return do_shortcode($title);
});

// 支援文章標題也能使用 [year]
add_filter('the_title', 'do_shortcode');

// 在外掛管理畫面中增加「說明文件」連結
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function($links) {
    $docs_url = 'https://leadingmrk.notion.site/WordPress-1d8884ec6ae480608bc9df9a1770bfc4?pvs=4';
    $links[] = '<a href="' . esc_url($docs_url) . '" target="_blank">說明文件</a>';
    return $links;
});
