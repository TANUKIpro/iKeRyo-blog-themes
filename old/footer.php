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
    // Prism.jsの手動初期化（Pythonで生成されたコードブロックのため）
    if (typeof Prism !== 'undefined') {
        // 既存のコードブロックを再ハイライト
        Prism.highlightAll();
        
        // カスタムコードブロックの処理
        document.querySelectorAll('pre[class*="language-"]').forEach(function(pre) {
            // Pythonで生成されたコードブロックを認識
            if (!pre.classList.contains('line-numbers')) {
                // 行番号がPythonで既に処理されている場合はスキップ
                const hasCustomLineNumbers = pre.querySelector('.line-number');
                if (!hasCustomLineNumbers) {
                    pre.classList.add('line-numbers');
                }
            }
        });
    }
    
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
        const windowWidth = window.innerWidth;
        const mainLayoutRect = mainLayout.getBoundingClientRect();
        
        if (windowWidth > 1400) {
            const leftPosition = mainLayoutRect.right + 40;
            tocSidebar.style.left = leftPosition + 'px';
        } else {
            tocSidebar.style.left = 'auto';
        }
    }
    
    updateTOCPosition();
    window.addEventListener('resize', updateTOCPosition);
    window.addEventListener('scroll', updateTOCPosition);
}

function convertLinksToCards() {
    const postBody = document.querySelector('.post-body');
    if (!postBody) return;
    
    // 段落内の単独リンクを検出
    const paragraphs = postBody.querySelectorAll('p');
    
    paragraphs.forEach(function(p) {
        // 段落内に単一のリンクのみが存在する場合
        if (p.children.length === 1 && p.children[0].tagName === 'A') {
            const link = p.children[0];
            const url = link.href;
            const text = link.textContent;
            
            // URLカードクラスが既に付与されている場合はスキップ
            if (p.classList.contains('url-card')) return;
            
            // 親要素を取得
            const parent = p.parentElement;
            
            // URLカードを作成
            const urlCard = document.createElement('a');
            urlCard.href = url;
            urlCard.className = 'url-card';
            urlCard.target = '_blank';
            urlCard.rel = 'noopener noreferrer';
            
            // カード画像部分
            const cardImage = document.createElement('div');
            cardImage.className = 'url-card-image';
            cardImage.innerHTML = '🔗';
            
            // カードコンテンツ部分
            const cardContent = document.createElement('div');
            cardContent.className = 'url-card-content';
            
            const cardTitle = document.createElement('div');
            cardTitle.className = 'url-card-title';
            cardTitle.textContent = text || url;
            
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