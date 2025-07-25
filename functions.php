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
    wp_enqueue_style('toppage-style', get_stylesheet_uri(), array(), '1.35');
    
    // タブメニューのスタイルを読み込み
    wp_enqueue_style('tab-menu-style', get_template_directory_uri() . '/tab-menu.css', array(), '1.1');
    
    // Prism.js for code highlighting
    // wp_enqueue_style('prism-css', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css', array(), '1.29.0');
    
    // jQueryを読み込み（WordPressに含まれているもの）
    wp_enqueue_script('jquery');
    
    // Prism.js scripts
    // if (is_single()) {
    //     wp_enqueue_script('prism-core', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js', array(), '1.29.0', true);
    //     wp_enqueue_script('prism-autoloader', 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js', array('prism-core'), '1.29.0', true);
    // }
    
    // コードブロック専用スタイルシートを読み込み
    wp_enqueue_style('code-blocks', get_template_directory_uri() . '/assets/css/code-blocks.css', array(), '1.0');

    // コードブロック用のJavaScript（必要に応じて）
    wp_enqueue_script('code-blocks', get_template_directory_uri() . '/assets/js/code-blocks.js', array('jquery'), '1.0', true);
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

// コードブロックのラッパーを保護（WordPress自動整形を防ぐ）
function preserve_code_blocks($content) {
    // code-block-wrapperクラスを持つ要素内でのWordPress自動整形を防ぐ
    if (has_filter('the_content', 'wpautop')) {
        $content = preg_replace_callback(
            '/<div class="code-block-wrapper">(.*?)<\/div>/s',
            function($matches) {
                return str_replace(array('<p>', '</p>', '<br />'), '', $matches[0]);
            },
            $content
        );
    }
    return $content;
}
add_filter('the_content', 'preserve_code_blocks', 9);
?>