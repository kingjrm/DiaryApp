<?php
$title = 'My Diary';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/diary_header.php';
?>

<div class="pt-20 pb-8 min-h-screen bg-gradient-to-br from-pink-50/30 via-white to-purple-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Entries Grid -->
        <div id="entries-container" class="relative min-h-[600px] <?php echo empty($entries) ? '' : 'move-mode-disabled'; ?>">

            <?php if (empty($entries)): ?>
                <!-- Empty State -->
                <div class="flex items-center justify-center min-h-[400px]">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-pink-100 to-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <i class="fas fa-book-open text-3xl text-pink-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2 font-poppins">No entries for this date</h3>
                        <p class="text-sm text-gray-600 mb-6 font-poppins">Start writing your first memory</p>
                        <button onclick="openCreateModal()"
                                class="bg-gradient-to-r from-pink-400 to-purple-500 hover:from-pink-500 hover:to-purple-600 text-white px-6 py-3 rounded-xl transition-all duration-200 font-poppins shadow-sm hover:shadow-md transform hover:scale-105">
                            <i class="fas fa-plus mr-2"></i>Create Your First Entry
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <!-- Entries Grid -->
                <?php foreach ($entries as $index => $entry): ?>
                    <div class="diary-card absolute cursor-pointer group"
                         data-entry-id="<?php echo $entry['id']; ?>"
                         style="left: <?php echo $entry['position_x']; ?>px; top: <?php echo $entry['position_y']; ?>px; transform: rotate(<?php echo $entry['rotation']; ?>deg); z-index: <?php echo $entry['z_index']; ?>;">

                        <!-- Polaroid Card -->
                        <div class="bg-white rounded-lg shadow-lg border-4 border-white w-64 h-80 relative overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105">

                            <!-- Tape corners -->
                            <div class="absolute -top-1 -left-1 w-3 h-3 bg-yellow-300 rounded-full shadow-sm"></div>
                            <div class="absolute -top-1 -right-1 w-3 h-3 bg-pink-300 rounded-full shadow-sm"></div>
                            <div class="absolute -bottom-1 -left-1 w-3 h-3 bg-blue-300 rounded-full shadow-sm"></div>
                            <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-300 rounded-full shadow-sm"></div>

                            <!-- Card Content -->
                            <div class="p-4 h-full flex flex-col">

                                <!-- Header -->
                                <div class="flex justify-between items-start mb-3">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold text-gray-800 mb-1 font-poppins leading-tight truncate"><?php echo htmlspecialchars($entry['title']); ?></h3>
                                        <p class="text-xs text-gray-500 font-poppins"><?php echo date('M j', strtotime($entry['entry_date'])); ?></p>
                                    </div>
                                    <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="viewEntry(<?php echo $entry['id']; ?>)" class="text-gray-400 hover:text-pink-500 transition-colors" title="View">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button onclick="editEntry(<?php echo $entry['id']; ?>)" class="text-gray-400 hover:text-purple-500 transition-colors" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button onclick="deleteEntry(<?php echo $entry['id']; ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Content Preview -->
                                <div class="flex-1 mb-3">
                                    <p class="text-xs text-gray-700 leading-relaxed font-poppins line-clamp-6 <?php echo $entry['font_family'] ?? 'font-poppins'; ?>">
                                        <?php echo nl2br(htmlspecialchars(substr($entry['content'], 0, 200))); ?><?php echo strlen($entry['content']) > 200 ? '...' : ''; ?>
                                    </p>
                                </div>

                                <!-- Mood Badge -->
                                <?php if ($entry['mood']): ?>
                                    <div class="flex justify-center">
                                        <span class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-pink-100 to-purple-100 text-pink-700 rounded-full text-xs font-medium font-poppins shadow-sm">
                                            <?php
                                            $moodEmojis = [
                                                'Happy' => '😊',
                                                'Calm' => '😌',
                                                'Sad' => '😢',
                                                'Anxious' => '😰',
                                                'Excited' => '🤩',
                                                'Tired' => '😴',
                                                'Angry' => '😠',
                                                'Loved' => '🥰'
                                            ];
                                            echo ($moodEmojis[$entry['mood']] ?? '😐') . ' ' . htmlspecialchars($entry['mood']);
                                            ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Include Create Modal -->
<?php include __DIR__ . '/../components/create_modal.php'; ?>

<script>
// Move mode functionality
let moveMode = false;
let draggedElement = null;
let offsetX = 0;
let offsetY = 0;
let maxZIndex = 0;

// Initialize max z-index
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.diary-card');
    cards.forEach(card => {
        const zIndex = parseInt(card.style.zIndex) || 0;
        if (zIndex > maxZIndex) maxZIndex = zIndex;
    });
});

function toggleMoveMode(enabled) {
    moveMode = enabled;
    const container = document.getElementById('entries-container');

    if (enabled) {
        container.classList.remove('move-mode-disabled');
        container.classList.add('move-mode-enabled');
        showToast('Move Mode: Drag cards to rearrange your memories', 'info');
    } else {
        container.classList.remove('move-mode-enabled');
        container.classList.add('move-mode-disabled');
        showToast('Cards locked in place', 'success');
    }
}

// Mouse events for dragging
document.addEventListener('mousedown', function(e) {
    if (!moveMode) return;

    const card = e.target.closest('.diary-card');
    if (!card) return;

    draggedElement = card;
    const rect = card.getBoundingClientRect();
    offsetX = e.clientX - rect.left;
    offsetY = e.clientY - rect.top;

    // Bring to front
    maxZIndex++;
    card.style.zIndex = maxZIndex;

    card.style.cursor = 'grabbing';
    e.preventDefault();
});

