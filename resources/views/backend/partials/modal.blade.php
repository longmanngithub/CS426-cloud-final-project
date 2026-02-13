<!-- Reusable Admin Action Modal -->
<div id="adminModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div id="modalBackdrop" class="fixed inset-0 bg-black/20 transition-opacity duration-300 opacity-0 backdrop-blur-sm" onclick="closeAdminModal()"></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
            <!-- Modal Panel -->
            <div id="modalPanel" class="relative transform overflow-hidden rounded-2xl sm:rounded-[32px] bg-white dark:bg-gray-800 text-left shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 opacity-0 scale-90 w-[90%] mx-auto sm:w-full sm:max-w-[420px]">
                <div class="p-6 sm:p-8 text-center bg-white dark:bg-gray-800">
                    <div id="modalIconBg" class="mx-auto flex h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 mb-5 sm:mb-6 transition-colors">
                        <i id="modalIcon" class="fas fa-exclamation-triangle text-red-500 text-2xl sm:text-3xl transition-colors"></i>
                    </div>
                    <h3 class="text-xl sm:text-2xl font-bold leading-tight text-gray-900 dark:text-white mb-2 sm:mb-3 tracking-tight" id="modalTitle">Confirm Action</h3>
                    <p class="text-sm sm:text-base text-gray-500 dark:text-gray-400 leading-relaxed max-w-[260px] sm:max-w-[300px] mx-auto" id="modalMessage">
                        Are you sure you want to proceed?
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 px-5 pb-5 sm:px-6 sm:pb-6 flex flex-col gap-3">
                    <button type="button" id="confirmActionBtn" class="w-full inline-flex justify-center items-center rounded-xl sm:rounded-2xl bg-red-600 px-4 py-3.5 sm:py-4 text-base sm:text-lg font-bold text-white shadow-sm hover:bg-red-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-all active:scale-95">
                        Confirm
                    </button>
                    <button type="button" onclick="closeAdminModal()" class="w-full inline-flex justify-center items-center rounded-xl sm:rounded-2xl bg-gray-100 dark:bg-gray-700 px-4 py-3.5 sm:py-4 text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-transform active:scale-95">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let activeFormId = null;

    function openAdminModal({ title, message, type = 'danger', formId, confirmText = 'Confirm' }) {
        activeFormId = formId;
        const modal = document.getElementById('adminModal');
        const backdrop = document.getElementById('modalBackdrop');
        const panel = document.getElementById('modalPanel');

        // Update Content
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').textContent = message;

        const confirmBtn = document.getElementById('confirmActionBtn');
        confirmBtn.textContent = confirmText;

        // Styling based on type
        const iconBg = document.getElementById('modalIconBg');
        const icon = document.getElementById('modalIcon');

        // Reset classes
        iconBg.className = 'mx-auto flex h-16 w-16 sm:h-20 sm:w-20 flex-shrink-0 items-center justify-center rounded-full mb-5 sm:mb-6 transition-colors';
        icon.className = 'fas text-2xl sm:text-3xl transition-colors';
        confirmBtn.className = 'w-full inline-flex justify-center items-center rounded-xl sm:rounded-2xl px-4 py-3.5 sm:py-4 text-base sm:text-lg font-bold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 transition-all active:scale-95';

        if (type === 'danger') {
            iconBg.classList.add('bg-red-100', 'dark:bg-red-900/30');
            icon.classList.add('fa-exclamation-triangle', 'text-red-500');
            confirmBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'focus-visible:outline-red-600');
        } else if (type === 'success') {
            iconBg.classList.add('bg-green-100', 'dark:bg-green-900/30');
            icon.classList.add('fa-check-circle', 'text-green-500');
            confirmBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'focus-visible:outline-green-600');
        } else {
            // Info/Default
            iconBg.classList.add('bg-blue-100', 'dark:bg-blue-900/30');
            icon.classList.add('fa-info-circle', 'text-blue-500');
            confirmBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'focus-visible:outline-blue-600');
        }

        // Show Modal
        modal.classList.remove('hidden');
        void modal.offsetWidth; // Trigger reflow
        backdrop.classList.remove('opacity-0');
        panel.classList.remove('opacity-0', 'scale-90');
        panel.classList.add('opacity-100', 'scale-100');
        document.body.style.overflow = 'hidden';
    }

    function closeAdminModal() {
        const modal = document.getElementById('adminModal');
        const backdrop = document.getElementById('modalBackdrop');
        const panel = document.getElementById('modalPanel');

        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-90');

        setTimeout(() => {
            modal.classList.add('hidden');
            activeFormId = null;
            document.body.style.overflow = '';
        }, 300);
    }

    document.getElementById('confirmActionBtn').addEventListener('click', function() {
        if (activeFormId) {
            const btn = this;
            const originalContent = btn.innerHTML;

            // Add loading state
            btn.classList.add('opacity-75', 'cursor-wait');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
            btn.disabled = true;

            // Submit form
            document.getElementById(activeFormId).submit();
        }
    });

    // Close on Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAdminModal();
        }
    });
</script>
