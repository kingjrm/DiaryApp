<?php
// Sidebar component with app logo and main navigation links
?>
<aside class="hidden md:flex fixed left-0 top-0 w-72 h-screen bg-white/95 border-r border-gray-100 z-40 pt-0 pb-6 flex-col justify-between">
    <div class="px-6">
        <div class="flex items-center gap-3 mb-6">
            <img src="<?php echo APP_URL; ?>/logomydiary.png" alt="Logo" class="w-10 h-10 object-contain">
            <div>
                <h3 class="text-lg font-semibold font-poppins">My Diary</h3>
                <p class="text-xs text-gray-500">Your Life, Your Adventure</p>
            </div>
        </div>

        <nav class="space-y-1">
            <a href="<?php echo url('dashboard'); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                <i class="fas fa-tachometer-alt w-4"></i>
                Dashboard
            </a>
            <a href="<?php echo url('diary'); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                <i class="fas fa-book w-4"></i>
                Entries
            </a>
            <a href="<?php echo url('profile'); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                <i class="fas fa-user w-4"></i>
                Profile
            </a>
            <a href="<?php echo url('profile'); ?>#settings" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                <i class="fas fa-cog w-4"></i>
                Settings
            </a>
            <a href="<?php echo url('logout'); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 text-red-600 font-medium">
                <i class="fas fa-sign-out-alt w-4"></i>
                Logout
            </a>
        </nav>
    </div>

    <div class="px-6 mt-6">
        <div class="bg-gray-50 rounded-lg p-3 flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center text-white font-semibold"><?php echo strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)); ?></div>
            <div>
                <div class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></div>
                <a href="<?php echo url('profile'); ?>" class="text-xs text-gray-500 hover:text-gray-700">View profile</a>
            </div>
        </div>
    </div>
</aside>
