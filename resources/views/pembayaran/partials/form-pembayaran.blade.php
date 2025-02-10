<section class="p-6 bg-white shadow-md rounded-lg">
    <header>
        <h2 class="text-xl font-semibold text-gray-900">
            {{ __('Buat Pembayaran SPP') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('Silakan pilih kelas dan semester yang sesuai untuk melakukan pembayaran SPP secara mudah dan cepat.') }}
        </p>
    </header>

    <form method="post" action="{{ route('pembayaran.checkout') }}" class="mt-1 space-y-6">
        @csrf

        <!-- Pilihan Kelas -->
        <div>
            <x-input-label for="kelas" :value="__('Pilih Kelas')" />
            <select id="kelas" name="kelas"
                class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                <option value="" disabled selected>-- Pilih Kelas --</option>
                @foreach ($kelas as $data)
                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
            </select>
        </div>

        <!-- Pilihan Semester -->
        <div>
            <x-input-label for="bulan" :value="__('Pilih bulan')" />
            <select id="bulan" name="bulan"
                class="mt-1 block w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                <option value="" disabled selected>-- Pilih bulan --</option>

                @php
                    $months = [
                        1 => 'Januari',
                        2 => 'Februari',
                        3 => 'Maret',
                        4 => 'April',
                        5 => 'Mei',
                        6 => 'Juni',
                        7 => 'Juli',
                        8 => 'Agustus',
                        9 => 'September',
                        10 => 'Oktober',
                        11 => 'November',
                        12 => 'Desember',
                    ];
                @endphp

                @foreach ($months as $num => $name)
                    <option value="{{ $num }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tombol Submit -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md">
                {{ __('Buat Pembayaran') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-semibold">{{ __('Pembayaran berhasil disimpan!') }}</p>
            @endif
        </div>
    </form>
</section>
