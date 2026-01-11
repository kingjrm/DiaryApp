<?php
$title = 'Profile Settings';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/diary_header.php';
?>

<div class="min-h-screen bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 font-poppins">Profile Settings</h1>
                    <p class="text-gray-600 font-poppins text-sm mt-1">Customize your diary experience</p>
                </div>
                <a href="<?php echo APP_URL; ?>/diary"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition-all duration-200 font-poppins text-sm shadow-sm hover:shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Diary
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 font-poppins">Profile Information</h2>
                    <p class="text-gray-600 text-xs font-poppins mt-1">Update your personal details</p>
                </div>

                <form method="POST" class="p-4 space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                            Full Name
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 font-poppins text-sm transition-all duration-200"
                               placeholder="Enter your full name">
                    </div>

                    <div>
                        <label for="bio" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                            Bio
                        </label>
                        <textarea id="bio"
                                  name="bio"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 font-poppins text-sm transition-all duration-200 resize-none"
                                  placeholder="Tell us a bit about yourself..."><?php echo htmlspecialchars($userPreferences['bio'] ?? ''); ?></textarea>
                        <p class="text-xs text-gray-500 mt-1 font-poppins">A short description about yourself</p>
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                            Email Address
                        </label>
                        <input type="email"
                               id="email"
                               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded bg-gray-50 text-gray-500 font-poppins text-sm"
                               readonly>
                        <p class="text-xs text-gray-500 mt-1 font-poppins">Email cannot be changed</p>
                    </div>

                    <button type="submit"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded transition-all duration-200 font-poppins font-medium text-sm shadow-sm hover:shadow-md">
                        <i class="fas fa-save mr-2"></i>Update Profile
                    </button>
                </form>
            </div>

            <!-- Writing Preferences -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 font-poppins">Writing Preferences</h2>
                    <p class="text-gray-600 text-xs font-poppins mt-1">Customize your writing experience</p>
                </div>

                <form method="POST" class="p-4 space-y-4">
                    <div>
                        <label for="writing_font" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                            Writing Font
                        </label>
                        <select id="writing_font"
                                name="writing_font"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 font-poppins text-sm transition-all duration-200">
                            <?php
                            $availableFonts = [
                                'Poppins' => 'Poppins (Modern)',
                                'Inter' => 'Inter (Clean)',
                                'Playfair Display' => 'Playfair Display (Elegant)',
                                'Dancing Script' => 'Dancing Script (Handwritten)',
                                'Caveat' => 'Caveat (Casual)',
                                'Kalam' => 'Kalam (Bold Handwritten)',
                                'Permanent Marker' => 'Permanent Marker (Bold)',
                                'Comfortaa' => 'Comfortaa (Rounded)',
                                'Nunito' => 'Nunito (Friendly)',
                                'Quicksand' => 'Quicksand (Soft)'
                            ];
                            foreach ($availableFonts as $fontKey => $fontName) {
                                $selected = ($userPreferences['writing_font'] ?? 'Poppins') === $fontKey ? 'selected' : '';
                                echo "<option value=\"$fontKey\" $selected>$fontName</option>";
                            }
                            ?>
                        </select>
                        <p class="text-xs text-gray-500 mt-1 font-poppins">Font used for writing diary entries</p>
                    </div>

                    <div>
                        <label for="scrapbook_theme" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                            Scrapbook Theme
                        </label>
                        <select id="scrapbook_theme"
                                name="scrapbook_theme"
                                class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 font-poppins text-sm transition-all duration-200">
                            <option value="classic" <?php echo ($userPreferences['scrapbook_theme'] ?? 'classic') === 'classic' ? 'selected' : ''; ?>>Classic</option>
                            <option value="vintage" <?php echo ($userPreferences['scrapbook_theme'] ?? 'classic') === 'vintage' ? 'selected' : ''; ?>>Vintage</option>
                            <option value="modern" <?php echo ($userPreferences['scrapbook_theme'] ?? 'classic') === 'modern' ? 'selected' : ''; ?>>Modern</option>
                            <option value="colorful" <?php echo ($userPreferences['scrapbook_theme'] ?? 'classic') === 'colorful' ? 'selected' : ''; ?>>Colorful</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1 font-poppins">Visual theme for your diary</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div>
                            <label for="timezone" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                                Timezone
                            </label>
                            <select id="timezone"
                                    name="timezone"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 font-poppins text-sm transition-all duration-200">
                                <?php
                                $timezones = [
                                    'UTC' => 'UTC',
                                    'America/New_York' => 'Eastern Time',
                                    'America/Chicago' => 'Central Time',
                                    'America/Denver' => 'Mountain Time',
                                    'America/Los_Angeles' => 'Pacific Time',
                                    'Europe/London' => 'London',
                                    'Europe/Paris' => 'Paris',
                                    'Asia/Tokyo' => 'Tokyo',
                                    'Asia/Shanghai' => 'Shanghai',
                                    'Australia/Sydney' => 'Sydney'
                                ];
                                foreach ($timezones as $tzKey => $tzName) {
                                    $selected = ($userPreferences['timezone'] ?? 'UTC') === $tzKey ? 'selected' : '';
                                    echo "<option value=\"$tzKey\" $selected>$tzName</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div>
                            <label for="date_format" class="block text-xs font-medium text-gray-700 font-poppins mb-1 uppercase tracking-wide">
                                Date Format
                            </label>
                            <select id="date_format"
                                    name="date_format"
                                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-gray-400 font-poppins text-sm transition-all duration-200">
                                <option value="Y-m-d" <?php echo ($userPreferences['date_format'] ?? 'Y-m-d') === 'Y-m-d' ? 'selected' : ''; ?>>YYYY-MM-DD</option>
                                <option value="m/d/Y" <?php echo ($userPreferences['date_format'] ?? 'Y-m-d') === 'm/d/Y' ? 'selected' : ''; ?>>MM/DD/YYYY</option>
                                <option value="d/m/Y" <?php echo ($userPreferences['date_format'] ?? 'Y-m-d') === 'd/m/Y' ? 'selected' : ''; ?>>DD/MM/YYYY</option>
                                <option value="M j, Y" <?php echo ($userPreferences['date_format'] ?? 'Y-m-d') === 'M j, Y' ? 'selected' : ''; ?>>Jan 1, 2024</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded transition-all duration-200 font-poppins font-medium text-sm shadow-sm hover:shadow-md">
                        <i class="fas fa-save mr-2"></i>Save Preferences
                    </button>
                </form>
            </div>
        </div>

        <!-- Font Preview -->
        <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gray-100 px-4 py-3 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 font-poppins">Font Preview</h2>
                <p class="text-gray-600 text-xs font-poppins mt-1">See how your selected font looks</p>
            </div>

            <div class="p-4">
                <div id="font-preview" class="text-sm leading-relaxed font-poppins p-3 bg-gray-50 rounded border text-gray-700">
                    "The quick brown fox jumps over the lazy dog. This is how your writing will appear in your diary entries. Each font has its own unique character and personality that will make your memories even more special."
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Font preview functionality
document.getElementById('writing_font').addEventListener('change', function() {
    const selectedFont = this.value;
    const preview = document.getElementById('font-preview');

    // Remove existing font classes
    preview.className = preview.className.replace(/font-\w+/g, '');

    // Add new font class
    const fontClass = 'font-' + selectedFont.toLowerCase().replace(/\s+/g, '');
    preview.classList.add(fontClass);
});

// Initialize preview with current font
document.addEventListener('DOMContentLoaded', function() {
    const fontSelect = document.getElementById('writing_font');
    fontSelect.dispatchEvent(new Event('change'));
});
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>