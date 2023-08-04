<!DOCTYPE html>
<html>

<head>
    <title>Laporan Masa Kontrak Pegawai</title>
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
        <h2 class="underline">INFORMASI MASA KONTRAK</h2>
        <div class="date">
            <p>Dibuat Pada: <?php echo date('d-m-Y'); ?></p>
        </div>
        <table>
            <tr>
                <th>Nama Pegawai</th>
                <td>{{ $kontrak->nama_pegawai }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $kontrak->email }}</td>
            </tr>
            <tr>
                <th>Divisi</th>
                <td>{{ $pegawai->divisi }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $pegawai->jabatan }}</td>
            </tr>
            <tr>
                <th>Jenis Mitra</th>
                <td>{{ $pegawai->jenis_mitra }}</td>
            </tr>
            <tr>
                <th>Nama Mitra Perusahaan</th>
                <td>{{ $pegawai->nama_perusahaan }}</td>
            </tr>
            <tr>
                <th>Tanggal Kontrak Dimulai</th>
                <td>{{ \Carbon\Carbon::parse($kontrak->tanggal_kontrak_awal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Kontrak Berakhir</th>
                <td>{{ \Carbon\Carbon::parse($kontrak->tanggal_kontrak_akhir)->format('d-m-Y') }}</td>
            </tr>
            <!-- Add more details as needed -->
        </table>
    </div>
</body>

</html>
