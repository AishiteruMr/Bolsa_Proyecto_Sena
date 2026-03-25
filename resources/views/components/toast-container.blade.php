<div x-data="{ 
    toasts: [],
    add(toast) {
        toast.id = Date.now();
        this.toasts.push(toast);
        setTimeout(() => this.remove(toast.id), 4000);
    },
    remove(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}" 
@notify.window="add($event.detail)"
class="fixed bottom-10 right-10 z-[100] space-y-4 flex flex-col items-end pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90 translate-x-10"
             class="pointer-events-auto flex items-center gap-5 p-6 rounded-[2rem] bg-slate-900 border-4 border-white shadow-2xl min-w-[320px] relative overflow-hidden group italic font-bold">
            
            <div class="absolute -right-4 -bottom-4 w-16 h-16 bg-white/5 rounded-full italic"></div>

            <div :class="{
                'bg-emerald-500 shadow-emerald-500/20': toast.type === 'success',
                'bg-red-500 shadow-red-500/20': toast.type === 'error',
                'bg-amber-500 shadow-amber-500/20': toast.type === 'warning',
                'bg-blue-500 shadow-blue-500/20': toast.type === 'info'
            }" class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-xl italic shrink-0">
                <i :class="{
                    'fas fa-check-circle': toast.type === 'success',
                    'fas fa-exclamation-circle': toast.type === 'error',
                    'fas fa-exclamation-triangle': toast.type === 'warning',
                    'fas fa-info-circle': toast.type === 'info'
                }" class="text-xl italic"></i>
            </div>

            <div class="flex-1 italic">
                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 italic opacity-60 italic leading-none" x-text="toast.type"></p>
                <p class="text-[13px] font-black text-white mt-1 uppercase italic tracking-tighter italic leading-tight" x-text="toast.message"></p>
            </div>

            <button @click="remove(toast.id)" class="text-slate-500 hover:text-white transition-colors italic">
                <i class="fas fa-times text-xs italic"></i>
            </button>
        </div>
    </template>
</div>
