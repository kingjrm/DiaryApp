<?php
$title = 'Search Entries';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/navbar.php';
?>

<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="glass rounded-xl p-8 neumorphism">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Search Diary Entries</h1>

        <form id="search-form" class="mb-8">
            <div class="flex">
                <input type="text" name="q" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" placeholder="Search by title or content..." class="flex-1 px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 neumorphism-inset" required>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-r-md hover:bg-indigo-700 transition-colors flex items-center">
                    <i class="fas fa-search mr-2"></i>Search
                </button>
            </div>
        </form>

        <?php if (isset($_GET['q'])): ?>
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Search Results for "<?php echo htmlspecialchars($_GET['q']); ?>"
                </h2>
                <p class="text-sm text-gray-600"><?php echo count($entries); ?> entries found</p>
            </div>

            <?php if (empty($entries)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">No entries found</h3>
                    <p class="text-gray-500">Try different keywords or check your spelling</p>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($entries as $entry): ?>
                        <div class="glass rounded-lg p-6 neumorphism fade-in">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900 mb-1">
                                        <a href="<?php echo APP_URL; ?>/diary/view/<?php echo $entry['id']; ?>" class="hover:text-indigo-600 transition-colors">
                                            <?php echo htmlspecialchars($entry['title']); ?>
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-500"><?php echo date('F j, Y', strtotime($entry['entry_date'])); ?></p>
                                </div>
                                <a href="<?php echo APP_URL; ?>/diary/view/<?php echo $entry['id']; ?>" class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                            <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars(substr($entry['content'], 0, 200))); ?>...</p>
                            <?php if ($entry['mood']): ?>
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-600 mr-2">Mood:</span>
                                    <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs"><?php echo htmlspecialchars($entry['mood']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../components/footer.php'; ?>