<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2{
            text-align: center;
            margin: 10px;
        }

        p {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;
        }
    </style>
</head>

<body>
    <h2>{{ $judul }}</h2>
    <p>Periode: {{ $from->locale('id')->translatedFormat('l, j F Y') }} sampai {{ $to->locale('id')->translatedFormat('l, j F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Pembeli</th>
                <th>Distributor</th>
                <th>Jumlah</th>
                <th width="70px">Total</th>
                <th width="100px">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $i => $data)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $data->nomor_transaksi }}</td>
                    <td>{{ $data->penerima->nama ?? $data->penerima->nama_usaha }}</td>
                    <td>{{ $data->distributor->nama_toko }}</td>
                    <td>{{ $data->jumlah_barang }} item</td>
                    <td>Rp {{ $data->total_harga }}.000</td>
                    <td>{{ \Carbon\Carbon::parse($data->created_at)->locale('id')->translatedFormat('l, j F Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>