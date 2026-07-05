/* ============================================
   DF_137 — ADMIN.JS
   Sidebar, Uploads, Quill, Toasts, Validation
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

    // ============================================
    // SIDEBAR TOGGLE
    // ============================================
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('open');
        if (sidebarOverlay) sidebarOverlay.classList.add('active');
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('active');
    }

    if (sidebarToggle) sidebarToggle.addEventListener('click', openSidebar);
    if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // Close sidebar on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSidebar();
    });

    // ============================================
    // TOAST NOTIFICATIONS
    // ============================================
    const toastContainer = document.getElementById('toastContainer');

    window.showToast = function (message, type = 'info', duration = 4000) {
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;

        const icons = {
            success: '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>',
            error: '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>',
            info: '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>',
        };

        toast.innerHTML = `
            <div class="toast-icon">${icons[type] || icons.info}</div>
            <div class="toast-message">${message}</div>
            <button class="toast-close" aria-label="Close">&times;</button>
        `;

        toastContainer.appendChild(toast);

        // Animate in
        requestAnimationFrame(() => toast.classList.add('show'));

        // Close button
        toast.querySelector('.toast-close').addEventListener('click', () => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        });

        // Auto dismiss
        if (duration > 0) {
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, duration);
        }
    };

    // Auto-show session messages as toasts
    const successAlert = document.querySelector('.alert-success');
    const errorAlert = document.querySelector('.alert-error');
    if (successAlert) {
        showToast(successAlert.textContent.trim(), 'success');
        successAlert.style.display = 'none';
    }
    if (errorAlert) {
        showToast(errorAlert.textContent.trim(), 'error');
        errorAlert.style.display = 'none';
    }

    // ============================================
    // DELETE CONFIRMATIONS
    // ============================================
    const deleteForms = document.querySelectorAll('form[data-confirm], form[action*="delete"], form[method="DELETE"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const message = form.getAttribute('data-confirm') || 'Are you sure you want to delete this item? This action cannot be undone.';
            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
            // Show toast
            showToast('Deleting...', 'info', 2000);
        });
    });

    // Delete buttons with data-delete
    const deleteButtons = document.querySelectorAll('[data-delete]');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const message = btn.getAttribute('data-confirm') || 'Are you sure you want to delete this item?';
            if (!confirm(message)) return;

            const form = btn.closest('form');
            if (form) {
                form.submit();
            } else {
                const url = btn.getAttribute('data-delete');
                if (url) {
                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    }).then(res => {
                        if (res.ok) {
                            showToast('Deleted successfully', 'success');
                            const row = btn.closest('tr, .media-item, .message-item, .admin-card');
                            if (row) row.remove();
                        } else {
                            showToast('Failed to delete', 'error');
                        }
                    }).catch(() => showToast('Network error', 'error'));
                }
            }
        });
    });

    // ============================================
    // RICH TEXT EDITOR (QUILL)
    // ============================================
    const quillEditors = document.querySelectorAll('[data-quill]');
    quillEditors.forEach(el => {
        if (typeof Quill === 'undefined') return;

        const toolbarOptions = [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'color': [] }, { 'background': [] }],
            ['link', 'image'],
            ['clean'],
        ];

        const editor = new Quill(el, {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions,
            },
            placeholder: el.getAttribute('data-placeholder') || 'Start writing...',
        });

        // Sync content to hidden textarea on form submit
        const form = el.closest('form');
        const hiddenInput = document.querySelector(`input[name="${el.getAttribute('data-quill')}"]`);
        if (hiddenInput) {
            // Set initial content
            if (hiddenInput.value) {
                editor.root.innerHTML = hiddenInput.value;
            }
            if (form) {
                form.addEventListener('submit', () => {
                    hiddenInput.value = editor.root.innerHTML;
                });
            }
        }
    });

    // ============================================
    // FILE UPLOAD PREVIEW
    // ============================================
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    fileInputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const files = e.target.files;
            const previewContainer = document.querySelector(input.getAttribute('data-preview'));
            if (!previewContainer) return;

            previewContainer.innerHTML = '';

            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = (ev) => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'upload-preview-item';
                    previewItem.innerHTML = `
                        <img src="${ev.target.result}" alt="${file.name}">
                        <button type="button" class="upload-preview-remove" aria-label="Remove">&times;</button>
                    `;
                    previewContainer.appendChild(previewItem);

                    previewItem.querySelector('.upload-preview-remove').addEventListener('click', () => {
                        previewItem.remove();
                    });
                };
                reader.readAsDataURL(file);
            });
        });
    });

    // ============================================
    // SINGLE IMAGE PREVIEW
    // ============================================
    const singleImageInputs = document.querySelectorAll('input[type="file"][data-image-preview]');
    singleImageInputs.forEach(input => {
        input.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const previewEl = document.querySelector(input.getAttribute('data-image-preview'));
            if (!previewEl) return;

            const reader = new FileReader();
            reader.onload = (ev) => {
                previewEl.src = ev.target.result;
                previewEl.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    });

    // ============================================
    // DRAG & DROP UPLOAD
    // ============================================
    const uploadAreas = document.querySelectorAll('.upload-area');
    uploadAreas.forEach(area => {
        const input = area.querySelector('input[type="file"]') ||
            document.querySelector(area.getAttribute('data-input'));

        ['dragenter', 'dragover'].forEach(evt => {
            area.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                area.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            area.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                area.classList.remove('dragover');
            });
        });

        area.addEventListener('drop', (e) => {
            if (input && e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });

        area.addEventListener('click', () => {
            if (input) input.click();
        });
    });

    // ============================================
    // FORM VALIDATION
    // ============================================
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const requiredFields = form.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#f87171';
                    field.addEventListener('input', function handler() {
                        field.style.borderColor = '';
                        field.removeEventListener('input', handler);
                    });
                } else {
                    field.style.borderColor = '';
                }
            });

            // Email validation
            const emailFields = form.querySelectorAll('input[type="email"]');
            emailFields.forEach(field => {
                if (field.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                    valid = false;
                    field.style.borderColor = '#f87171';
                    showToast('Please enter a valid email address', 'error');
                }
            });

            if (!valid) {
                e.preventDefault();
                showToast('Please fill in all required fields', 'error');
            }
        });
    });

    // ============================================
    // IMAGE PREVIEW MODAL (MEDIA GALLERY)
    // ============================================
    const mediaItems = document.querySelectorAll('.media-item');
    mediaItems.forEach(item => {
        item.addEventListener('click', (e) => {
            if (e.target.closest('.media-action-btn')) return;
            const img = item.querySelector('img');
            if (!img) return;

            let modal = document.getElementById('imageModal');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'imageModal';
                modal.style.cssText = `
                    position:fixed;inset:0;z-index:10000;background:rgba(21,11,34,0.95);
                    display:none;align-items:center;justify-content:center;padding:32px;
                    backdrop-filter:blur(10px);cursor:pointer;
                `;
                modal.innerHTML = `<img src="" alt="" style="max-width:90%;max-height:90vh;border-radius:14px;box-shadow:0 30px 80px rgba(0,0,0,0.6);">`;
                document.body.appendChild(modal);

                modal.addEventListener('click', () => modal.style.display = 'none');
            }

            const modalImg = modal.querySelector('img');
            modalImg.src = img.src;
            modal.style.display = 'flex';
        });
    });

    // ============================================
    // COPY TO CLIPBOARD
    // ============================================
    const copyButtons = document.querySelectorAll('[data-copy]');
    copyButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const text = btn.getAttribute('data-copy');
            navigator.clipboard.writeText(text).then(() => {
                showToast('Copied to clipboard', 'success', 2000);
            }).catch(() => showToast('Failed to copy', 'error'));
        });
    });

    // ============================================
    // AUTO-RESIZE TEXTAREAS
    // ============================================
    const autoResizeTextareas = document.querySelectorAll('textarea[data-auto-resize]');
    autoResizeTextareas.forEach(ta => {
        const resize = () => {
            ta.style.height = 'auto';
            ta.style.height = ta.scrollHeight + 'px';
        };
        ta.addEventListener('input', resize);
        resize();
    });

    // ============================================
    // CONFIRM TOGGLE (publish/draft)
    // ============================================
    const toggleButtons = document.querySelectorAll('[data-toggle-action]');
    toggleButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const action = btn.getAttribute('data-toggle-action');
            const message = btn.getAttribute('data-confirm') || `Are you sure you want to ${action} this item?`;
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // ============================================
    // SEARCH FILTER FOR TABLES
    // ============================================
    const searchInputs = document.querySelectorAll('[data-table-search]');
    searchInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const tableSelector = input.getAttribute('data-table-search');
            const table = document.querySelector(tableSelector);
            if (!table) return;

            const rows = table.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });

    // ============================================
    // SELECT ALL CHECKBOX
    // ============================================
    const selectAllCheckbox = document.querySelector('[data-select-all]');
    if (selectAllCheckbox) {
        const targetSelector = selectAllCheckbox.getAttribute('data-select-all');
        const targetCheckboxes = document.querySelectorAll(targetSelector);
        selectAllCheckbox.addEventListener('change', () => {
            targetCheckboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        });
    }

});
