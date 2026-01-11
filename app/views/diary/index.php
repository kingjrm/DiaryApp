<?php
$title = 'My Diary Entries';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/navbar.php';
?>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">My Diary Entries</h1>
        <a href="<?php echo APP_URL; ?>/diary/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center">
            <i class="fas fa-plus mr-2"></i>New Entry
        </a>
    </div>

    <?php if (empty($entries)): ?>
        <div class="text-center py-12">
            <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No entries yet</h3>
            <p class="text-sm text-gray-500 mb-6">Start writing your first diary entry</p>
            <a href="<?php echo APP_URL; ?>/diary/create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition-colors inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>Create Your First Entry
            </a>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($entries as $entry): ?>
                <div class="glass rounded-xl p-6 neumorphism fade-in">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1"><?php echo htmlspecialchars($entry['title']); ?></h3>
                            <p class="text-xs text-gray-500"><?php echo date('F j, Y', strtotime($entry['entry_date'])); ?></p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="<?php echo APP_URL; ?>/diary/view/<?php echo $entry['id']; ?>" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo APP_URL; ?>/diary/edit/<?php echo $entry['id']; ?>" class="text-green-600 hover:text-green-800 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo APP_URL; ?>/diary/delete/<?php echo $entry['id']; ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this entry?')">
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="text-sm text-gray-700 mb-4 line-clamp-3"><?php echo nl2br(htmlspecialchars(substr($entry['content'], 0, 200))); ?>...</p>
                    <?php if ($entry['mood']): ?>
                        <div class="flex items-center">
                            <span class="text-xs text-gray-600 mr-2">Mood:</span>
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs"><?php echo htmlspecialchars($entry['mood']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>