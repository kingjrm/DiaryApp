<?php
// Font picker component for diary entries
$selectedFont = $selectedFont ?? ($entry['font_family'] ?? 'font-poppins');
$fonts = [
    ['name' => 'Poppins', 'class' => 'font-poppins', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Inter', 'class' => 'font-inter', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Playfair Display', 'class' => 'font-playfair', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Pixelify Sans', 'class' => 'font-pixelify', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Dancing Script', 'class' => 'font-dancing', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Caveat', 'class' => 'font-caveat', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Kalam', 'class' => 'font-kalam', 'preview' => 'The quick brown fox jumps over the lazy dog'],
    ['name' => 'Shadows Into Light', 'class' => 'font-shadows', 'preview' => 'The quick brown fox jumps over the lazy dog']
];
?>

<div class="font-picker-container mb-6">
    <label class="block text-xs font-medium text-gray-700 mb-3 font-poppins">Choose Your Writing Style</label>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <?php foreach ($fonts as $font): ?>
        <div class="font-option p-3 border-2 rounded-lg cursor-pointer hover:border-pink-300 transition-all duration-200 transform hover:scale-105 bg-white/80 backdrop-blur-sm <?php echo $selectedFont === $font['class'] ? 'border-pink-400 bg-pink-50' : 'border-gray-200'; ?>"
             data-font="<?php echo $font['class']; ?>"
             onclick="selectFont('<?php echo $font['class']; ?>')">
            <div class="text-center">
                <div class="font-preview text-sm mb-2 <?php echo $font['class']; ?> text-gray-800 leading-tight">
                    <?php echo htmlspecialchars($font['preview']); ?>
                </div>
                <div class="font-name text-xs font-medium text-gray-600 font-poppins">
                    <?php echo htmlspecialchars($font['name']); ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <input type="hidden" id="selected-font" name="font_family" value="<?php echo htmlspecialchars($selectedFont); ?>">
</div>

<script>
function selectFont(fontClass) {
    // Remove selected class from all options
    document.querySelectorAll('.font-option').forEach(option => {
        option.classList.remove('border-pink-400', 'bg-pink-50');
        option.classList.add('border-gray-200');
    });

    // Add selected class to clicked option
    event.currentTarget.classList.remove('border-gray-200');
    event.currentTarget.classList.add('border-pink-400', 'bg-pink-50');

    // Update hidden input
    document.getElementById('selected-font').value = fontClass;

    // Update textarea font
    const textarea = document.getElementById('content');
    textarea.className = textarea.className.replace(/font-\w+/g, '');
    textarea.classList.add(fontClass);

    // Show preview
    showToast(`Font changed to ${event.currentTarget.querySelector('.font-name').textContent}`, 'success');
}
</script>