document.addEventListener('mousemove', function(e) {
    if (!draggedElement || !moveMode) return;

    const container = document.getElementById('entries-container');
    const containerRect = container.getBoundingClientRect();

    let newX = e.clientX - containerRect.left - offsetX;
    let newY = e.clientY - containerRect.top - offsetY;

    // Keep within bounds
    newX = Math.max(0, Math.min(newX, containerRect.width - draggedElement.offsetWidth));
    newY = Math.max(0, Math.min(newY, containerRect.height - draggedElement.offsetHeight));

    draggedElement.style.left = newX + 'px';
    draggedElement.style.top = newY + 'px';
});

document.addEventListener('mouseup', function() {
    if (!draggedElement) return;

    // Save position
    const entryId = draggedElement.dataset.entryId;
    const x = parseFloat(draggedElement.style.left);
    const y = parseFloat(draggedElement.style.top);
    const rotation = draggedElement.style.transform ? parseFloat(draggedElement.style.transform.match(/rotate\(([^)]+)\)/)?.[1] || 0) : 0;
    const zIndex = parseInt(draggedElement.style.zIndex) || 0;

    saveCardPosition(entryId, x, y, rotation, zIndex);

    draggedElement.style.cursor = 'grab';
    draggedElement = null;
});

// Touch events for mobile
document.addEventListener('touchstart', function(e) {
    if (!moveMode) return;

    const card = e.target.closest('.diary-card');
    if (!card) return;

    draggedElement = card;
    const rect = card.getBoundingClientRect();
    const touch = e.touches[0];
    offsetX = touch.clientX - rect.left;
    offsetY = touch.clientY - rect.top;

    maxZIndex++;
    card.style.zIndex = maxZIndex;

    e.preventDefault();
});

document.addEventListener('touchmove', function(e) {
    if (!draggedElement || !moveMode) return;

    const touch = e.touches[0];
    const container = document.getElementById('entries-container');
    const containerRect = container.getBoundingClientRect();

    let newX = touch.clientX - containerRect.left - offsetX;
    let newY = touch.clientY - containerRect.top - offsetY;

    newX = Math.max(0, Math.min(newX, containerRect.width - draggedElement.offsetWidth));
    newY = Math.max(0, Math.min(newY, containerRect.height - draggedElement.offsetHeight));

    draggedElement.style.left = newX + 'px';
    draggedElement.style.top = newY + 'px';

    e.preventDefault();
});

document.addEventListener('touchend', function() {
    if (!draggedElement) return;

    const entryId = draggedElement.dataset.entryId;
    const x = parseFloat(draggedElement.style.left);
    const y = parseFloat(draggedElement.style.top);
    const rotation = draggedElement.style.transform ? parseFloat(draggedElement.style.transform.match(/rotate\(([^)]+)\)/)?.[1] || 0) : 0;
    const zIndex = parseInt(draggedElement.style.zIndex) || 0;

    saveCardPosition(entryId, x, y, rotation, zIndex);

    draggedElement = null;
});

// Rotation with right-click or long press
document.addEventListener('contextmenu', function(e) {
    if (!moveMode) return;

    const card = e.target.closest('.diary-card');
    if (!card) return;

    e.preventDefault();

    const currentRotation = card.style.transform ? parseFloat(card.style.transform.match(/rotate\(([^)]+)\)/)?.[1] || 0) : 0;
    const newRotation = (currentRotation + 15) % 360;

    card.style.transform = `rotate(${newRotation}deg)`;

    // Save rotation
    const entryId = card.dataset.entryId;
    const x = parseFloat(card.style.left);
    const y = parseFloat(card.style.top);
    const zIndex = parseInt(card.style.zIndex) || 0;

    saveCardPosition(entryId, x, y, newRotation, zIndex);
});

function saveCardPosition(entryId, x, y, rotation, zIndex) {
    fetch('<?php echo APP_URL; ?>/api/update-position', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            entry_id: entryId,
            position_x: x,
            position_y: y,
            rotation: rotation,
            z_index: zIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Failed to save position');
        }
    })
    .catch(error => {
        console.error('Error saving position:', error);
    });
}

// Navigation functions
function viewEntry(id) {
    window.location.href = `<?php echo APP_URL; ?>/diary/view/${id}`;
}

function editEntry(id) {
    window.location.href = `<?php echo APP_URL; ?>/diary/edit/${id}`;
}

function deleteEntry(id) {
    if (confirm('Are you sure you want to delete this entry?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `<?php echo APP_URL; ?>/diary/delete/${id}`;

        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = 'csrf_token';
        token.value = '<?php echo $_SESSION['csrf_token']; ?>';
        form.appendChild(token);

        document.body.appendChild(form);
        form.submit();
    }
}

// Utility functions
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-sm font-poppins z-50 transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' :
        type === 'error' ? 'bg-red-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    toast.textContent = message;

    document.body.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>

<style>
.diary-card {
    user-select: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
}

.move-mode-disabled .diary-card {
    pointer-events: auto;
}

.move-mode-enabled .diary-card {
    pointer-events: auto;
}

.line-clamp-6 {
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes modal-appear {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

.animate-modal-appear {
    animation: modal-appear 0.3s ease-out;
}
</style>

<?php include __DIR__ . '/../components/footer.php'; ?>