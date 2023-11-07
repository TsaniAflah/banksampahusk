<!DOCTYPE html>
<html>

<head>

    <title></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        table {
            border-left: 0.01em solid #ccc;
            border-right: 0;
            border-top: 0.01em solid #ccc;
            border-bottom: 0;
            border-collapse: collapse;
        }

        table td,
        table th {
            border-left: 0;
            border-right: 0.01em solid #ccc;
            border-top: 0;
            border-bottom: 0.01em solid #ccc;
        }
    </style>
</head>

<body>
    <h3>Laporan Sampah</h3>
    <table class="table" border='1'>

        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Quantity</th>
            </tr>
        </thead>

        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data as $row)
                <tr>
                    <td>{{ $no++ }}.</td>
                    <td>{{ Str::upper($row->nasabah->name) }}</td>
                    <td>{{ $row->total_quantity }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>


    <script src="https://cdn.tailwindcss.com"></script>
</body>

</html>
