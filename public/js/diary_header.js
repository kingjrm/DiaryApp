let searchTimeout;
// Initialize layout mode from localStorage (default to freeform/false)
let layoutMode = localStorage.getItem('diaryLayoutMode') === 'true' ? true : false;

// Set checkbox state on page load
document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('layout-mode-toggle');
    if (checkbox) {
        checkbox.checked = layoutMode;
    }
    
    // Apply the saved layout mode
    const label = document.getElementById('layout-mode-label');
    if (label) {
        label.textContent = layoutMode ? 'Arranged Mode' : 'Freeform Mode';
    }
});

function changeDate(date) {
    const url = new URL(window.location);
    url.searchParams.set('date', date);
    url.searchParams.delete('search');
    url.searchParams.delete('mood');
    window.location.href = url.toString();
}

function debounceSearch(query) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const url = new URL(window.location);
        if (query.trim()) {
            url.searchParams.set('search', query.trim());
        } else {
            url.searchParams.delete('search');
        }
        window.location.href = url.toString();
    }, 500);
}

function filterByMood(mood) {
    const url = new URL(window.location);
    if (mood) {
        url.searchParams.set('mood', mood);
    } else {
        url.searchParams.delete('mood');
    }
    window.location.href = url.toString();
}

function toggleLayoutMode(enabled) {
    // Update global layout mode
    if (typeof window.layoutMode !== 'undefined') {
        window.layoutMode = enabled;
    }
    layoutMode = enabled;
    
    // Save layout mode preference to localStorage
    localStorage.setItem('diaryLayoutMode', enabled);
    
    const label = document.getElementById('layout-mode-label');
    
    if (enabled) {
        // Arranged mode: keep current positions, just update styling
        if (label) label.textContent = 'Arranged Mode';
        updateCardStyling(true);
        if (typeof showToast === 'function') showToast('Switched to Arranged Mode - positions saved!', 'info');
    } else {
        // Freeform mode: allow dragging
        if (label) label.textContent = 'Freeform Mode';
        updateCardStyling(false);
        if (typeof showToast === 'function') showToast('Freeform mode - drag cards anywhere!', 'info');
    }
}

function updateCardStyling(isArrangedMode) {
    const cards = document.querySelectorAll('.diary-card');
    
    cards.forEach(card => {
        if (isArrangedMode) {
            // Arranged mode styling
            card.style.transition = 'none';
            const cardInner = card.querySelector('.bg-white');
            const tapeCorners = card.querySelectorAll('.tape-corner');
            tapeCorners.forEach(tape => tape.style.display = 'none');
            if (cardInner) {
                cardInner.classList.remove('shadow-lg', 'border-4', 'border-white');
                cardInner.classList.add('shadow-md', 'border-2', 'border-gray-200');
            }
            card.style.cursor = 'default';
        } else {
            // Freeform mode styling
            card.style.transition = 'none';
            const cardInner = card.querySelector('.bg-white');
            const tapeCorners = card.querySelectorAll('.tape-corner');
            tapeCorners.forEach(tape => tape.style.display = 'block');
            if (cardInner) {
                cardInner.classList.remove('shadow-md', 'border-2', 'border-gray-200');
                cardInner.classList.add('shadow-lg', 'border-4', 'border-white');
            }
            card.style.cursor = 'grab';
        }
    });
}

function arrangeCardsInGrid() {
    const cards = document.querySelectorAll('.diary-card');
    const container = document.querySelector('.max-w-7xl');
    const containerWidth = container ? container.offsetWidth : window.innerWidth - 100;

    // Card dimensions
    const cardWidth = 280; // 256px card + 24px spacing
    const margin = 20; // margin from edges

    // Calculate how many columns fit
    const numColumns = Math.max(1, Math.floor((containerWidth - margin * 2) / cardWidth));
    const columnWidth = cardWidth;

    // Initialize column heights
    const columnHeights = new Array(numColumns).fill(margin);

    cards.forEach((card, index) => {
        // Temporarily reset position to get natural height
        const originalLeft = card.style.left;
        const originalTop = card.style.top;
        const originalTransform = card.style.transform;

        card.style.left = '0px';
        card.style.top = '0px';
        card.style.transform = 'rotate(0deg)';

        // Get actual card height after rendering
        const cardHeight = card.offsetHeight || 200; // fallback height

        // Restore original position
        card.style.left = originalLeft;
        card.style.top = originalTop;
        card.style.transform = originalTransform;

        // Find the shortest column
        let shortestColumn = 0;
        let minHeight = columnHeights[0];

        for (let i = 1; i < numColumns; i++) {
            if (columnHeights[i] < minHeight) {
                minHeight = columnHeights[i];
                shortestColumn = i;
            }
        }

        // Position the card
        const targetX = shortestColumn * columnWidth + margin;
        const targetY = minHeight;

        // Animate to position
        card.style.transition = 'all 0.5s ease-out';
        card.style.left = targetX + 'px';
        card.style.top = targetY + 'px';
        card.style.transform = 'rotate(0deg)';

        // Update column height with actual card height
        columnHeights[shortestColumn] = targetY + cardHeight + 20; // 20px spacing

        // Apply clean styling
        const cardInner = card.querySelector('.bg-white');
        const tapeCorners = card.querySelectorAll('.tape-corner');

        tapeCorners.forEach(tape => tape.style.display = 'none');
        if (cardInner) {
            cardInner.classList.remove('shadow-lg', 'border-4', 'border-white');
            cardInner.classList.add('shadow-md', 'border-2', 'border-gray-200');
        }
        card.style.cursor = 'default';

        // Save arranged position
        const entryId = card.dataset.entryId;
        if (entryId) saveCardPosition(entryId, targetX, targetY, 0, index);
    });
}

function enableFreeformMode() {
    const cards = document.querySelectorAll('.diary-card');
    
    cards.forEach(card => {
        // Remove transitions for immediate response
        card.style.transition = 'none';
        
        // Restore original styling
        const cardInner = card.querySelector('.bg-white');
        const tapeCorners = card.querySelectorAll('.tape-corner');
        
        tapeCorners.forEach(tape => tape.style.display = 'block');
        if (cardInner) {
            cardInner.classList.remove('shadow-md', 'border-2', 'border-gray-200');
            cardInner.classList.add('shadow-lg', 'border-4', 'border-white');
        }
        card.style.cursor = 'grab';
    });
}

function saveCardPosition(entryId, x, y, rotation, zIndex) {
    fetch(window.APP_CONFIG.url + '/api/update-position', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            entry_id: entryId,
            position_x: x,
            position_y: y,
            rotation: rotation,
            z_index: zIndex,
            csrf_token: getCsrfToken()
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to save position:', data.message);
        }
    })
    .catch(error => {
        console.error('Error saving position:', error);
    });
}

function getCsrfToken() {
    // Try to get CSRF token from config or fallbacks
    if (window.APP_CONFIG && window.APP_CONFIG.csrfToken) {
        return window.APP_CONFIG.csrfToken;
    }
    const metaToken = document.querySelector('meta[name="csrf-token"]');
    if (metaToken) return metaToken.getAttribute('content');
    
    const inputToken = document.querySelector('input[name="csrf_token"]');
    if (inputToken) return inputToken.value;
    
    return '';
}
