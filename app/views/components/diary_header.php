<?php
$currentDate = $_GET['date'] ?? date('Y-m-d');
$search = $_GET['search'] ?? '';
$mood = $_GET['mood'] ?? '';
?>

<div class="fixed top-0 left-0 right-0 md:left-72 z-40 bg-white border-b border-gray-200 h-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full">
        <div class="flex items-center justify-between h-full">
            <!-- Left side - Filters -->
            <div class="flex items-center space-x-3">
                <!-- Date selector -->
                <div class="flex items-center px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-calendar-alt text-gray-500 text-sm mr-2"></i>
                    <input type="date"
                           id="date-selector"
                           value="<?php echo $currentDate; ?>"
                           class="text-sm font-medium text-gray-700 bg-transparent border-none focus:outline-none focus:ring-0 cursor-pointer font-poppins"
                           onchange="changeDate(this.value)">
                </div>

                <!-- Search -->
                <div class="relative group hidden sm:block">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 group-focus-within:text-gray-600 transition-colors text-sm"></i>
                    <input type="text"
                           id="search-input"
                           placeholder="Search memories..."
                           value="<?php echo htmlspecialchars($search); ?>"
                           class="pl-9 pr-4 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 w-48 md:w-64 transition-all font-poppins placeholder-gray-400 text-gray-700"
                           onkeyup="debounceSearch(this.value)">
                </div>

                <!-- Mood filter -->
                <div class="relative hidden sm:block">
                    <select id="mood-filter"
                            class="pl-3 pr-8 py-1.5 text-sm bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 appearance-none font-poppins transition-colors hover:bg-gray-100 cursor-pointer text-gray-700 font-medium"
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
            <div class="flex items-center space-x-4 md:space-x-6">
                <!-- Layout Mode Toggle -->
                <div class="hidden sm:flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                    <i class="fas fa-border-all text-gray-400 text-sm"></i>
                    <span class="text-xs text-gray-600 font-medium font-poppins" id="layout-mode-label">Grid</span>
                    <label class="relative inline-flex items-center cursor-pointer ml-1">
                        <input type="checkbox" id="layout-mode-toggle" class="sr-only peer" checked onchange="toggleLayoutMode(this.checked)">
                        <div class="w-8 h-4 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-3 after:w-3 after:transition-all peer-checked:bg-gray-800 shadow-inner"></div>
                    </label>
                </div>

                <!-- New Entry Button -->
                <a href="<?php echo url('diary/create'); ?>"
                   class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg transition-colors flex items-center font-poppins text-sm font-medium">
                    <i class="fas fa-pen mr-2 text-xs"></i>
                    Write Entry
                </a>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo APP_URL; ?>/public/js/diary_header.js"></script>