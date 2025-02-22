<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konfirmasi Pembayaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-r from-blue-500 to-indigo-600">
    <div class="bg-white p-8 rounded-lg shadow-2xl text-center w-96">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-4">Konfirmasi Pembayaran</h1>
        <p class="text-gray-600 mb-6">Silakan tekan tombol di bawah untuk melanjutkan pembayaran SPP.</p>



        <button id="pay-button"
            class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-300">
            🚀 Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert("✅ Pembayaran Berhasil!");
                    window.location.href = `/payment/success?order_id=${result.order_id}`;
                },
                onPending: function(result) {
                    alert("⚠️ Pembayaran Tertunda. Mohon selesaikan pembayaran.");
                },
                onError: function(result) {
                    alert("❌ Terjadi kesalahan dalam pembayaran. Silakan coba lagi.");
                }
            });
        };
    </script>
</body>

</html>
