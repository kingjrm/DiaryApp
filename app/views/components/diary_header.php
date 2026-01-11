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
                <!-- Move Mode Toggle -->
                <div class="flex items-center space-x-2">
                    <span class="text-xs text-gray-600 font-poppins">Move Mode</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="move-mode-toggle" class="sr-only peer" onchange="toggleMoveMode(this.checked)">
                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-pink-400 peer-checked:to-purple-500"></div>
                    </label>
                </div>

                <div class="h-4 w-px bg-gray-300"></div>

                <!-- New Entry Button -->
                <button onclick="openCreateModal()"
                        class="bg-gradient-to-r from-pink-400 to-purple-500 hover:from-pink-500 hover:to-purple-600 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center font-poppins text-sm shadow-sm hover:shadow-md transform hover:scale-105">
                    <i class="fas fa-plus mr-2 text-xs"></i>
                    New Entry
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let moveMode = false;
let searchTimeout;

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

function toggleMoveMode(enabled) {
    moveMode = enabled;
    const cards = document.querySelectorAll('.diary-card');

    if (enabled) {
        cards.forEach(card => {
            card.classList.add('move-mode');
            card.style.cursor = 'grab';
        });
        showToast('Move Mode enabled - drag cards to rearrange', 'info');
    } else {
        cards.forEach(card => {
            card.classList.remove('move-mode');
            card.style.cursor = 'default';
        });
        showToast('Move Mode disabled', 'info');
    }
}

function openCreateModal() {
    // This will be implemented when we create the modal
    console.log('Open create modal');
}
</script>