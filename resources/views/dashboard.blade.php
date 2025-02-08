<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18m-9 5h9" />
            </svg>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700">
                        {{ __('Selamat Datang di Dashboard') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center bg-blue-100 p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">
                                {{ __('Hi 👋 , ') }} <span class="text-blue-600">{{ auth()->user()->name }}</span>
                            </span>
                        </div>
                        <div class="flex items-center bg-blue-100 p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Nama Kelas:</span>
                            <span class="ml-auto font-semibold">{{ auth()->user()->siswa?->kelas?->nama ?? '-' }}</span>
                        </div>
                        <div class="flex items-center bg-green-100 p-4 rounded-lg">
                            <span class="text-gray-700 font-medium">Jurusan:</span>
                            <span
                                class="ml-auto font-semibold">{{ auth()->user()->siswa?->kelas?->jurusan?->nama ?? '-' }}</span>
                        </div>
                        <div class="flex items-center bg-yellow-100 p-4 rounded-lg md:col-span-2">
                            <span class="text-gray-700 font-medium">Tahun Ajaran:</span>
                            <span
                                class="ml-auto font-semibold">{{ auth()->user()->siswa?->kelas?->tahunajaran->tahun_ajaran ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Tombol Lanjut ke Pembayaran -->
                    <div class="flex justify-end">
                        <a href="{{ route('pembayaran.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-dark font-bold py-2 px-4 rounded-lg transition">
                            Lanjut ke Pembayaran
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
