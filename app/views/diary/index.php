<?php
$title = 'My Diary';
include __DIR__ . '/../components/header.php';
include __DIR__ . '/../components/diary_header.php';
?>

<div class="pt-20 pb-8 min-h-screen bg-gradient-to-br from-pink-50/30 via-white to-purple-50/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Entries Grid -->
        <div id="entries-container" class="relative min-h-[1000px] <?php echo empty($entries) ? '' : 'move-mode-disabled'; ?>">

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
                        <div class="bg-white rounded-lg shadow-lg border-4 border-white relative overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 w-64 min-h-[120px]"
                             style="background-color: <?php echo htmlspecialchars($entry['background_color'] ?? '#ffffff'); ?>;
                                    <?php if (!empty($entry['background_image'])): ?>background-image: url('<?php echo APP_URL; ?>/uploads/<?php echo htmlspecialchars($entry['background_image']); ?>'); background-size: cover; background-position: center;<?php endif; ?>">

                            <!-- Tape corners -->
                            <div class="tape-corner absolute -top-1 -left-1 w-3 h-3 bg-yellow-300 rounded-full shadow-sm"></div>
                            <div class="tape-corner absolute -top-1 -right-1 w-3 h-3 bg-pink-300 rounded-full shadow-sm"></div>
                            <div class="tape-corner absolute -bottom-1 -left-1 w-3 h-3 bg-blue-300 rounded-full shadow-sm"></div>
                            <div class="tape-corner absolute -bottom-1 -right-1 w-3 h-3 bg-green-300 rounded-full shadow-sm"></div>

                            <!-- Card Content -->
                            <div class="p-4 flex flex-col gap-3" style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>;">

                                <!-- Header -->
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-bold leading-tight truncate <?php echo ($entry['text_bold'] ?? 0) ? 'font-bold' : 'font-semibold'; ?>"
                                            style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>;
                                                   <?php if ($entry['text_underline'] ?? 0): ?>text-decoration: underline;<?php endif; ?>">
                                            <?php echo htmlspecialchars($entry['title']); ?>
                                        </h3>
                                        <p class="text-xs font-poppins" style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>; opacity: 0.7;"><?php echo date('M j', strtotime($entry['entry_date'])); ?></p>
                                    </div>
                                    <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="viewEntry(<?php echo $entry['id']; ?>)" class="transition-colors" style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>; opacity: 0.6;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'" title="View">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <button onclick="editEntry(<?php echo $entry['id']; ?>)" class="transition-colors" style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>; opacity: 0.6;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'" title="Edit">
                                            <i class="fas fa-edit text-xs"></i>
                                        </button>
                                        <button onclick="deleteEntry(<?php echo $entry['id']; ?>)" class="transition-colors" style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>; opacity: 0.6;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'" title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Content Preview -->
                                <div>
                                    <p class="text-xs leading-relaxed <?php echo $entry['font_family'] ?? 'font-poppins'; ?> break-words"
                                       style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>;
                                              <?php if ($entry['text_bold'] ?? 0): ?>font-weight: bold;<?php endif; ?>
                                              <?php if ($entry['text_italic'] ?? 0): ?>font-style: italic;<?php endif; ?>
                                              <?php if ($entry['text_underline'] ?? 0): ?>text-decoration: underline;<?php endif; ?>">
                                        <?php echo nl2br(htmlspecialchars($entry['content'])); ?>
                                    </p>
                                </div>

                                <!-- Mood Badge -->
                                <?php if ($entry['mood']): ?>
                                    <div class="flex justify-center">
                                        <span class="inline-flex items-center px-2 py-1 bg-gradient-to-r from-pink-100 to-purple-100 rounded-full text-xs font-medium shadow-sm"
                                              style="color: <?php echo htmlspecialchars($entry['text_color'] ?? '#000000'); ?>;
                                                     <?php if ($entry['text_bold'] ?? 0): ?>font-weight: bold;<?php endif; ?>
                                                     <?php if ($entry['text_italic'] ?? 0): ?>font-style: italic;<?php endif; ?>
                                                     <?php if ($entry['text_underline'] ?? 0): ?>text-decoration: underline;<?php endif; ?>">
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
// Layout mode functionality
let draggedElement = null;
let offsetX = 0;
let offsetY = 0;
let maxZIndex = 0;

