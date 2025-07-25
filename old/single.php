<?php
/*
Template for single post pages
*/
get_header(); ?>

<div class="container">
    <!-- メインコンテンツ -->
    <div class="main-layout">
        <div class="content-area">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                
                <article class="post-content">
                    <!-- 記事メタ情報 -->
                    <div class="post-meta">
                        <time class="post-date"><?php echo get_the_date('Y年n月j日'); ?></time>
                        
                        <?php if (get_post_status() === 'draft') : ?>
                            <span class="post-status">下書き</span>
                        <?php endif; ?>
                        
                        <?php
                        $categories = get_the_category();
                        if (!empty($categories)) :
                            foreach ($categories as $cat) :
                        ?>
                            <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="post-category">
                                <?php echo esc_html($cat->name); ?>
                            </a>
                        <?php 
                            endforeach;
                        endif; 
                        ?>
                    </div>

                    <!-- 記事タイトル -->
                    <h1 class="post-title"><?php the_title(); ?></h1>

                    <!-- 記事本文 -->
                    <div class="post-body">
                        <?php the_content(); ?>
                    </div>

                    <!-- タグ表示 -->
                    <?php 
                    $tags = get_the_tags();
                    if ($tags) : 
                    ?>
                        <div class="post-tags">
                            Tag: 
                            <?php
                            $tag_links = array();
                            foreach ($tags as $tag) {
                                $tag_links[] = '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a>';
                            }
                            echo implode(', ', $tag_links);
                            ?>
                        </div>
                    <?php endif; ?>
                </article>

            <?php endwhile; endif; ?>

            <!-- 前後の記事ナビゲーション -->
            <nav class="post-navigation">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
                ?>
                
                <div class="nav-prev">
                    <?php if ($prev_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" class="nav-link">
                            <div class="nav-label">← 前の記事</div>
                            <div class="nav-title"><?php echo esc_html($prev_post->post_title); ?></div>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="nav-next">
                    <?php if ($next_post) : ?>
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" class="nav-link">
                            <div class="nav-label">次の記事 →</div>
                            <div class="nav-title"><?php echo esc_html($next_post->post_title); ?></div>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>

        <!-- 目次サイドバー - 右側に配置 -->
        <aside class="toc-sidebar">
            <div class="toc-container">
                <div class="toc-title">📖 目次</div>
                <ul class="toc-list">
                    <!-- JavaScriptで動的生成 -->
                </ul>
            </div>
        </aside>
    </div>
</div>

<?php get_footer(); ?>