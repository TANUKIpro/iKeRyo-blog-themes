<?php get_header(); ?>

<div class="container">
    <div class="main-content">
        <main class="posts-section">
            <h2>ブログ記事</h2>
            <div class="post-list">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="post-item">
                            <div class="post-meta">
                                <time class="post-date"><?php echo get_the_date('Y年n月j日'); ?></time>
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) :
                                    $primary_category = $categories[0];
                                ?>
                                    <span class="post-category"><?php echo esc_html($primary_category->name); ?></span>
                                <?php endif; ?>
                            </div>
                            <h3 class="post-title"><?php the_title(); ?></h3>
                            <p class="post-excerpt">
                                <?php
                                $excerpt = get_the_excerpt();
                                echo wp_trim_words($excerpt, 50, '...');
                                ?>
                            </p>
                        </a>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="post-item">
                        <p>投稿が見つかりません。</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- ページネーション -->
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => '← 前のページ',
                    'next_text' => '次のページ →',
                ));
                ?>
            </div>
        </main>
    </div>
</div>

<style>
/* index.php専用スタイル */
.container {
    max-width: none;
    width: 100%; /* 画面全体を使用 */
    margin: 0 auto;
    padding: 0 20px;
}

.main-content {
    margin-bottom: 60px;
    max-width: 1400px; /* 最大幅を設定 */
    margin: 0 auto 60px auto; /* 中央配置 */
    padding: 0 20px;
}

.posts-section h2 {
    font-size: 1.5rem;
    color: #1f2937;
    margin-bottom: 24px;
    padding-bottom: 8px;
    border-bottom: 2px solid #3b82f6;
}

.post-list {
    background: white;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
    margin-bottom: 32px;
}

.post-item {
    display: block;
    padding: 20px;
    border-bottom: 1px solid #f3f4f6;
    text-decoration: none;
    color: inherit;
    transition: background-color 0.2s ease;
}

.post-item:last-child {
    border-bottom: none;
}

.post-item:hover {
    background-color: #f9fafb;
}

.post-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    font-size: 0.875rem;
    color: #6b7280;
}

.post-date {
    font-weight: 500;
}

.post-category {
    background: #eff6ff;
    color: #2563eb;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.post-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 4px;
    line-height: 1.4;
}

.post-excerpt {
    font-size: 0.9rem;
    color: #6b7280;
    line-height: 1.5;
}

.pagination {
    text-align: center;
}

.pagination .nav-links {
    display: flex;
    justify-content: center;
    gap: 12px;
    align-items: center;
}

.pagination a,
.pagination .current {
    padding: 8px 16px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    text-decoration: none;
    color: #374151;
    transition: all 0.2s ease;
}

.pagination a:hover {
    background: #f9fafb;
    border-color: #3b82f6;
}

.pagination .current {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

@media (max-width: 1200px) {
    .main-content {
        max-width: 95%;
    }
}

@media (max-width: 768px) {
    .container {
        padding: 0 16px;
    }

    .main-content {
        padding: 0 10px;
    }

    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
}
</style>

<?php get_footer(); ?>