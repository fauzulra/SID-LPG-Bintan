<table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Nomor Transaksi</th>
            <th>Nama Pembeli</th>
            <th>Nama Distributor</th>
            <th>Jumlah Barang</th>
            <th>Total Harga</th>
            <th>Tanggal Transaksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $data)
            <tr>
                <td>{{ $data->nomor_transaksi }}</td>
                <td>{{ $data->penerima->nama ?? $data->penerima->nama_usaha ?? 'Data tidak ditemukan' }}</td>
                <td>{{ ucwords($data->distributor->nama_toko) }}</td>
                <td>{{ $data->jumlah_barang }} Item</td>
                <td>Rp {{ $data->total_harga }}.000</td>
                <td>{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('l, j F Y, H:i') }} WIB</td>
            </tr>
        @endforeach
    </tbody>
</table>