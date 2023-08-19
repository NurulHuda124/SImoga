<!DOCTYPE html>
<html>

<head>
    <title>Laporan Masa mitra mitra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 200px;
            height: auto;
            margin-top: -10px;
        }

        .company-info {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .container {
            text-align: center;
            margin-top: 30px;
        }

        .company_name {
            margin-top: -5px;
        }

        .address {
            margin-top: -20px;
        }

        .underline {
            text-decoration: underline;
        }

        .date {
            margin-top: -30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="img/pertamina.jpg" alt="Company Logo">
        </div>
        <div class="company-info">
            <h3 class="company_name">PT. PERTAMINA EP CEPU ZONA 11 REGION 4 SUKOWATI FIELD</h3>
            <p class="address">Jl. Lingkar Pertamina, Desa Rahayu, Kecamatan Soko Tuban 62372, Jawa Timur</p>
        </div>
    </div>

    <div class="container">
        <h2 class="underline">INFORMASI MASA KONTRAK MITRA PERUSAHAAN</h2>
        <div class="date">
            <p>Dibuat Pada: <?php echo date('d-m-Y'); ?></p>
        </div>
        <table>
            <tr>
                <th>Nomor Kontrak Perusahaan</th>
                <td>{{ $mitra->no_kontrak_perusahaan }}</td>
            </tr>
            <tr>
                <th>Nama Mitra Perusahaan</th>
                <td>{{ $mitra->nama_perusahaan }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $mitra->email }}</td>
            </tr>
            <tr>
                <th>Jenis Mitra</th>
                <td>{{ $mitra->jenis_mitra }}</td>
            </tr>
            <tr>
                <th>Website</th>
                <td>{{ $mitra->website }}</td>
            </tr>
            <tr>
                <th>No. Telp 1</th>
                <td>{{ $mitra->no_telp_1 }}</td>
            </tr>
            <tr>
                <th>No. Telp 2</th>
                <td>{{ $mitra->no_telp_2 }}</td>
            </tr>
            <tr>
                <th>No. Telp 3</th>
                <td>{{ $mitra->no_telp_3 }}</td>
            </tr>
            <tr>
                <th>Tanggal Kontrak Perusahaan Mitra Dimulai</th>
                <td>{{ \Carbon\Carbon::parse($mitra->tanggal_kontrak_awal_perusahaan)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Kontrak Perusahaan Mitra Berakhir</th>
                <td>{{ \Carbon\Carbon::parse($mitra->tanggal_kontrak_akhir_perusahaan)->format('d-m-Y') }}</td>
            </tr>
            <!-- Add more details as needed -->
        </table>
    </div>
</body>

</html>
