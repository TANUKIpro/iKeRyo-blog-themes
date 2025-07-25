<?php
/*
記事一覧ページ
*/
get_header(); ?>

<div class="container">
    <div class="blog-page">
        <h1 class="page-title">記事一覧</h1>
        
        <!-- 検索ボックス -->
        <div class="search-box-container">
            <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                <input type="search" 
                       class="search-field" 
                       placeholder="記事を検索..." 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" />
                <button type="submit" class="search-submit">
                    <span class="search-icon">?</span>
                </button>
            </form>
        </div>
        
        <!-- 記事一覧 -->
        <div class="posts-grid">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article class="post-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="post-thumbnail-link">
                                <?php the_post_thumbnail('medium', array('class' => 'post-thumbnail')); ?>
                            </a>
                        <?php endif; ?>
                        
                        <div class="post-card-content">
                            <div class="post-meta">
                                <time class="post-date"><?php echo get_the_date(); ?></time>
                                <?php
                                $categories = get_the_category();
                                if ($categories) :
                                    foreach ($categories as $category) :
                                ?>
                                    <a href="<?php echo get_category_link($category->term_id); ?>" class="post-category">
                                        <?php echo $category->name; ?>
                                    </a>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            
                            <h2 class="post-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more">続きを読む →</a>
                        </div>
                    </article>
                <?php endwhile; ?>
                
                <!-- ページネーション -->
                <div class="pagination">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '← 前へ',
                        'next_text' => '次へ →',
                        'type' => 'list'
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                <div class="no-posts">
                    <p>記事が見つかりませんでした。</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.blog-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.page-title {
    font-size: 2.5rem;
    color: #1f2937;
    margin-bottom: 32px;
    text-align: center;
}

/* 検索ボックス */
.search-box-container {
    max-width: 600px;
    margin: 0 auto 48px;
}

.search-form {
    display: flex;
    border: 2px solid #e5e7eb;
    border-radius: 50px;
    overflow: hidden;
    background: white;
    transition: border-color 0.2s ease;
}

.search-form:focus-within {
    border-color: #3b82f6;
}

.search-field {
    flex: 1;
    padding: 16px 24px;
    border: none;
    font-size: 1rem;
    outline: none;
    background: transparent;
}

.search-submit {
    padding: 16px 24px;
    background: #3b82f6;
    border: none;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.search-submit:hover {
    background: #2563eb;
}

.search-icon {
    font-size: 1.2rem;
}

/* 記事グリッド */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 32px;
    margin-bottom: 48px;
}

/* 記事カード */
.post-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.post-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
}

.post-thumbnail-link {
    display: block;
    overflow: hidden;
    height: 200px;
}

.post-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-thumbnail {
    transform: scale(1.05);
}

.post-card-content {
    padding: 24px;
}

.post-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
    font-size: 0.875rem;
}

.post-date {
    color: #6b7280;
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

.post-card-title {
    font-size: 1.25rem;
    margin-bottom: 12px;
    line-height: 1.4;
}

.post-card-title a {
    color: #1f2937;
    text-decoration: none;
}

.post-card-title a:hover {
    color: #3b82f6;
}

.post-excerpt {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 16px;
}

.read-more {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    transition: color 0.2s ease;
}

.read-more:hover {
    color: #2563eb;
}

/* ページネーション */
.pagination {
    text-align: center;
    margin-top: 48px;
}

.pagination ul {
    display: inline-flex;
    list-style: none;
    gap: 8px;
    padding: 0;
}

.pagination li {
    margin: 0;
}

.pagination a,
.pagination .current {
    display: block;
    padding: 8px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    text-decoration: none;
    color: #374151;
    transition: all 0.2s ease;
}

.pagination a:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.pagination .current {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* 記事なし */
.no-posts {
    text-align: center;
    padding: 80px 20px;
    color: #6b7280;
}

/* レスポンシブ */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .posts-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .search-form {
        border-radius: 8px;
    }
    
    .search-field {
        padding: 12px 16px;
    }
    
    .search-submit {
        padding: 12px 16px;
    }
}
</style>

<?php get_footer(); ?>