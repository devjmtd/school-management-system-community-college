<x-filament-panels::page.simple>
    <div class="relative min-h-screen flex items-center justify-center bg-cover bg-center"
         style="background-image: url('{{ asset('images/login-bg.jpg') }}');">

        <div class="w-full max-w-md p-6 bg-white/80 rounded-2xl shadow-xl backdrop-blur-md">
            {{ $this->form }}
        </div>
    </div>
</x-filament-panels::page.simple>
