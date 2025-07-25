<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php if (is_home() || is_front_page()) : ?>
            <?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>
        <?php else : ?>
            <?php the_title(); ?> - <?php bloginfo('name'); ?>
        <?php endif; ?>
    </title>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
    <div class="container">
        <div class="header-content">
            <a href="<?php echo home_url(); ?>" class="site-title">iKeRyo Blog</a>
            
            <!-- タブメニュー（タイトルの下に配置） -->
            <nav class="tab-menu">
                <ul class="tab-menu-list">
                    <li class="tab-menu-item <?php echo is_front_page() ? 'active' : ''; ?>">
                        <a href="<?php echo home_url(); ?>" class="tab-menu-link">Top</a>
                    </li>
                    <li class="tab-menu-item <?php echo (is_home() && !is_front_page()) || is_single() || is_archive() || is_search() ? 'active' : ''; ?>">
                        <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="tab-menu-link">記事</a>
                    </li>
                    <li class="tab-menu-item <?php echo is_page('category-tag') ? 'active' : ''; ?>">
                        <a href="<?php echo home_url('/category-tag'); ?>" class="tab-menu-link">カテゴリ・タグ</a>
                    </li>
                    <li class="tab-menu-item <?php echo is_page('shop') ? 'active' : ''; ?>">
                        <a href="<?php echo home_url('/shop'); ?>" class="tab-menu-link">SHOP</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<style>
/* 個別記事ページ専用のスタイル */
<?php if (is_single()) : ?>
    /* メインレイアウト */
    .main-layout {
        display: flex;
        gap: 40px;
        position: relative;
    }

    .content-area {
        flex: 1;
        min-width: 0;
    }

    /* 目次サイドバー */
    .toc-sidebar {
        width: 300px;
        flex-shrink: 0;
    }

    /* 目次コンテナ */
    .toc-container {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
    }

    .toc-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e5e7eb;
        text-align: center;
    }

    /* 目次リスト */
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .toc-item {
        margin-bottom: 4px;
    }

    .toc-link {
        display: block;
        padding: 6px 8px;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.85rem;
        line-height: 1.4;
        transition: all 0.2s ease;
        border-radius: 4px;
        border-left: 3px solid transparent;
    }

    .toc-link:hover {
        color: #3b82f6;
        background: #f8fafc;
    }

    .toc-link.active {
        color: #3b82f6;
        background: #eff6ff;
        border-left-color: #3b82f6;
        font-weight: 600;
    }

    /* 階層レベル別スタイル */
    .toc-level-1 { padding-left: 0; font-weight: 700; }
    .toc-level-2 { padding-left: 0; font-weight: 600; }
    .toc-level-3 { padding-left: 20px; }
    .toc-level-4 { padding-left: 40px; }
    .toc-level-5 { padding-left: 60px; }
    .toc-level-6 { padding-left: 80px; }

    /* 記事コンテンツ */
    .post-content {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 50px;
        margin-bottom: 40px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        width: 100%;
        min-width: 800px;
        position: relative;
    }

    /* 記事メタ情報 */
    .post-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .post-date {
        font-weight: 500;
    }

    .post-category {
        background: #eff6ff;
        color: #2563eb;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
    }

    .post-category:hover {
        background: #dbeafe;
    }

    .post-status {
        background: #fef3c7;
        color: #92400e;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* 記事タイトル */
    .post-title {
        font-size: 2.25rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.3;
        margin-bottom: 32px;
    }

    /* 記事本文 */
    .post-body {
        width: 100%;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #374151;
    }

    .post-body p {
        margin-bottom: 1.5rem;
    }

    .post-body h1,
    .post-body h2,
    .post-body h3,
    .post-body h4,
    .post-body h5,
    .post-body h6 {
        color: #1f2937;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
        line-height: 1.4;
        scroll-margin-top: 100px;
    }

    .post-body h1 { font-size: 2rem; }
    .post-body h2 { font-size: 1.75rem; }
    .post-body h3 { font-size: 1.5rem; }
    .post-body h4 { font-size: 1.25rem; }

    .post-body ul,
    .post-body ol {
        margin-bottom: 1.5rem;
        padding-left: 1.2rem;
    }

    .post-body li {
        margin-bottom: 0.5rem;
    }

    .post-body blockquote {
        border-left: 4px solid #3b82f6;
        background: #f8fafc;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
    }

    /* インラインコード */
    .post-body code:not([class*="language-"]) {
        background: #f1f5f9;
        color: #e11d48;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        font-size: 0.9rem;
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
    }

    /* URLカード */
    .url-card {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 1.5rem 0;
        padding: 12px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        color: #374151;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    .url-card:hover {
        background: #f1f5f9;
        border-color: #3b82f6;
        transform: translateY(-1px);
    }

    .url-card-image {
        width: 48px;
        height: 48px;
        background: #e5e7eb;
        border-radius: 6px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .url-card-content {
        flex: 1;
        min-width: 0;
    }

    .url-card-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .url-card-url {
        color: #6b7280;
        font-size: 0.8rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* タグ表示 */
    .post-tags {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #f3f4f6;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .post-tags a {
        color: #3b82f6;
        text-decoration: none;
    }

    .post-tags a:hover {
        text-decoration: underline;
    }

    /* ナビゲーション */
    .post-navigation {
        background: white;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        padding: 24px;
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        width: 100%;
    }

    .nav-link {
        flex: 1;
        text-decoration: none;
        color: #374151;
        transition: color 0.2s ease;
    }

    .nav-link:hover {
        color: #3b82f6;
    }

    .nav-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .nav-title {
        font-weight: 600;
    }

    .nav-prev {
        text-align: left;
    }

    .nav-next {
        text-align: right;
    }

    /* 大画面での目次固定 */
    @media (min-width: 1401px) {
        .toc-sidebar {
            position: fixed;
            top: 100px;
            right: calc((100vw - 1600px) / 2 + 20px);
            width: 300px;
            z-index: 99999;
        }
    }

    /* 超大画面での最適化 */
    @media (min-width: 1600px) {
        .main-layout {
            max-width: 2200px;
        }
    }

    @media (min-width: 1920px) {
        .main-layout {
            max-width: 2400px;
        }

        .toc-sidebar {
            width: 320px;
            right: calc((100vw - 1920px) / 2 + 20px);
        }
    }

    @media (min-width: 2000px) {
        .main-layout {
            max-width: 2600px;
        }

        .post-content {
            padding: 60px;
        }

        .toc-sidebar {
            width: 350px;
        }
    }

    @media (min-width: 2560px) {
        .main-layout {
            max-width: 3000px;
        }
    }

    /* レスポンシブ - 1400px以下 */
    @media (max-width: 1400px) {
        .main-layout {
            display: block;
        }

        .toc-sidebar {
            position: static;
            width: 100%;
            margin-bottom: 30px;
        }

        .toc-container {
            max-height: 300px;
            overflow-y: auto;
            background: #f8fafc;
        }

        .post-content {
            min-width: auto;
        }
    }

    @media (max-width: 768px) {
        .container {
            padding: 0 16px;
        }

        .main-layout {
            padding: 0 10px;
        }

        .post-content {
            padding: 24px;
        }

        .post-title {
            font-size: 1.8rem;
        }

        .post-body {
            font-size: 1rem;
        }

        .post-navigation {
            flex-direction: column;
        }

        .nav-next {
            text-align: left;
        }
    }
<?php endif; ?>
</style>