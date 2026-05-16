<?php
// Sidebar component with app logo and main navigation links
$current_url = $_GET['url'] ?? '/diary';
$is_diary = in_array($current_url, ['/diary', '/dashboard', '/diary/create']);
$is_profile = ($current_url === '/profile');
?>
<aside class="hidden md:flex fixed left-0 top-0 w-72 h-screen bg-white border-r border-gray-200 z-40 pt-6 pb-6 flex-col justify-between">
    <div class="px-6">
        <!-- Brand -->
        <div class="flex items-center gap-3 mb-8 px-2">
            <img src="<?php echo APP_URL; ?>/logomydiary.png" alt="Logo" class="w-10 h-10 object-contain">
            <div>
                <h3 class="text-lg font-bold font-poppins text-gray-800">My Diary</h3>
                <p class="text-xs text-gray-500 font-medium">Your Life, Your Adventure</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="space-y-1">
            <a href="<?php echo url('diary'); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 font-poppins text-sm <?php echo $is_diary ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium'; ?>">
                <div class="<?php echo $is_diary ? 'text-gray-800' : 'text-gray-400'; ?> w-6 flex items-center justify-center transition-colors">
                    <i class="fas fa-book-open text-sm"></i>
                </div>
                My Diary
            </a>
            
            <a href="<?php echo url('profile'); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 font-poppins text-sm <?php echo $is_profile ? 'bg-gray-100 text-gray-900 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 font-medium'; ?>">
                <div class="<?php echo $is_profile ? 'text-gray-800' : 'text-gray-400'; ?> w-6 flex items-center justify-center transition-colors">
                    <i class="fas fa-user-circle text-sm"></i>
                </div>
                Profile & Settings
            </a>
        </nav>
    </div>

    <div class="px-6 mt-auto">
        <div class="border-t border-gray-200 pt-4 mb-2">
            <a href="<?php echo url('logout'); ?>" class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200 font-medium font-poppins text-sm text-gray-600 hover:bg-red-50 hover:text-red-600 group">
                <div class="text-gray-400 group-hover:text-red-500 w-6 flex items-center justify-center transition-colors">
                    <i class="fas fa-sign-out-alt text-sm"></i>
                </div>
                Logout
            </a>
        </div>
        
        <!-- User Profile summary -->
        <div class="bg-white border border-gray-200 rounded-xl p-3 flex items-center gap-3 transition-all duration-200 cursor-default">
            <div class="w-9 h-9 bg-gray-800 rounded-full flex items-center justify-center text-white text-sm font-bold">
                <?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?>
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-gray-800 truncate font-poppins"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></div>
                <div class="text-xs text-gray-500 font-medium truncate flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Online
                </div>
            </div>
        </div>
    </div>
</aside>
