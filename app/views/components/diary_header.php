<?php
$currentDate = $_GET['date'] ?? date('Y-m-d');
$search = $_GET['search'] ?? '';
$mood = $_GET['mood'] ?? '';
?>

<div class="fixed top-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-b border-gray-200/50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left side - Date selector -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar text-gray-400 text-sm"></i>
                    <input type="date"
                           id="date-selector"
                           value="<?php echo $currentDate; ?>"
                           class="text-sm font-medium text-gray-700 bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer font-poppins"
                           onchange="changeDate(this.value)">
                </div>

                <div class="h-4 w-px bg-gray-300"></div>

                <!-- Search -->
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text"
                           id="search-input"
                           placeholder="Search entries..."
                           value="<?php echo htmlspecialchars($search); ?>"
                           class="pl-8 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent w-48 font-poppins"
                           onkeyup="debounceSearch(this.value)">
                </div>

                <!-- Mood filter -->
                <div class="relative">
                    <select id="mood-filter"
                            class="pl-3 pr-8 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-transparent appearance-none font-poppins"
                            onchange="filterByMood(this.value)">
                        <option value="">All moods</option>
                        <option value="Happy" <?php echo $mood === 'Happy' ? 'selected' : ''; ?>>😊 Happy</option>
                        <option value="Calm" <?php echo $mood === 'Calm' ? 'selected' : ''; ?>>😌 Calm</option>
                        <option value="Sad" <?php echo $mood === 'Sad' ? 'selected' : ''; ?>>😢 Sad</option>
                        <option value="Anxious" <?php echo $mood === 'Anxious' ? 'selected' : ''; ?>>😰 Anxious</option>
                        <option value="Excited" <?php echo $mood === 'Excited' ? 'selected' : ''; ?>>🤩 Excited</option>
                        <option value="Tired" <?php echo $mood === 'Tired' ? 'selected' : ''; ?>>😴 Tired</option>
                        <option value="Angry" <?php echo $mood === 'Angry' ? 'selected' : ''; ?>>😠 Angry</option>
                        <option value="Loved" <?php echo $mood === 'Loved' ? 'selected' : ''; ?>>🥰 Loved</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
                </div>
            </div>

            <!-- Right side - Actions -->
            <div class="flex items-center space-x-3">
                <!-- Layout Mode Toggle -->
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-600 font-poppins" id="layout-mode-label">Arranged Mode</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="layout-mode-toggle" class="sr-only peer" checked onchange="toggleLayoutMode(this.checked)">
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-400 peer-checked:to-pink-500"></div>
                    </label>
                </div>

                <div class="h-4 w-px bg-gray-300"></div>

                <!-- New Entry Button -->
                <a href="<?php echo APP_URL; ?>/diary/create"
                        class="bg-gradient-to-r from-pink-400 to-purple-500 hover:from-pink-500 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center font-poppins text-sm shadow-sm hover:shadow-md transform hover:scale-105">
                    <i class="fas fa-plus mr-2 text-xs"></i>
                    New Entry
                </a>

                <div class="h-4 w-px bg-gray-300"></div>

                <!-- User Menu -->
                <div class="relative group">
                    <div id="user-menu-button" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 cursor-pointer select-none">
                        <div class="w-8 h-8 bg-gray-600 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                            <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
                        </div>
                        <span class="text-sm font-poppins"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 group-hover:rotate-180" id="user-menu-icon"></i>
                    </div>

                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-sm border border-gray-200 py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="<?php echo APP_URL; ?>/profile" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 font-poppins transition-colors duration-200">
                            <i class="fas fa-user mr-2"></i>Profile Settings
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="<?php echo APP_URL; ?>/auth/logout" class="block px-3 py-2 text-sm text-red-600 hover:bg-red-50 font-poppins transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let searchTimeout;
let layoutMode = true;

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
    
    const label = document.getElementById('layout-mode-label');
    
    if (enabled) {
        // Arranged mode: clean grid layout
        label.textContent = 'Arranged Mode';
        arrangeCardsInGrid();
        showToast('Cards arranged in clean grid', 'info');
    } else {
        // Freeform mode: allow dragging
        label.textContent = 'Freeform Mode';
        enableFreeformMode();
        showToast('Freeform mode - drag cards anywhere!', 'info');
    }
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
        cardInner.classList.remove('shadow-lg', 'border-4', 'border-white');
        cardInner.classList.add('shadow-md', 'border-2', 'border-gray-200');
        card.style.cursor = 'default';

        // Save arranged position
        const entryId = card.dataset.entryId;
        saveCardPosition(entryId, targetX, targetY, 0, index);
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
        cardInner.classList.remove('shadow-md', 'border-2', 'border-gray-200');
        cardInner.classList.add('shadow-lg', 'border-4', 'border-white');
        card.style.cursor = 'grab';
    });
}

function saveCardPosition(entryId, x, y, rotation, zIndex) {
    fetch('<?php echo APP_URL; ?>/api/update-position', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            entry_id: entryId,
            position_x: x,
            position_y: y,
            rotation: rotation,
            z_index: zIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to save position');
        }
    })
    .catch(error => {
        console.error('Error saving position:', error);
    });
}

    });
}
</script>