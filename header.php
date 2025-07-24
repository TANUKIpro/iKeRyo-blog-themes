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
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: #333;
            background-color: #fafafa;
        }

        .container {
            max-width: none; /* 固定値を削除 */
            width: 90%; /* 基本は90%幅 */
            margin: 0 auto;
            padding: 0 20px;
        }

        /* 画面サイズ別の幅調整 */
        @media (min-width: 1400px) {
            .container {
                width: 85%; /* 大画面では少し狭めに */
            }
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .container {
                width: 88%; /* 中大画面 */
            }
        }

        @media (min-width: 768px) and (max-width: 1199px) {
            .container {
                width: 95%; /* タブレット・小さめのPC */
            }
        }

        /* ヘッダー */
        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 20px 0;
            margin-bottom: 40px;
            position: relative;
            z-index: 100;
        }

        .site-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
        }

        .site-title:hover {
            color: #3b82f6;
        }

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

        /* 目次 */
        .toc-sidebar {
            width: 200px;
            flex-shrink: 0;
        }

        /* 目次コンテナ */
        body .toc-container,
        .toc-sidebar .toc-container {
            position: static !important;
            top: auto !important;
            background: rgba(255, 255, 255, 0.98) !important;
            border: 1px solid #e5e7eb !important; /* デバッグ用青枠を通常に戻す */
            border-radius: 12px !important;
            padding: 24px !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            max-height: 100% !important;
            overflow-y: auto !important;
            z-index: auto !important;
            backdrop-filter: blur(10px) !important;
        }

        .toc-title {
            font-size: 1rem !important;
            font-weight: 700 !important;
            color: #1f2937 !important;
            margin-bottom: 16px !important;
            padding-bottom: 10px !important;
            border-bottom: 2px solid #e5e7eb !important;
            text-align: center !important;
        }

        .toc-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #f3f4f6;
        }

        /* 目次の階層構造スタイル */
        .toc-list {
            list-style: none;
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
        .toc-level-2 { 
            padding-left: 0;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .toc-level-3 { 
            padding-left: 16px;
            font-size: 0.85rem;
            font-weight: 500;
            position: relative;
        }
        
        .toc-level-3::before {
            content: "└";
            position: absolute;
            left: 8px;
            color: #d1d5db;
        }
        
        .toc-level-4 { 
            padding-left: 32px;
            font-size: 0.8rem;
            font-weight: 400;
            position: relative;
        }
        
        .toc-level-4::before {
            content: "└";
            position: absolute;
            left: 24px;
            color: #d1d5db;
        }

        .toc-level-5,
        .toc-level-6 { 
            padding-left: 48px;
            font-size: 0.75rem;
            font-weight: 400;
            color: #9ca3af;
            position: relative;
        }
        
        .toc-level-5::before,
        .toc-level-6::before {
            content: "└";
            position: absolute;
            left: 40px;
            color: #d1d5db;
        }

        /* 記事コンテンツ */
        .post-content {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 50px;
            margin-bottom: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            width: 100% !important; /* 強制的に親要素の幅を使用 */
            min-width: 800px; /* 最小幅を保証 */
            position: relative; /* 位置を確実に */
        }

        /* 記事本文の最適な読みやすさを保つ */
        .post-body {
            max-width: none !important; /* 制限を一時的に解除 */
            width: 100%; /* 親要素の幅を使用 */
            font-size: 1.1rem;
            line-height: 1.8;
            color: #374151;
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
            max-width: none !important; /* 制限を解除 */
            width: 100%; /* 親要素の幅を使用 */
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
            scroll-margin-top: 100px; /* スクロール時のオフセット */
        }

        .post-body h1 { font-size: 2rem; }
        .post-body h2 { font-size: 1.75rem; }
        .post-body h3 { font-size: 1.5rem; }
        .post-body h4 { font-size: 1.25rem; }

        .post-body ul,
        .post-body ol {
            margin-bottom: 1.5rem;
            padding-left: 1.2rem; /* リストの幅を狭める */
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

        .post-body code {
            background: #f1f5f9;
            color: #e11d48;
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-size: 0.9rem;
            font-family: 'Courier New', monospace;
        }

        .post-body pre {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1.5rem;
            border-radius: 8px;
            overflow-x: auto;
            margin: 1.5rem 0;
        }

        .post-body pre code {
            background: none;
            color: inherit;
            padding: 0;
        }

        .post-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem 0;
        }

        /* 画像キャプション */
        .post-body figcaption,
        .post-body .wp-caption-text {
            font-size: 0.8rem;
            color: #6b7280;
            text-align: center;
            margin-top: 0.5rem;
            font-style: italic;
            line-height: 1.4;
        }

        .post-body figure {
            margin: 1.5rem 0;
        }

        .post-body .wp-caption {
            max-width: 100%;
            margin: 1.5rem 0;
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

        .url-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin: 0;
        }

        .url-card-image .placeholder {
            color: #9ca3af;
            font-size: 1.2rem;
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

        .post-body a {
            color: #3b82f6;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .post-body a:hover {
            border-bottom-color: #3b82f6;
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
            max-width: none !important; /* 制限を解除 */
            width: 100%; /* 親要素の幅を使用 */
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

        /* フッター */
        .footer {
            text-align: center;
            padding: 40px 0;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .back-to-home {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .back-to-home:hover {
            background: #2563eb;
        }

        /* 大画面での目次固定（追加保証） */
        @media (min-width: 1401px) {
            body .toc-sidebar:not(.toc-above-content),
            .container .toc-sidebar:not(.toc-above-content) {
                position: fixed !important;
                top: 100px !important;
                width: 300px !important;
                z-index: 99999 !important;
                /* right は JavaScript で動的に設定 */
            }
        }

        /* 目次が記事上部に配置される場合の追加スタイル */
        .toc-sidebar.toc-above-content .toc-container {
            border: 2px solid #fbbf24 !important; /* 上部配置時は黄色枠 */
            background: #fffbeb !important; /* 薄い黄色背景 */
        }

        /* レスポンシブ - 1400px以下は完全に通常配置 */
        @media (max-width: 1400px) {
            .main-layout {
                display: block !important; /* flexを完全解除 */
                max-width: 95% !important;
                margin: 0 auto !important;
                padding: 0 20px !important;
            }

            /* 目次を完全に通常配置にリセット */
            body .toc-sidebar,
            .container .toc-sidebar,
            .main-layout .toc-sidebar,
            .toc-sidebar.toc-above-content {
                position: static !important; /* 固定を完全解除 */
                top: auto !important;
                right: auto !important;
                left: auto !important;
                width: 100% !important; /* 全幅に */
                max-width: 100% !important;
                height: auto !important;
                max-height: none !important;
                margin: 0 0 30px 0 !important; /* 下マージンのみ */
                padding: 0 !important;
                z-index: auto !important;
                transform: none !important;
                display: block !important;
                float: none !important;
                overflow: visible !important;
            }

            /* 目次コンテナのリセット */
            body .toc-container,
            .toc-sidebar .toc-container,
            .toc-sidebar.toc-above-content .toc-container {
                position: static !important;
                width: 100% !important;
                max-width: 100% !important;
                height: auto !important;
                max-height: 300px !important; /* 最大高さを制限 */
                margin: 0 !important;
                padding: 20px !important;
                background: #f8fafc !important; /* 薄いグレー背景 */
                border: 1px solid #e5e7eb !important;
                border-radius: 8px !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
                overflow-y: auto !important; /* スクロール可能 */
                backdrop-filter: none !important;
            }

            /* コンテンツエリアのリセット */
            .content-area {
                width: 100% !important;
                max-width: none !important;
                min-width: auto !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .post-content {
                width: 100% !important;
                min-width: auto !important;
                margin: 0 0 40px 0 !important;
            }

            .post-body {
                max-width: none !important;
                width: 100% !important;
            }

            .post-navigation {
                max-width: none !important;
                width: 100% !important;
            }

            /* 目次タイトルを小画面用に調整 */
            .toc-title {
                font-size: 0.9rem !important;
                text-align: left !important;
                padding-bottom: 8px !important;
                margin-bottom: 12px !important;
            }

            /* 目次リストを小画面用に調整 */
            .toc-list {
                max-height: 200px !important;
                overflow-y: auto !important;
            }

            .toc-link {
                font-size: 0.8rem !important;
                padding: 4px 6px !important;
            }

            .toc-level-3 { padding-left: 12px !important; }
            .toc-level-4 { padding-left: 24px !important; }
            .toc-level-5, .toc-level-6 { padding-left: 36px !important; }
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
                max-width: none; /* モバイルでは幅制限なし */
            }

            .post-navigation {
                flex-direction: column;
                max-width: none; /* モバイルでは幅制限なし */
            }

            .nav-next {
                text-align: left;
            }

            .url-card {
                flex-direction: column;
                text-align: center;
            }

            .url-card-content {
                text-align: left;
            }
        }

        /* 大画面での最適化 */
        @media (min-width: 1600px) {
            .main-layout {
                max-width: 2200px; /* レイアウト全体の最大幅 */
            }
        }

        @media (min-width: 1920px) {
            .main-layout {
                max-width: 2400px; /* フルHD以上での最適化 */
            }

            .toc-sidebar {
                width: 320px; /* 目次を少し広く */
            }
        }

        /* 2K画面以上の超高解像度対応 */
        @media (min-width: 2000px) {
            .main-layout {
                max-width: 2600px; /* 2K画面での最適化 */
            }

            .post-content {
                padding: 60px; /* パディング増加 */
            }

            .toc-sidebar {
                width: 350px; /* 目次をさらに広く */
            }
        }

        /* 4K画面以上の対応 */
        @media (min-width: 2560px) {
            .main-layout {
                max-width: 3000px; /* 4K画面での最適化 */
            }
        }
    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
    <div class="container">
        <a href="<?php echo home_url(); ?>" class="site-title">iKeRyo Blog</a>
    </div>
</header>