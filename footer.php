<footer class="footer">
    <div class="container">
        <?php if (!is_front_page()) : ?>
            <a href="<?php echo home_url(); ?>" class="back-to-home">← ホームに戻る</a>
        <?php endif; ?>
        <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 目次生成（記事ページのみ）
    if (document.querySelector('.toc-list')) {
        generateTOC();
        setupTOCScrollSpy();
        setupTOCPositioning();
    }
    
    // URLカード変換（記事ページのみ）
    if (document.querySelector('.post-body')) {
        convertLinksToCards();
    }
});

function generateTOC() {
    const tocContainer = document.querySelector('.toc-list');
    const headings = document.querySelectorAll('.post-body h1, .post-body h2, .post-body h3, .post-body h4, .post-body h5, .post-body h6');
    
    if (!tocContainer || headings.length === 0) return;
    
    let tocHTML = '';
    
    headings.forEach(function(heading, index) {
        const id = 'heading-' + index;
        heading.id = id;
        
        const level = parseInt(heading.tagName.substring(1));
        const text = heading.textContent;
        
        // 階層構造に応じたクラス名
        const levelClass = 'toc-level-' + level;
        
        tocHTML += `<li class="toc-item">
            <a href="#${id}" class="toc-link ${levelClass}">${text}</a>
        </li>`;
    });
    
    tocContainer.innerHTML = tocHTML;
    
    // 目次リンクのクリックイベント
    tocContainer.addEventListener('click', function(e) {
        if (e.target.classList.contains('toc-link')) {
            e.preventDefault();
            const targetId = e.target.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                const offsetTop = targetElement.offsetTop - 120;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        }
    });
}

function setupTOCPositioning() {
    const tocSidebar = document.querySelector('.toc-sidebar');
    const mainLayout = document.querySelector('.main-layout');
    
    if (!tocSidebar || !mainLayout) return;
    
    function updateTOCPosition() {
        // 画面幅が1400px以下の場合は位置制御を完全に無効化
        if (window.innerWidth <= 1400) {
            tocSidebar.classList.remove('toc-above-content');
            tocSidebar.style.position = '';
            tocSidebar.style.top = '';
            tocSidebar.style.right = '';
            tocSidebar.style.left = '';
            tocSidebar.style.width = '';
            tocSidebar.style.height = '';
            tocSidebar.style.maxHeight = '';
            tocSidebar.style.zIndex = '';
            tocSidebar.style.transform = '';
            return;
        }
        
        const mainLayoutRect = mainLayout.getBoundingClientRect();
        const tocWidth = 300; // 目次の幅
        const margin = 40; // 記事からの距離
        
        // 記事ブロックの右端から40px右の位置
        const rightPosition = window.innerWidth - (mainLayoutRect.right + margin + tocWidth);
        
        // 画面端を超えるかチェック
        if (rightPosition < 20) {
            // 画面端を超える場合：記事上部に配置
            tocSidebar.classList.add('toc-above-content');
            tocSidebar.style.right = 'auto';
            tocSidebar.style.position = 'static';
        } else {
            // 正常に表示できる場合：右側に固定
            tocSidebar.classList.remove('toc-above-content');
            tocSidebar.style.position = 'fixed';
            tocSidebar.style.right = rightPosition + 'px';
        }
    }
    
    // 初期実行
    updateTOCPosition();
    
    // リサイズ時に再計算
    window.addEventListener('resize', function() {
        clearTimeout(window.tocResizeTimer);
        window.tocResizeTimer = setTimeout(updateTOCPosition, 100);
    });
    
    // スクロール時の再計算（1401px以上のみ）
    let lastScrollTop = 0;
    window.addEventListener('scroll', function() {
        if (window.innerWidth <= 1400) return; // 小画面では無効
        
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (Math.abs(scrollTop - lastScrollTop) > 10) {
            updateTOCPosition();
            lastScrollTop = scrollTop;
        }
    });
}

function convertLinksToCards() {
    const postBody = document.querySelector('.post-body');
    if (!postBody) return;
    
    const links = postBody.querySelectorAll('a[href^="http"]');
    
    links.forEach(function(link) {
        const parent = link.parentElement;
        if (parent && parent.tagName === 'P' && parent.textContent.trim() === link.textContent.trim()) {
            const url = link.href;
            const title = link.textContent.trim();
            
            // URLカードを作成
            const urlCard = document.createElement('a');
            urlCard.className = 'url-card';
            urlCard.href = url;
            urlCard.target = '_blank';
            urlCard.rel = 'noopener noreferrer';
            
            // プレビュー画像部分
            const cardImage = document.createElement('div');
            cardImage.className = 'url-card-image';
            
            const img = document.createElement('img');
            img.onerror = function() {
                // 画像読み込み失敗時はプレースホルダー表示
                cardImage.innerHTML = '<div class="placeholder">🔗</div>';
            };
            
            // Faviconを試行
            try {
                const domain = new URL(url).hostname;
                img.src = `https://www.google.com/s2/favicons?domain=${domain}&sz=64`;
                cardImage.appendChild(img);
            } catch (e) {
                cardImage.innerHTML = '<div class="placeholder">🔗</div>';
            }
            
            // コンテンツ部分
            const cardContent = document.createElement('div');
            cardContent.className = 'url-card-content';
            
            const cardTitle = document.createElement('div');
            cardTitle.className = 'url-card-title';
            cardTitle.textContent = title || 'リンク';
            
            const cardUrl = document.createElement('div');
            cardUrl.className = 'url-card-url';
            cardUrl.textContent = url;
            
            cardContent.appendChild(cardTitle);
            cardContent.appendChild(cardUrl);
            
            urlCard.appendChild(cardImage);
            urlCard.appendChild(cardContent);
            
            // 元のリンクを置き換え
            parent.replaceWith(urlCard);
        }
    });
}

function setupTOCScrollSpy() {
    const tocLinks = document.querySelectorAll('.toc-link');
    const headings = document.querySelectorAll('.post-body h1, .post-body h2, .post-body h3, .post-body h4, .post-body h5, .post-body h6');
    
    if (tocLinks.length === 0 || headings.length === 0) return;
    
    let isScrolling = false;
    
    function updateActiveTOC() {
        if (isScrolling) return;
        
        const scrollPosition = window.scrollY + 150;
        let currentHeading = null;
        
        headings.forEach(function(heading) {
            if (heading.offsetTop <= scrollPosition) {
                currentHeading = heading;
            }
        });
        
        // すべてのtocリンクからactiveクラスを削除
        tocLinks.forEach(function(link) {
            link.classList.remove('active');
        });
        
        // 現在のセクションのtocリンクにactiveクラスを追加
        if (currentHeading) {
            const activeLink = document.querySelector(`a[href="#${currentHeading.id}"]`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }
    }
    
    // スクロールイベントをスロットル
    let ticking = false;
    window.addEventListener('scroll', function() {
        if (!ticking) {
            requestAnimationFrame(function() {
                updateActiveTOC();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // 初期状態で実行
    updateActiveTOC();
}
</script>

<?php wp_footer(); ?>
</body>
</html>