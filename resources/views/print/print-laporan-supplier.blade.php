<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    body {
        font-family: 'Lato', Arial, sans-serif;
    }

    #container {
        position: relative;
    }

    #tanggal-print {
        position: absolute;
        bottom: 0;
    }

    #range-tanggal {
        margin-bottom: 15px;
        margin-top: 15px;
    }

    #header-pt {
        font-size: 20px;
        text-align: center;
    }

    table {
        width: 100%;
        margin: auto;
    }

    table,
    th,
    td {
        border: 1px solid rgb(110, 106, 106);
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
    }
</style>

<body>
    <div id="container">
        <div id="header-pt">
            <label>PT Maju Jaya Motor</label>
        </div>
        <hr>
        <div id="range-tanggal">
            <label>Laporan Barang Masuk Berdasarkan Supplier Dari {{ $tgl_mulai }} Sampai {{ $tgl_sampai }}</label>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Supplier</th>
                    <th>Kode Supplier</th>
                    <th>Jumlah Pengiriman</th>
                    <th>Jumlah Barang</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas->get() as $no => $data)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $data->nama_supplier }}</td>
                    <td>{{ $data->kode_supplier }}</td>
                    <td>{{ $data->kirim }} X</td>
                    <td>{{ $data->total_qty }} pcs</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="footer">
            <span id="tanggal-print">{{ date("d M Y H:i") }}</span>
        </div>
    </div>
</body>

</html>