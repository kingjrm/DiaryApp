    <nav class="bg-white/80 backdrop-blur-md shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo APP_URL; ?>/dashboard" class="text-lg font-bold text-indigo-600">
                        <i class="fas fa-book-open mr-2"></i>Diary App
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo APP_URL; ?>/diary" class="text-gray-700 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-list mr-1"></i>Entries
                    </a>
                    <a href="<?php echo APP_URL; ?>/diary/calendar" class="text-gray-700 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-calendar mr-1"></i>Calendar
                    </a>
                    <a href="<?php echo APP_URL; ?>/diary/search" class="text-gray-700 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-search mr-1"></i>Search
                    </a>
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center text-gray-700 hover:text-indigo-600 transition-colors">
                            <i class="fas fa-user-circle mr-2"></i><?php echo $_SESSION['user_name']; ?>
                            <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                            <a href="<?php echo APP_URL; ?>/auth/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>