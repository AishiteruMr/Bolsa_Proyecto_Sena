@props([
    'id' => 'confirm-modal',
    'title' => 'Confirmar Operación',
    'message' => '¿Estás seguro de que deseas proceder? Esta acción puede ser irreversible.',
    'confirmText' => 'CONTINUAR OPERACIÓN',
    'cancelText' => 'ABORTAR',
    'type' => 'danger',
    'action' => '',
    'method' => 'POST'
])

<div x-data="{ open: false }" 
     @open-modal-{{ $id }}.window="open = true" 
     @close-modal.window="open = false"
     x-show="open" 
     class="fixed inset-0 z-[110] flex items-center justify-center bg-slate-900/40 backdrop-blur-sm p-6 italic font-bold"
     x-cloak>
    
    <div @click.away="open = false" 
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90 translate-y-10"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="w-full max-w-lg bg-white border-none shadow-[0_40px_100px_-20px_rgba(38,70,83,0.3)] rounded-[3.5rem] p-12 space-y-10 relative overflow-hidden italic">
        
        <div class="absolute -top-20 -right-20 w-48 h-48 bg-slate-50 rounded-full italic"></div>

        <div class="flex flex-col items-center text-center space-y-6 italic relative z-10">
            <div class="{{ $type === 'danger' ? 'bg-red-500 shadow-red-500/20' : 'bg-amber-500 shadow-amber-500/20' }} w-20 h-20 rounded-[2rem] flex items-center justify-center text-white text-3xl shadow-2xl italic rotate-12">
                <i class="fas fa-radiation-alt italic"></i>
            </div>
            <div class="space-y-3 italic">
                <h3 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter italic leading-none">{{ $title }}</h3>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] italic opacity-60 italic">{{ $message }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-4 italic relative z-10">
            <form action="{{ $action }}" method="POST" class="w-full m-0 italic">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif
                <x-button type="submit" variant="{{ $type === 'danger' ? 'primary' : 'secondary' }}" class="w-full py-6 rounded-2xl text-[10px] font-black uppercase italic shadow-2xl active:scale-95 transition-all {{ $type === 'danger' ? 'bg-red-500 hover:bg-red-600 border-none' : '' }} italic">
                    {{ $confirmText }}
                </x-button>
            </form>
            <x-button @click="open = false" variant="secondary" class="w-full py-5 rounded-2xl text-[10px] font-black text-slate-400 uppercase italic border-none bg-slate-50 hover:bg-slate-100 transition-all italic">
                {{ $cancelText }}
            </x-button>
        </div>
    </div>
</div>
