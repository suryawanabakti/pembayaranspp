<center>
    <h1>Laporan Pembayaran</h1>
</center>

<table style="width: 100%; border-collapse: collapse; text-align: left;" border="1">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th style="padding: 8px; border: 1px solid black;">Tanggal</th>
            <th style="padding: 8px; border: 1px solid black;">Nama</th>
            <th style="padding: 8px; border: 1px solid black;">Kelas</th>
            <th style="padding: 8px; border: 1px solid black;">Bulan</th>
            <th style="padding: 8px; border: 1px solid black;">Total Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $d)
            <tr>
                <td style="padding: 8px; border: 1px solid black;">{{ $d->created_at }}</td>
                <td style="padding: 8px; border: 1px solid black;">{{ $d->user->name }}</td>
                <td style="padding: 8px; border: 1px solid black;">{{ $d->user->kelas->nama }}</td>
                <td style="padding: 8px; border: 1px solid black;">{{ $d->bulan }}</td>
                <td style="padding: 8px; border: 1px solid black;">{{ $d->harga }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
