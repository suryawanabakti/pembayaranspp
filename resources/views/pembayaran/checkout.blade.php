<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pembayaran') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h2 class="text-xl font-semibold text-gray-900">Konfirmasi Pembayaran</h2>
                <p class="mt-2 text-sm text-gray-600">Silakan lanjutkan pembayaran dengan menekan tombol di bawah ini.
                </p>

                <x-primary-button id="pay-button"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow-md mt-3">{{ __('Bayar Sekarang') }}</x-primary-button>
                {{--  --}}
            </div>
        </div>


    </div>



    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = `/payment/success?order_id=${result.order_id}`;
                    alert("Berhasil")
                    console.log(result)
                },
                onPending: function(result) {
                    // window.location.href = "{{ url('/payment/pending') }}";
                },
                onError: function(result) {
                    // window.location.href = "{{ url('/payment/error') }}";
                }
            });
        };
    </script>
</x-app-layout>
