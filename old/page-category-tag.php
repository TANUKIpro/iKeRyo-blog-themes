<?php
/*
Template Name: カテゴリ・タグ一覧
*/
get_header(); ?>

<div class="container">
    <div class="category-tag-page">
        <h1 class="page-title">カテゴリ・タグ一覧</h1>
        
        <!-- カテゴリセクション -->
        <section class="category-section">
            <h2 class="section-title">カテゴリ</h2>
            <div class="term-grid">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'hide_empty' => true
                ));
                
                foreach ($categories as $category) :
                ?>
                    <div class="term-card">
                        <h3 class="term-name">
                            <a href="<?php echo get_category_link($category->term_id); ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                        </h3>
                        <span class="term-count"><?php echo $category->count; ?>件の記事</span>
                        <?php if ($category->description) : ?>
                            <p class="term-description"><?php echo esc_html($category->description); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- タグセクション -->
        <section class="tag-section">
            <h2 class="section-title">タグ</h2>
            <div class="tag-cloud-wrapper">
                <?php
                $tags = get_tags(array(
                    'orderby' => 'count',
                    'order' => 'DESC',
                    'hide_empty' => true
                ));
                
                if ($tags) :
                    echo '<div class="tag-cloud">';
                    foreach ($tags as $tag) {
                        $tag_link = get_tag_link($tag->term_id);
                        $tag_size = 1 + ($tag->count / 10); // サイズを記事数に応じて調整
                        if ($tag_size > 2) $tag_size = 2; // 最大サイズを制限
                        
                        echo '<a href="' . $tag_link . '" class="tag-item" style="font-size: ' . $tag_size . 'rem;">';
                        echo esc_html($tag->name) . ' <span class="tag-count">(' . $tag->count . ')</span>';
                        echo '</a>';
                    }
                    echo '</div>';
                else :
                    echo '<p>まだタグがありません。</p>';
                endif;
                ?>
            </div>
        </section>
    </div>
</div>

<style>
.category-tag-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.page-title {
    font-size: 2.5rem;
    color: #1f2937;
    margin-bottom: 40px;
    text-align: center;
}

.section-title {
    font-size: 1.8rem;
    color: #374151;
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #3b82f6;
}

.category-section {
    margin-bottom: 60px;
}

/* カテゴリグリッド */
.term-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.term-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    transition: all 0.2s ease;
}

.term-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.term-name {
    font-size: 1.2rem;
    margin-bottom: 8px;
}

.term-name a {
    color: #1f2937;
    text-decoration: none;
    font-weight: 600;
}

.term-name a:hover {
    color: #3b82f6;
}

.term-count {
    display: inline-block;
    background: #f3f4f6;
    color: #6b7280;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 0.875rem;
    margin-bottom: 8px;
}

.term-description {
    font-size: 0.9rem;
    color: #6b7280;
    margin-top: 8px;
    line-height: 1.5;
}

/* タグクラウド */
.tag-cloud-wrapper {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 30px;
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.tag-item {
    display: inline-block;
    background: #eff6ff;
    color: #2563eb;
    padding: 8px 16px;
    border-radius: 24px;
    text-decoration: none;
    transition: all 0.2s ease;
    line-height: 1;
}

.tag-item:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-2px);
}

.tag-count {
    font-size: 0.8em;
    opacity: 0.8;
}

/* レスポンシブ */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .term-grid {
        grid-template-columns: 1fr;
    }
    
    .tag-cloud {
        justify-content: center;
    }
}
</style>

<?php get_footer(); ?>