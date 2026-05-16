function selectFont(fontClass) {
    // Remove selected class from all options
    document.querySelectorAll('.font-option').forEach(option => {
        option.classList.remove('border-pink-400', 'bg-pink-50');
        option.classList.add('border-gray-200');
    });

    // Add selected class to clicked option
    if (event && event.currentTarget) {
        event.currentTarget.classList.remove('border-gray-200');
        event.currentTarget.classList.add('border-pink-400', 'bg-pink-50');
    }

    // Update hidden input
    const selectedFontInput = document.getElementById('selected-font');
    if (selectedFontInput) {
        selectedFontInput.value = fontClass;
    }

    // Update textarea font
    const textarea = document.getElementById('content');
    if (textarea) {
        textarea.className = textarea.className.replace(/font-\w+/g, '');
        textarea.classList.add(fontClass);
    }

    // Show preview
    if (event && event.currentTarget && typeof showToast === 'function') {
        const fontNameEl = event.currentTarget.querySelector('.font-name');
        if (fontNameEl) {
            showToast(`Font changed to ${fontNameEl.textContent}`, 'success');
        }
    }
}
