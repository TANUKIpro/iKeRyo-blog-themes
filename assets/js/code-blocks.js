/**
 * コードブロック用JavaScript
 * コピー機能、行ハイライトなどの追加機能を提供
 */

jQuery(document).ready(function($) {
    // 標準的なコードブロックに行番号を追加
    $('.code-block-wrapper').each(function() {
        const wrapper = $(this);
        const codeBlock = wrapper.find('pre code');
        
        // 既に行番号がある場合はスキップ
        if (wrapper.find('.line-number').length === 0) {
            // コード行を取得
            const lines = codeBlock.html().split('\n');
            const numberedLines = lines.map((line, index) => {
                // 空行の場合も行番号を表示
                const lineContent = line || '&nbsp;';
                return `<span class="code-line"><span class="line-number">${index + 1}</span>${lineContent}</span>`;
            }).join('\n');
            
            // 行番号付きのコードに置き換え
            codeBlock.html(numberedLines);
        }
        
        // コピーボタンを作成
        const copyButton = $('<button class="copy-code-button">コピー</button>');
        copyButton.css({
            position: 'absolute',
            top: '8px',
            right: '100px',
            padding: '4px 12px',
            backgroundColor: '#475569',
            color: '#e2e8f0',
            border: 'none',
            borderRadius: '4px',
            fontSize: '0.75rem',
            cursor: 'pointer',
            transition: 'background-color 0.2s ease',
            zIndex: '10'
        });
        
        // ホバー効果
        copyButton.hover(
            function() { $(this).css('backgroundColor', '#64748b'); },
            function() { $(this).css('backgroundColor', '#475569'); }
        );
        
        // コピー機能
        copyButton.on('click', function() {
            // 行番号を除いたテキストを取得
            let codeText = '';
            codeBlock.find('.code-line').each(function() {
                const lineText = $(this).clone();
                lineText.find('.line-number').remove();
                codeText += lineText.text() + '\n';
            });
            
            // 最後の改行を削除
            codeText = codeText.trim();
            
            // テキストエリアを作成してコピー
            const textarea = $('<textarea>');
            textarea.val(codeText);
            textarea.css({
                position: 'fixed',
                top: '-9999px'
            });
            $('body').append(textarea);
            textarea[0].select();
            
            try {
                document.execCommand('copy');
                copyButton.text('コピーしました！');
                setTimeout(() => {
                    copyButton.text('コピー');
                }, 2000);
            } catch (err) {
                console.error('コピーに失敗しました:', err);
                copyButton.text('失敗');
                setTimeout(() => {
                    copyButton.text('コピー');
                }, 2000);
            }
            
            textarea.remove();
        });
        
        wrapper.append(copyButton);
    });
    
    // 行番号クリックでハイライト
    $('.code-line').on('click', function(e) {
        // 行番号をクリックした場合のみ
        if ($(e.target).hasClass('line-number')) {
            $(this).toggleClass('highlighted');
        }
    });
    
    // スムーズスクロール for アンカーリンク
    $('a[href^="#"]').on('click', function(e) {
        const href = $(this).attr('href');
        if (href && href !== '#') {
            const target = $(href);
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 500);
            }
        }
    });
});

// 行ハイライト用のスタイルを動的に追加
const style = document.createElement('style');
style.textContent = `
    .code-line.highlighted {
        background-color: rgba(59, 130, 246, 0.2) !important;
        border-left: 3px solid #3b82f6;
    }
    
    .copy-code-button:active {
        transform: scale(0.95);
    }
`;
document.head.appendChild(style);