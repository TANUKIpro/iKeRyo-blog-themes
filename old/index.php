<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * It is used to display a page when nothing more specific matches a query.
 */

get_header(); ?>

<div class="container">
    <div class="main-content">
        <?php if (have_posts()) : ?>
            
            <div class="posts-archive">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article class="post-item">
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
                        
                        <h2 class="post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="read-more">続きを読む →</a>
                    </article>
                    
                <?php endwhile; ?>
                
                <!-- ページネーション -->
                <div class="pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => '← 前へ',
                        'next_text' => '次へ →',
                    ));
                    ?>
                </div>
                
            <?php else : ?>
                
                <div class="no-posts">
                    <p>投稿が見つかりませんでした。</p>
                </div>
                
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.main-content {
    max-width: 800px;
    margin: 60px auto;
    padding: 0 20px;
}

.posts-archive {
    background: white;
    border-radius: 12px;
    padding: 40px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.post-item {
    padding-bottom: 32px;
    margin-bottom: 32px;
    border-bottom: 1px solid #e5e7eb;
}

.post-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.post-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
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
    text-decoration: none;
}

.post-category:hover {
    background: #dbeafe;
}

.post-title {
    font-size: 1.5rem;
    margin-bottom: 12px;
}

.post-title a {
    color: #1f2937;
    text-decoration: none;
}

.post-title a:hover {
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
}

.read-more:hover {
    text-decoration: underline;
}

.pagination {
    margin-top: 40px;
}

.no-posts {
    text-align: center;
    padding: 80px 20px;
    color: #6b7280;
}

@media (max-width: 768px) {
    .posts-archive {
        padding: 24px;
    }
    
    .post-title {
        font-size: 1.25rem;
    }
}
</style>

<?php get_footer(); ?>