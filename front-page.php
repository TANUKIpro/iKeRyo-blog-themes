<?php
/*
Template Name: トップページ
*/
get_header(); ?>

<style>
/* トップページ専用スタイル */
.front-page-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

/* メインコンテンツ */
.main-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 60px;
    margin-bottom: 60px;
}

/* 最新記事 */
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
    flex-wrap: wrap;
    gap: 8px;
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

.post-categories {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
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

/* サイドバー */
.sidebar h3 {
    font-size: 1.25rem;
    color: #1f2937;
    margin-bottom: 16px;
    font-weight: 600;
}

.sidebar-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 24px;
    margin-bottom: 32px;
}

/* カテゴリー */
.category-list {
    list-style: none;
}

.category-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f3f4f6;
}

.category-item:last-child {
    border-bottom: none;
}

.category-link {
    text-decoration: none;
    color: #374151;
    font-weight: 500;
    transition: color 0.2s ease;
}

.category-link:hover {
    color: #3b82f6;
}

.category-count {
    background: #f3f4f6;
    color: #6b7280;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* タグクラウド */
.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-item {
    display: inline-block;
    background: #f3f4f6;
    color: #374151;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 0.875rem;
    text-decoration: none;
    transition: all 0.2s ease;
}

.tag-item:hover {
    background: #3b82f6;
    color: white;
}

/* プロフィール */
.profile-section {
    text-align: center;
}

.profile-avatar-container {
    margin: 0 auto 16px;
}

.profile-avatar-gravatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #e5e7eb;
    transition: all 0.2s ease;
}

.profile-avatar-gravatar:hover {
    border-color: #3b82f6;
    transform: scale(1.05);
}

.profile-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
}

.profile-bio {
    font-size: 0.9rem;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 20px;
}

.profile-links {
    display: flex;
    justify-content: center;
    gap: 16px;
}

.profile-link {
    color: #6b7280;
    text-decoration: none;
    font-size: 0.875rem;
    transition: color 0.2s ease;
}

.profile-link:hover {
    color: #3b82f6;
}

.view-all-link {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: background-color 0.2s ease;
}

.view-all-link:hover {
    background: #2563eb;
}

/* レスポンシブ */
@media (max-width: 768px) {
    .main-content {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .post-categories {
        width: 100%;
    }

    .profile-links {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

<!-- メインコンテンツ -->
<div class="front-page-container">
    <div class="main-content">
        <!-- 最新記事 -->
        <main class="posts-section">
            <h2>最新記事</h2>
            <div class="post-list">
                <?php
                // 最新記事を5件取得
                $recent_posts = new WP_Query(array(
                    'posts_per_page' => 5,
                    'post_status' => array('publish', 'draft'),  // 公開済み + 下書きを表示
                    'orderby' => 'date',
                    'order' => 'DESC'
                ));

                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
                        // 下書きかどうかを判定
                        $is_draft = get_post_status() === 'draft';
                ?>
                    <a href="<?php the_permalink(); ?>" class="post-item">
                        <div class="post-meta">
                            <time class="post-date"><?php echo get_the_date('Y年n月j日'); ?></time>
                            <?php if ($is_draft) : ?>
                                <span class="post-category" style="background: #fef3c7; color: #92400e;">下書き</span>
                            <?php endif; ?>
                            
                            <!-- すべてのカテゴリーを表示 -->
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) :
                            ?>
                                <div class="post-categories">
                                    <?php foreach ($categories as $cat) : ?>
                                        <span class="post-category"><?php echo esc_html($cat->name); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <h3 class="post-title">
                            <?php if ($is_draft) echo '[下書き] '; ?>
                            <?php the_title(); ?>
                        </h3>
                        <p class="post-excerpt">
                            <?php
                            $excerpt = get_the_excerpt();
                            echo wp_trim_words($excerpt, 50, '...');
                            ?>
                        </p>
                    </a>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <div class="post-item">
                        <p>まだ記事がありません。</p>
                    </div>
                <?php endif; ?>
            </div>
            <a href="/blog" class="view-all-link">すべての記事を見る</a>
        </main>

        <!-- サイドバー -->
        <aside class="sidebar">
            <!-- プロフィール -->
            <div class="sidebar-section profile-section">
                <?php
                // 管理者ユーザー情報を取得
                $admin_users = get_users(array('role' => 'administrator', 'number' => 1));
                if (!empty($admin_users)) {
                    $admin_user = $admin_users[0];
                    $user_id = $admin_user->ID;
                    $user_email = $admin_user->user_email;
                    $display_name = $admin_user->display_name;
                } else {
                    // フォールバック
                    $user_id = 1;
                    $user_email = get_option('admin_email');
                    $display_name = 'iKeRyo';
                }
                ?>
                
                <div class="profile-avatar-container">
                    <?php
                    echo get_avatar(
                        $user_email, 
                        80, 
                        'mm', 
                        esc_attr($display_name), 
                        array('class' => 'profile-avatar-gravatar')
                    );
                    ?>
                </div>
                
                <h3 class="profile-name"><?php echo esc_html($display_name); ?></h3>
                <p class="profile-bio">
                    <?php
                    $bio = get_the_author_meta('description', $user_id);
                    echo $bio ? esc_html($bio) : 'Python開発者兼有閑人間。技術の学びと日常の発見を記録しています。';
                    ?>
                </p>
                <div class="profile-links">
                    <a href="https://github.com/TANUKIpro" class="profile-link" target="_blank" rel="noopener noreferrer">GitHub</a>
                    <a href="https://x.com/Petit_Etang" class="profile-link" target="_blank" rel="noopener noreferrer">Twitter</a>
                </div>
            </div>

            <!-- カテゴリー -->
            <div class="sidebar-section">
                <h3>カテゴリー</h3>
                <ul class="category-list">
                    <?php
                    // すべてのカテゴリーを投稿数順で取得
                    $categories = get_categories(array(
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 10,
                        'hide_empty' => true
                    ));

                    if (!empty($categories)) :
                        foreach ($categories as $cat) :
                    ?>
                        <li class="category-item">
                            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="category-link">
                                <?php echo esc_html($cat->name); ?>
                            </a>
                            <span class="category-count"><?php echo $cat->count; ?></span>
                        </li>
                    <?php
                        endforeach;
                    else :
                    ?>
                        <li class="category-item">
                            <span class="category-link">カテゴリーがありません</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- タグ -->
            <div class="sidebar-section">
                <h3>タグ</h3>
                <div class="tag-cloud">
                    <?php
                    // すべてのタグを使用回数順で取得
                    $tags = get_tags(array(
                        'orderby' => 'count',
                        'order' => 'DESC',
                        'number' => 20,
                        'hide_empty' => true
                    ));

                    if (!empty($tags)) :
                        foreach ($tags as $tag) :
                    ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-item">
                            <?php echo esc_html($tag->name); ?>
                        </a>
                    <?php
                        endforeach;
                    else :
                    ?>
                        <span class="tag-item">タグがありません</span>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</div>

<?php get_footer(); ?>