<!DOCTYPE html>
<html>

<head>
    <title>Laporan Masa Mitra Perusahaan</title>
    <style>
        body {
            font-family: 'Times New Roman';
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
            width: 95%;
            border-collapse: collapse;
        }

        .kolom {
            padding-left: 60px;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
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
            margin-bottom: 40px;
        }

        .kop {
            border-collapse: collapse;
            border: 0;
            width: 100%;
            text-align: center;
        }

        .left {
            align: left;
            width: 15%;
            height: auto;
        }

        .center {
            text-align: center;
            width: 70%;
        }

        .right {
            align: left;
            width: 15%;
        }
    </style>
</head>

<body>
    <div class="header">
        <table class="kop">
            <tr>
                <td class="left"><img src="img/pertamina.jpg" width="120px" height="auto" alt="Logo"></td>
                <td class="center">
                    <div>
                        <span style="font-family: 'Times New Roman'; font-size:14pt"><strong>PT.
                                PERTAMINA EP CEPU ZONA
                                11 REGION 4 SUKOWATI FIELD</strong></span><br />
                        <span style="font-family: 'Times New Roman'; font-size:11pt">Jl. Lingkar Pertamina, Desa Rahayu,
                            Kecamatan Soko Tuban 62372, Jawa Timur</span><br />
                        <span style="font-family: 'Times New Roman'; font-size:11ptt">Telepon (0356) 811911
                            <br>http://www.pertamina.com</span>
                    </div>
                </td>
                <td class="right"><img src="img/sk.jpg" width="150px" height="auto" alt="Logo"></td>
            </tr>
        </table>
    </div>

    <div class="container">
        <h2 class="underline">INFORMASI MASA KONTRAK MITRA PERUSAHAAN</h2>
        <div class="date">
            <p>Dibuat Pada: <?php echo date('d-m-Y'); ?></p>
        </div>
        <table class="kolom">
            <tr>
                <th>Nomor Kontrak Perusahaan</th>
                <td>: {{ $riwayat->no_kontrak_perusahaan }}</td>
            </tr>
            <tr>
                <th>Nama Mitra Perusahaan</th>
                <td>: {{ $riwayat->nama_perusahaan }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>: {{ $riwayat->email }}</td>
            </tr>
            <tr>
                <th>Jenis Mitra</th>
                <td>: {{ $riwayat->jenis_mitra }}</td>
            </tr>
            <tr>
                <th>Website</th>
                <td>: {{ $riwayat->website }}</td>
            </tr>
            <tr>
                <th>No. Telp 1</th>
                <td>: {{ $riwayat->no_telp_1 }}</td>
            </tr>
            <tr>
                <th>No. Telp 2</th>
                @if ($riwayat->no_telp_2 === null)
                    <td>: -</td>
                @else
                    <td>: {{ $riwayat->no_telp_2 }}</td>
                @endif
            </tr>
            <tr>
                <th>No. Telp 3</th>
                @if ($riwayat->no_telp_3 === null)
                    <td>: -</td>
                @else
                    <td>: {{ $riwayat->no_telp_3 }}</td>
                @endif
            </tr>
            <tr>
                <th>Tanggal Kontrak Perusahaan Mitra</th>
            </tr>
            <tr>
                <th>a. Dimulai</th>
                <td>: {{ \Carbon\Carbon::parse($riwayat->tanggal_kontrak_awal_perusahaan)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>b. Berakhir</th>
                <td>: {{ \Carbon\Carbon::parse($riwayat->tanggal_kontrak_akhir_perusahaan)->format('d-m-Y') }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
