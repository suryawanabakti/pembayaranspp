<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-medium">{{ __('Hi, ' . auth()->user()->name) }}</p>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full bg-white border border-gray-200 rounded-lg shadow-md">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-b">Tanggal Pembayaran
                                    </th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-b">Kelas</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-b">Semester</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-b">Harga</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold border-b">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($transactions as $transaction)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $transaction->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">{{ $transaction->kelas->nama }}</td>
                                        <td class="px-6 py-4">{{ $transaction->semester }}</td>
                                        <td class="px-6 py-4">Rp.{{ number_format($transaction->harga) }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold 
                                                {{ $transaction->status === 'Lunas' ? 'bg-green-200 text-green-700' : 'bg-red-200 text-red-700' }}">
                                                {{ $transaction->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
