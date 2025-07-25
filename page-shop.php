<?php
/*
Template Name: SHOP
*/
get_header(); ?>

<div class="container">
    <div class="shop-page">
        <h1 class="page-title">SHOP</h1>
        
        <!-- ショップ紹介 -->
        <div class="shop-intro">
            <p>iKeRyoのオリジナルグッズや推薦商品をご紹介します。</p>
        </div>
        
        <!-- 商品カテゴリ -->
        <div class="shop-categories">
            <div class="shop-category">
                <h2>オリジナルグッズ</h2>
                <div class="product-grid">
                    <div class="product-placeholder">
                        <p>Coming Soon...</p>
                    </div>
                </div>
            </div>
            
            <div class="shop-category">
                <h2>おすすめ書籍</h2>
                <div class="product-grid">
                    <div class="product-placeholder">
                        <p>Coming Soon...</p>
                    </div>
                </div>
            </div>
            
            <div class="shop-category">
                <h2>開発ツール</h2>
                <div class="product-grid">
                    <div class="product-placeholder">
                        <p>Coming Soon...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.shop-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.page-title {
    font-size: 2.5rem;
    color: #1f2937;
    margin-bottom: 24px;
    text-align: center;
}

.shop-intro {
    text-align: center;
    font-size: 1.1rem;
    color: #6b7280;
    margin-bottom: 60px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.shop-categories {
    margin-top: 40px;
}

.shop-category {
    margin-bottom: 60px;
}

.shop-category h2 {
    font-size: 1.8rem;
    color: #374151;
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #3b82f6;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
    margin-top: 24px;
}

.product-placeholder {
    background: white;
    border: 2px dashed #e5e7eb;
    border-radius: 12px;
    padding: 80px 40px;
    text-align: center;
}

.product-placeholder p {
    color: #9ca3af;
    font-size: 1.2rem;
    font-weight: 500;
}

/* 商品カード（将来の実装用） */
.product-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.2s ease;
}

.product-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-4px);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-info {
    padding: 20px;
}

.product-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
}

.product-price {
    font-size: 1.2rem;
    color: #3b82f6;
    font-weight: 700;
}

/* レスポンシブ */
@media (max-width: 768px) {
    .page-title {
        font-size: 2rem;
    }
    
    .shop-intro {
        font-size: 1rem;
    }
    
    .product-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php get_footer(); ?>