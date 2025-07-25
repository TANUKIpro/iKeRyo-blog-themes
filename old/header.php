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
    
    <!-- Prism.js for code highlighting -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
    <!-- Prism.js プラグインのCSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-highlight/prism-line-highlight.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.css" rel="stylesheet" />
    
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
            width: 90%;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* 画面サイズ別の幅調整 */
        @media (min-width: 1400px) {
            .container {
                width: 85%;
            }
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .container {
                width: 88%;
            }
        }

        @media (min-width: 768px) and (max-width: 1199px) {
            .container {
                width: 95%;
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
            position: sticky;
            top: 80px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }

        .toc-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f3f4f6;
        }

        .toc-list {
            list-style: none;
            padding: 0;
        }

        .toc-item {
            margin-bottom: 8px;
        }

        .toc-link {
            display: block;
            padding: 6px 12px;
            color: #6b7280;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            line-height: 1.4;
        }

        .toc-link:hover {
            background: #f3f4f6;
            color: #3b82f6;
        }

        .toc-link.active {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }

        /* 目次の階層表示 */
        .toc-level-2 { padding-left: 24px; font-size: 0.9rem; }
        .toc-level-3 { padding-left: 48px; font-size: 0.85rem; }
        .toc-level-4 { padding-left: 72px; font-size: 0.85rem; }
        .toc-level-5 { padding-left: 96px; font-size: 0.8rem; }
        .toc-level-6 { padding-left: 120px; font-size: 0.8rem; }

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

        /* コードブロックのPythonスタイルを優先 */
        .post-body pre {
            /* Pythonが設定するスタイルを尊重 */
            margin: 1.5rem 0 !important;
            border-radius: 8px !important;
            overflow: visible !important;
            padding: 0 !important;
            background: transparent !important;
        }

        .post-body pre[class*="language-"] {
            /* Pythonが設定するインラインスタイルを優先 */
            padding: inherit !important;
            font-size: inherit !important;
            line-height: inherit !important;
            background-color: inherit !important;
            margin: inherit !important;
        }

        /* Pythonで生成されたコードブロックの言語ラベルを尊重 */
        .post-body pre > div[style*="position: absolute"] {
            /* 言語ラベルのスタイルを維持 */
        }

        /* 行番号のスタイル */
        .post-body .code-line {
            display: flex !important;
            position: relative !important;
        }

        .post-body .line-number {
            /* 行番号のスタイルを維持 */
            user-select: none !important;
        }

        /* 行ハイライトのスタイル */
        .post-body .line-highlight {
            /* ハイライトのスタイルを維持 */
        }

        /* Prism.js toolbar のカスタマイズ */
        .post-body .toolbar {
            opacity: 1 !important;
        }

        /* 画像の中央寄せと最適化 */
        .post-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1.5rem auto;
            display: block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            text-align: center;
        }

        .post-body .wp-caption {
            max-width: 100%;
            margin: 1.5rem auto;
            text-align: center;
        }

        .post-body .wp-caption img {
            margin: 0 auto;
        }

        /* テーブルのスタイル改善 */
        .post-body table {
            width: 100%;
            margin: 1.5rem 0;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .post-body table thead {
            background: #f8fafc;
            border-bottom: 2px solid #e5e7eb;
        }

        .post-body table th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #1f2937;
            font-size: 0.9rem;
        }

        .post-body table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.95rem;
        }

        .post-body table tbody tr:last-child td {
            border-bottom: none;
        }

        .post-body table tbody tr:hover {
            background: #f9fafb;
        }

        .post-body table tbody tr:nth-child(even) {
            background: #fcfcfc;
        }

        /* URLカード */
        .url-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            margin: 1.5rem 0;
            background: white;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .url-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .url-card-image {
            width: 120px;
            height: 90px;
            background: #f3f4f6;
            border-radius: 6px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #d1d5db;
        }

        .url-card-content {
            flex: 1;
            min-width: 0;
        }

        .url-card-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .url-card-url {
            font-size: 0.8rem;
            color: #6b7280;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* 記事ナビゲーション */
        .post-navigation {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 32px 0;
            border-top: 1px solid #e5e7eb;
            margin-top: 48px;
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

        /* 大画面での目次固定 */
        @media (min-width: 1401px) {
            .toc-sidebar:not(.toc-above-content) {
                position: fixed;
                top: 100px;
                width: 300px;
                z-index: 99999;
            }
        }

        /* 目次が記事上部に配置される場合 */
        .toc-sidebar.toc-above-content .toc-container {
            border: 2px solid #fbbf24;
            background: #fffbeb;
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

            .url-card {
                flex-direction: column;
                text-align: center;
            }

            .url-card-content {
                text-align: left;
            }

            /* テーブルのレスポンシブ対応 */
            .post-body table {
                font-size: 0.85rem;
            }

            .post-body table th,
            .post-body table td {
                padding: 8px 12px;
            }
        }

        /* 大画面での最適化 */
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
    </style>
    
    <!-- Prism.js for code highlighting -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-markup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-sql.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-json.min.js"></script>
    <!-- Prism.js プラグイン -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-highlight/prism-line-highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="header">
    <div class="container">
        <a href="<?php echo home_url(); ?>" class="site-title">iKeRyo Blog</a>
    </div>
</header>