<!DOCTYPE html>
<html>

<head>
    <title>Laporan Masa Kerja Karyawan</title>
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
                <td class="left"><img src="img/pertamina.jpg" width="120px" height="auto" alt="Logo"</td>
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
        <h2 class="underline">INFORMASI MASA KERJA KARYAWAN</h2>
        <div class="date">
            <p>Dibuat Pada: <?php echo date('d-m-Y'); ?></p>
        </div>
        <table class="kolom">
            <tr>
                <th>Nama Induk Karyawan</th>
                <td>: {{ $kontrak->no_induk_karyawan }}</td>
            </tr>
            <tr>
                <th>Nama Karyawan</th>
                <td>: {{ $kontrak->nama_karyawan }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>: {{ \Carbon\Carbon::parse($kontrak->tanggal_lahir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>: {{ $kontrak->email }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>: {{ $pegawai->sex }}</td>
            </tr>
            <tr>
                <th>Divisi</th>
                <td>: {{ $pegawai->divisi }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>: {{ $pegawai->jabatan }}</td>
            </tr>
            <tr>
                <th>Jenis Mitra</th>
                <td>: {{ $pegawai->jenis_mitra }}</td>
            </tr>
            <tr>
                <th>Nama Mitra Perusahaan</th>
                <td>: {{ $pegawai->nama_perusahaan }}</td>
            </tr>
            <tr>
                <th>Tanggal Kontrak Perusahaan </th>
            </tr>
            <tr>
                <th>a. Dimulai</th>
                <td>: {{ \Carbon\Carbon::parse($pegawai->tanggal_kontrak_awal_perusahaan)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>b. Berakhir</th>
                <td>: {{ \Carbon\Carbon::parse($pegawai->tanggal_kontrak_akhir_perusahaan)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Kontrak Karyawan </th>
            </tr>
            <tr>
                <th>a. Dimulai</th>
                <td>: {{ \Carbon\Carbon::parse($kontrak->tanggal_kontrak_awal)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>b. Berakhir</th>
                <td>: {{ \Carbon\Carbon::parse($kontrak->tanggal_kontrak_akhir)->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <th>Tanggal Pensiun</th>
                <td>: {{ date('d-m-Y', strtotime($kontrak->tanggal_lahir . ' + 54 years')) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