// Sync with global layoutMode
Object.defineProperty(window, 'layoutMode', {
    get: () => layoutMode,
    set: (value) => {
        layoutMode = value;
        const container = document.getElementById('entries-container');
        if (value) {
            // Arranged mode
            container.classList.remove('move-mode-enabled');
            container.classList.add('move-mode-disabled');
        } else {
            // Freeform mode
            container.classList.remove('move-mode-disabled');
            container.classList.add('move-mode-enabled');
        }
    }
});

// Initialize max z-index
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.diary-card');
    cards.forEach(card => {
        const zIndex = parseInt(card.style.zIndex) || 0;
        if (zIndex > maxZIndex) maxZIndex = zIndex;
    });
});

// Mouse events for dragging (only in freeform mode)
document.addEventListener('mousedown', function(e) {
    if (layoutMode) return; // Disable dragging in arranged mode

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
    if (!draggedElement || layoutMode) return;

    const container = document.getElementById('entries-container');
    const containerRect = container.getBoundingClientRect();

    let newX = e.clientX - containerRect.left - offsetX;
    let newY = e.clientY - containerRect.top - offsetY;

    // Freeform movement - no bounds constraints
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

// Touch events for mobile (only in freeform mode)
document.addEventListener('touchstart', function(e) {
    if (layoutMode) return; // Disable dragging in arranged mode

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
    if (!draggedElement || layoutMode) return;

    const touch = e.touches[0];
    const container = document.getElementById('entries-container');
    const containerRect = container.getBoundingClientRect();

    let newX = touch.clientX - containerRect.left - offsetX;
    let newY = touch.clientY - containerRect.top - offsetY;

    // Freeform movement - no bounds constraints
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

// Rotation with right-click or long press (only in freeform mode)
document.addEventListener('contextmenu', function(e) {
    if (layoutMode) return; // Disable rotation in arranged mode

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

<script>
// Auto-arrange cards in grid on page load
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure all cards are rendered
    setTimeout(() => {
        if (document.querySelectorAll('.diary-card').length > 0) {
            arrangeCardsInGrid();
        }
    }, 100);
});

// Grid arrangement function (copied from header for consistency)
function arrangeCardsInGrid() {
    const cards = document.querySelectorAll('.diary-card');
    const container = document.querySelector('.max-w-7xl');
    const containerWidth = container ? container.offsetWidth : window.innerWidth - 100;

    // Card dimensions (256px width + spacing)
    const cardWidth = 280; // 256px card + 24px spacing
    const cardHeight = 200; // More conservative height estimate for variable content

    // Calculate how many cards fit per row
    const cardsPerRow = Math.max(1, Math.floor(containerWidth / cardWidth));
    const spacingX = cardWidth;
    const spacingY = cardHeight;
    const margin = 20; // margin from edges

    cards.forEach((card, index) => {
        const row = Math.floor(index / cardsPerRow);
        const col = index % cardsPerRow;

        const targetX = col * spacingX + margin;
        const targetY = row * spacingY + margin;

        // Set position without animation initially
        card.style.left = targetX + 'px';
        card.style.top = targetY + 'px';
        card.style.transform = 'rotate(0deg)';

        // Apply clean styling for arranged mode
        const cardInner = card.querySelector('.bg-white');
        const tapeCorners = card.querySelectorAll('.tape-corner');

        tapeCorners.forEach(tape => tape.style.display = 'none');
        cardInner.classList.remove('shadow-lg', 'border-4', 'border-white');
        cardInner.classList.add('shadow-md', 'border-2', 'border-gray-200');
        card.style.cursor = 'default';
    });
}
</script>

<?php include __DIR__ . '/../components/footer.php'; ?>