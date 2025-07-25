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
    
    // 画面幅をチェック
    function checkScreenWidth() {
        const screenWidth = window.innerWidth;
        
        if (screenWidth <= 1400) {
            // 狭い画面：記事の上部に配置
            tocSidebar.classList.add('toc-above-content');
            mainLayout.prepend(tocSidebar);
        } else {
            // 広い画面：記事の右側に保持
            tocSidebar.classList.remove('toc-above-content');
            // 元の位置（右側）に戻す
            if (tocSidebar !== mainLayout.lastElementChild) {
                mainLayout.appendChild(tocSidebar);
            }
        }
    }
    
    checkScreenWidth();
    window.addEventListener('resize', checkScreenWidth);
}

function setupTOCScrollSpy() {
    const tocLinks = document.querySelectorAll('.toc-link');
    const headings = document.querySelectorAll('.post-body h1, .post-body h2, .post-body h3, .post-body h4, .post-body h5, .post-body h6');
    
    if (tocLinks.length === 0 || headings.length === 0) return;
    
    function highlightCurrentSection() {
        const scrollPosition = window.scrollY + 150;
        
        let currentHeading = null;
        headings.forEach(function(heading) {
            if (heading.offsetTop <= scrollPosition) {
                currentHeading = heading;
            }
        });
        
        tocLinks.forEach(function(link) {
            link.classList.remove('active');
            if (currentHeading && link.getAttribute('href') === '#' + currentHeading.id) {
                link.classList.add('active');
            }
        });
    }
    
    window.addEventListener('scroll', highlightCurrentSection);
    highlightCurrentSection();
}

function convertLinksToCards() {
    const postBody = document.querySelector('.post-body');
    if (!postBody) return;
    
    // 単独の段落内のリンクを探す
    const paragraphs = postBody.querySelectorAll('p');
    
    paragraphs.forEach(function(p) {
        // 段落内に単独のリンクのみがある場合
        if (p.children.length === 1 && p.children[0].tagName === 'A') {
            const link = p.children[0];
            const url = link.href;
            const text = link.textContent;
            
            // 外部リンクかどうか確認
            if (url.startsWith('http')) {
                const card = createURLCard(url, text);
                p.replaceWith(card);
            }
        }
    });
}

function createURLCard(url, text) {
    const card = document.createElement('a');
    card.href = url;
    card.className = 'url-card';
    card.target = '_blank';
    card.rel = 'noopener noreferrer';
    
    // URLからドメインを抽出
    let domain;
    try {
        domain = new URL(url).hostname.replace('www.', '');
    } catch (e) {
        domain = url;
    }
    
    card.innerHTML = `
        <div class="url-card-image">
            <span class="placeholder">🔗</span>
        </div>
        <div class="url-card-content">
            <div class="url-card-title">${text}</div>
            <div class="url-card-url">${domain}</div>
        </div>
    `;
    
    return card;
}
</script>

<?php wp_footer(); ?>
</body>
</html>