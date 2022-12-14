<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.min.css">
    <title>Print Locator</title>
</head>
<style>
    #tabel {
        width: 200px;
    }
</style>

<body>
    <label>{{ date("Y-m-d") }}</label>
    <h1 class="text-center mt-3">{{ $barang_masuk_details->nama_barang }} - {{ $barang_masuk_details->nama_merek }}</h1>

    <table class="table table-bordered" id="tabel">
        <tr>
            <td>Locator</td>
            <td>:</td>
            <td>{{ $barang_masuk_details->no_rack }} - {{ $barang_masuk_details->level }} -
                {{$barang_masuk_details->no_locator }}</td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td>:</td>
            <td>{{ $barang_masuk_details->qty }}</td>
        </tr>
    </table>
    <script src="vendor/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>

</html>