<?php
// Variables provided by DiaryController::view()
if (!isset($entry)) {
    $_SESSION['error'] = 'Entry not found';
    header('Location: ' . url('diary'));
    exit;
}

if (!isset($images)) {
    $images = [];
}

$title = htmlspecialchars($entry['title']);
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/diary_header.php';
include __DIR__ . '/../components/sidebar.php';
?>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="glass rounded-xl p-8 neumorphism">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2"><?php echo htmlspecialchars($entry['title']); ?></h1>
                <p class="text-sm text-gray-600"><?php echo date('l, F j, Y', strtotime($entry['entry_date'])); ?></p>
            </div>
            <div class="flex space-x-2">
                <a href="<?php echo appBaseUrl(); ?>/index.php?url=/diary/edit/<?php echo $entry['id']; ?>" class="text-green-600 hover:text-green-800 transition-colors p-2">
                    <i class="fas fa-edit text-xl"></i>
                </a>
                <form action="<?php echo appBaseUrl(); ?>/index.php?url=/diary/delete/<?php echo $entry['id']; ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this entry?')">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors p-2">
                        <i class="fas fa-trash text-xl"></i>
                    </button>
                </form>
            </div>
        </div>

        <?php if ($entry['mood']): ?>
            <div class="mb-6">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    Mood: <?php echo htmlspecialchars($entry['mood']); ?>
                </span>
            </div>
        <?php endif; ?>

        <div class="prose prose-lg max-w-none mb-8">
            <p class="text-gray-700 leading-relaxed whitespace-pre-line <?php echo $entry['font_family'] ?? 'font-poppins'; ?>"><?php echo nl2br(htmlspecialchars($entry['content'])); ?></p>
        </div>

        <?php if (!empty($images)): ?>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Images</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($images as $image): ?>
                        <div class="group relative">
                            <img src="<?php echo htmlspecialchars(assetUrl($image['path'])); ?>" 
                                 alt="<?php echo htmlspecialchars($image['original_name']); ?>" 
                                 class="w-full h-48 object-cover rounded-lg shadow-md transition-transform group-hover:scale-105"
                                 onerror="this.onerror=null;this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22%3E%3Crect fill=%22%23e5e7eb%22 width=%22200%22 height=%22200%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 font-family=%22sans-serif%22 font-size=%2214%22 fill=%22%236b7280%22%3EImage not found%3C/text%3E%3C/svg%3E';">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg flex items-center justify-center">
                                <a href="<?php echo htmlspecialchars(assetUrl($image['path'])); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-expand text-2xl"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <a href="<?php echo url('diary'); ?>" class="text-indigo-600 hover:text-indigo-800 transition-colors flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to Entries
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/create_modal.php'; ?>
<?php include __DIR__ . '/../components/footer.php'; ?>