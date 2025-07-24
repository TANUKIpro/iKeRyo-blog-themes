<?php
function toppage_theme_setup() {
    // テーマサポートを追加
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // アイキャッチ画像のサイズを定義
    add_image_size('post-thumbnail', 800, 400, true);
}
add_action('after_setup_theme', 'toppage_theme_setup');

function toppage_scripts() {
    // メインスタイルシートを読み込み
    wp_enqueue_style('toppage-style', get_stylesheet_uri(), array(), '1.2');
    
    // jQueryを読み込み（WordPressに含まれているもの）
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'toppage_scripts');

// Gravatarのデフォルト画像を設定
function toppage_custom_gravatar($avatar_defaults) {
    $avatar_defaults['mm'] = 'Mystery Person';
    return $avatar_defaults;
}
add_filter('avatar_defaults', 'toppage_custom_gravatar');

// 記事の抜粋文字数を調整
function toppage_excerpt_length($length) {
    return 50;
}
add_filter('excerpt_length', 'toppage_excerpt_length');

// 記事の抜粋の末尾を変更
function toppage_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'toppage_excerpt_more');

// セキュリティ強化：不要な情報を隠す
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');

// 管理バーを非表示（フロントエンド）
add_filter('show_admin_bar', '__return_false');

// カスタムログイン画面のスタイル
function toppage_login_styles() {
    ?>
    <style>
        .login h1 a {
            background-image: none;
            width: auto;
            height: auto;
            text-indent: 0;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .login h1 a:before {
            content: 'iKeRyo Blog';
        }
    </style>
    <?php
}
add_action('login_head', 'toppage_login_styles');

// ログイン画面のロゴリンクを変更
function toppage_login_logo_url() {
    return home_url();
}
add_filter('login_headerurl', 'toppage_login_logo_url');

function toppage_login_logo_url_title() {
    return 'iKeRyo Blog';
}
add_filter('login_headertext', 'toppage_login_logo_url_title');
?>