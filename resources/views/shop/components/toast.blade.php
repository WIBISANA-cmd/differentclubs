    <div x-show="toast.show" x-transition class="fixed bottom-4 right-4 z-50">
        <div class="bg-black text-white px-6 py-3 rounded-lg shadow-lg flex items-center toast">
            <span x-text="toast.message"></span>
            <button @click="toast.show = false" class="ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
