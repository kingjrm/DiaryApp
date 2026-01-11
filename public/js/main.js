// Main JavaScript file for Diary App

document.addEventListener('DOMContentLoaded', function() {
    // Toast notifications
    window.showToast = function(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 fade-in ${type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'} text-white`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.remove();
        }, 3000);
    };

    // User menu toggle
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function() {
            userMenu.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    }

    // Auto-hide toasts
    const toasts = document.querySelectorAll('[id$="-toast"]');
    toasts.forEach(toast => {
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Form validation helpers
    window.validateEmail = function(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    };

    window.validatePassword = function(password) {
        return password.length >= 6;
    };

    // Loading states
    window.showLoading = function(element) {
        element.classList.add('opacity-50', 'pointer-events-none');
        element.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Loading...';
    };

    window.hideLoading = function(element, originalText) {
        element.classList.remove('opacity-50', 'pointer-events-none');
        element.innerHTML = originalText;
    };

    // Image preview animations
    const imagePreviews = document.querySelectorAll('#image-preview img');
    imagePreviews.forEach(img => {
        img.addEventListener('load', function() {
            this.classList.add('fade-in');
        });
    });

    // Calendar navigation
    const calendarNav = document.querySelectorAll('.calendar-nav');
    calendarNav.forEach(nav => {
        nav.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.href;
            showLoading(this);
            window.location.href = url;
        });
    });

    // Search functionality
    const searchForm = document.getElementById('search-form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const query = this.query.value.trim();
            if (query) {
                window.location.href = '<?php echo APP_URL; ?>/diary/search?q=' + encodeURIComponent(query);
            }
        });
    }

    // Confirm delete actions
    const deleteButtons = document.querySelectorAll('button[onclick*="confirm"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Are you sure you want to delete this item?')) {
                e.preventDefault();
            }
        });
    });

    // Micro-interactions
    const buttons = document.querySelectorAll('button, .btn');
    buttons.forEach(button => {
        button.addEventListener('mousedown', function() {
            this.style.transform = 'scale(0.95)';
        });
        button.addEventListener('mouseup', function() {
            this.style.transform = 'scale(1)';
        });
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Page transition effects
    const links = document.querySelectorAll('a[href^="<?php echo APP_URL; ?>"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!e.ctrlKey && !e.metaKey) {
                e.preventDefault();
                document.body.style.opacity = '0.5';
                setTimeout(() => {
                    window.location.href = this.href;
                }, 150);
            }
        });
    });

    // Initialize tooltips if any
    const tooltips = document.querySelectorAll('[data-tooltip]');
    tooltips.forEach(el => {
        el.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'absolute bg-gray-800 text-white px-2 py-1 rounded text-sm z-50';
            tooltip.textContent = this.dataset.tooltip;
            this.appendChild(tooltip);
        });
        el.addEventListener('mouseleave', function() {
            const tooltip = this.querySelector('div');
            if (tooltip) tooltip.remove();
        });
    });
});