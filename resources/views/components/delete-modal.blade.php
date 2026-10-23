<!-- Global Delete Confirmation Modal Module -->
<div id="delete-confirmation-modal" 
    class="fixed inset-0 z-50 hidden transition-opacity duration-200 ease-out" 
    aria-labelledby="delete-modal-title" 
    role="dialog" 
    aria-modal="true">
    
    <!-- Backdrop Overlay -->
    <div id="delete-modal-backdrop" 
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity duration-200" 
        onclick="window.closeDeleteModal()"></div>

    <!-- Modal Content Centered Container -->
    <div class="fixed inset-0 z-10 overflow-y-auto flex items-center justify-center p-4 sm:p-6">
        <div id="delete-modal-card" 
            class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white p-6 sm:p-7 text-left shadow-2xl transition-all border border-slate-100 sm:my-8 scale-95 opacity-0 duration-200">
            
            <!-- Close 'X' Button -->
            <button type="button" 
                onclick="window.closeDeleteModal()" 
                class="absolute top-5 right-5 p-1.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Modal Header with Warning Icon -->
            <div class="flex items-start space-x-4">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-rose-50 border border-rose-100 text-rose-600 flex items-center justify-center shadow-xs">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </div>
                <div class="flex-1 pr-6">
                    <h3 id="delete-modal-title" class="text-lg font-bold text-slate-900 leading-snug">
                        Confirm Deletion
                    </h3>
                    <p id="delete-modal-subtitle" class="text-xs text-slate-500 mt-1">
                        Are you sure you want to permanently delete this item? This action cannot be undone.
                    </p>
                </div>
            </div>

            <!-- Item Details Highlight Box -->
            <div class="mt-5 rounded-xl bg-slate-50 border border-slate-200/80 p-3.5 space-y-1">
                <div class="flex items-center justify-between">
                    <span id="delete-modal-type" class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-200 text-slate-700">
                        Item
                    </span>
                    <span id="delete-modal-details" class="text-xs font-mono text-slate-500"></span>
                </div>
                <div id="delete-modal-item-name" class="text-sm font-bold text-slate-800 break-words pt-0.5">
                    Item Name
                </div>
            </div>

            <!-- Special Warning Note (e.g. Cascade delete for Departments with enrolled students) -->
            <div id="delete-modal-warning-box" class="mt-3.5 hidden rounded-xl bg-amber-50 border border-amber-200/80 p-3 text-xs text-amber-800 flex items-start space-x-2.5">
                <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <div id="delete-modal-warning-text" class="leading-relaxed font-medium"></div>
            </div>

            <!-- Action Buttons Form -->
            <form id="delete-modal-form" method="POST" action="" class="mt-6 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2.5 pt-4 border-t border-slate-100">
                @csrf
                @method('DELETE')
                
                <button type="button" 
                    onclick="window.closeDeleteModal()" 
                    class="w-full sm:w-auto px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 transition shadow-xs cursor-pointer">
                    Cancel
                </button>
                <button type="submit" 
                    id="delete-modal-confirm-btn"
                    class="w-full sm:w-auto inline-flex items-center justify-center space-x-1.5 px-5 py-2.5 rounded-xl bg-linear-to-r from-rose-600 to-red-600 hover:from-rose-700 hover:to-red-700 text-xs font-semibold text-white shadow-md shadow-rose-500/25 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Yes, Delete Record</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    (function() {
        const modal = document.getElementById('delete-confirmation-modal');
        const card = document.getElementById('delete-modal-card');
        const form = document.getElementById('delete-modal-form');
        const titleEl = document.getElementById('delete-modal-title');
        const subtitleEl = document.getElementById('delete-modal-subtitle');
        const typeEl = document.getElementById('delete-modal-type');
        const detailsEl = document.getElementById('delete-modal-details');
        const nameEl = document.getElementById('delete-modal-item-name');
        const warningBox = document.getElementById('delete-modal-warning-box');
        const warningText = document.getElementById('delete-modal-warning-text');

        window.openDeleteModal = function(options) {
            if (!modal || !form) return;

            const url = options.url || '#';
            const name = options.name || 'this item';
            const type = options.type || 'Item';
            const details = options.details || '';
            const warning = options.warning || '';
            const title = options.title || `Delete ${type}`;

            form.action = url;
            titleEl.textContent = title;
            typeEl.textContent = type;
            nameEl.textContent = name;
            detailsEl.textContent = details;

            if (warning && warning.trim().length > 0) {
                warningText.textContent = warning;
                warningBox.classList.remove('hidden');
            } else {
                warningBox.classList.add('hidden');
                warningText.textContent = '';
            }

            // Show modal
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            setTimeout(() => {
                card.classList.remove('scale-95', 'opacity-0');
                card.classList.add('scale-100', 'opacity-100');
            }, 10);
        };

        window.closeDeleteModal = function() {
            if (!modal || !card) return;

            card.classList.remove('scale-100', 'opacity-100');
            card.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 180);
        };

        // Global Event Delegation for buttons with data-delete-url
        document.addEventListener('click', function(e) {
            const trigger = e.target.closest('[data-delete-url]');
            if (trigger) {
                e.preventDefault();
                window.openDeleteModal({
                    url: trigger.getAttribute('data-delete-url'),
                    name: trigger.getAttribute('data-delete-name') || 'this item',
                    type: trigger.getAttribute('data-delete-type') || 'Item',
                    details: trigger.getAttribute('data-delete-details') || '',
                    warning: trigger.getAttribute('data-delete-warning') || '',
                    title: trigger.getAttribute('data-delete-title') || 'Confirm Deletion'
                });
            }
        });

        // Close on Escape Key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                window.closeDeleteModal();
            }
        });
    })();
</script>
