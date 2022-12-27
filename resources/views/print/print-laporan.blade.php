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
            <label>Laporan Barang Masuk Dari {{ $tgl_mulai }} Sampai {{ $tgl_sampai }}</label>
        </div>
        <table>
            <thead>
                <tr style="border-top: 5px">
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Nama Merek</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $no => $data)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $data->nama_barang }}</td>
                    <td>{{ $data->nama_merek }}</td>
                    <td>{{ $data->total_qty }}</td>
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