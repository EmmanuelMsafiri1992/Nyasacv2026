/**
 * Overflow Detection Script
 * Finds elements causing horizontal scrolling
 *
 * Usage: Add to your page and check browser console
 */

(function() {
    'use strict';

    function findOverflowElements() {
        const docWidth = document.documentElement.clientWidth;
        const overflowElements = [];

        console.log('%c========================================', 'color: blue; font-weight: bold;');
        console.log('%cOVERFLOW DETECTION SCRIPT', 'color: blue; font-weight: bold;');
        console.log('%c========================================', 'color: blue; font-weight: bold;');
        console.log('Document width:', docWidth + 'px');
        console.log('Checking all elements...\n');

        document.querySelectorAll('*').forEach(function(el) {
            const rect = el.getBoundingClientRect();
            const scrollWidth = el.scrollWidth;
            const offsetWidth = el.offsetWidth;
            const computedStyle = window.getComputedStyle(el);

            // Check if element extends beyond viewport
            if (rect.right > docWidth || rect.left < 0 || scrollWidth > docWidth) {
                const info = {
                    element: el,
                    tagName: el.tagName,
                    className: el.className,
                    id: el.id,
                    scrollWidth: scrollWidth,
                    offsetWidth: offsetWidth,
                    boundingRight: Math.round(rect.right),
                    boundingLeft: Math.round(rect.left),
                    docWidth: docWidth,
                    overflow: Math.round(rect.right - docWidth),
                    position: computedStyle.position,
                    transform: computedStyle.transform,
                    marginLeft: computedStyle.marginLeft,
                    marginRight: computedStyle.marginRight
                };

                overflowElements.push(info);

                console.log('%c❌ OVERFLOW DETECTED', 'color: red; font-weight: bold;');
                console.log('Element:', el);
                console.log('Tag:', info.tagName);
                console.log('Class:', info.className || 'none');
                console.log('ID:', info.id || 'none');
                console.log('Scroll Width:', info.scrollWidth + 'px');
                console.log('Bounding Right:', info.boundingRight + 'px (viewport: ' + docWidth + 'px)');
                console.log('Overflow by:', info.overflow + 'px');
                console.log('Position:', info.position);
                console.log('Transform:', info.transform);
                console.log('Margin Left:', info.marginLeft);
                console.log('Margin Right:', info.marginRight);
                console.log('---');
            }
        });

        console.log('\n%c========================================', 'color: blue; font-weight: bold;');
        console.log('Total overflow elements found:', overflowElements.length);
        console.log('%c========================================', 'color: blue; font-weight: bold;');

        if (overflowElements.length === 0) {
            console.log('%c✅ No overflow elements detected!', 'color: green; font-weight: bold; font-size: 14px;');
        } else {
            console.log('%c⚠️  Fix these elements to prevent horizontal scrolling', 'color: orange; font-weight: bold;');
            console.table(overflowElements.map(el => ({
                'Tag': el.tagName,
                'Class': el.className.substring(0, 30),
                'Scroll Width': el.scrollWidth + 'px',
                'Overflow': el.overflow + 'px',
                'Position': el.position
            })));
        }

        return overflowElements;
    }

    // Run on load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(findOverflowElements, 1000);
        });
    } else {
        setTimeout(findOverflowElements, 1000);
    }

    // Add to window for manual testing
    window.findOverflow = findOverflowElements;

    console.log('%cOverflow Detection Active', 'color: blue; font-weight: bold;');
    console.log('Run window.findOverflow() anytime to check for overflow elements');

})();
