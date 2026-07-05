<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Perpustakaan</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #2D7076;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2D7076;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 12px;
        }
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background: #f5f5f5;
            border-radius: 5px;
        }
        .info table {
            width: 100%;
            font-size: 12px;
        }
        .info td {
            padding: 3px 5px;
        }
        .info .label {
            font-weight: bold;
            width: 120px;
        }
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data th {
            background: #2D7076;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }
        table.data td {
            padding: 6px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        table.data tr:nth-child(even) {
            background: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h1>LAPORAN PERPUSTAKAAN</h1>
        <p>SMAIT Al-Uswah Surabaya</p>
        <p style="font-size:10px; color:#999;">
            Periode: {{ \Carbon\Carbon::parse($periodeMulai)->translatedFormat('d F Y') }} - 
            {{ \Carbon\Carbon::parse($periodeSelesai)->translatedFormat('d F Y') }}
        </p>
    </div>

    {{-- INFO --}}
    <div class="info">
        <table>
            <tr>
                <td class="label">Jenis Laporan</td>
                <td>: {{ ucfirst(str_replace('_', ' ', $jenis)) }}</td>
            </tr>
            <tr>
                <td class="label">Total Data</td>
                <td>: {{ $data->count() }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ now()->translatedFormat('d F Y H:i') }}</td>
            </tr>
        </table>
    </div>

    {{-- DATA --}}
    @if($jenis == 'peminjaman')
        <table class="data">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Total Item</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>{{ $item->anggota->nama_anggota ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $item->status_transaksi == 'dikembalikan' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($item->status_transaksi) }}
                            </span>
                        </td>
                        <td class="text-center">{{ $item->total_item }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    @elseif($jenis == 'buku_terpopuler')
        <table class="data">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th class="text-center">Total Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->buku->judul_buku ?? '-' }}</td>
                        <td>{{ $item->buku->penulis ?? '-' }}</td>
                        <td class="text-center"><strong>{{ $item->total_dipinjam }}</strong></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    @elseif($jenis == 'anggota_aktif')
        <table class="data">
            <thead>
                <tr>
                    <th>No Anggota</th>
                    <th>Nama Anggota</th>
                    <th>Kelas</th>
                    <th class="text-center">Total Transaksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->no_anggota ?? '-' }}</td>
                        <td>{{ $item->nama_anggota }}</td>
                        <td>{{ $item->kelas ?? '-' }}</td>
                        <td class="text-center">{{ $item->transaksis_count }}</td>
                        <td>
                            <span class="badge badge-success">{{ ucfirst($item->status_anggota) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    @elseif($jenis == 'denda')
        <table class="data">
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th class="text-center">Hari Terlambat</th>
                    <th class="text-center">Total Denda</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr>
                        <td>{{ $item->anggota->nama_anggota ?? '-' }}</td>
                        <td>{{ $item->detailTransaksi->buku->judul_buku ?? '-' }}</td>
                        <td class="text-center">{{ $item->jumlah_hari_terlambat }} hari</td>
                        <td class="text-center">Rp {{ number_format($item->total_denda, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $item->status_denda == 'lunas' ? 'badge-success' : 'badge-danger' }}">
                                {{ ucfirst($item->status_denda) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    @endif

    {{-- FOOTER --}}
    <div class="footer">
        <p>Dicetak oleh: {{ session('auth_name') ?? 'Admin' }} | {{ now()->translatedFormat('d F Y H:i') }}</p>
        <p>&copy; {{ date('Y') }} Perpustakaan SMAIT Al-Uswah</p>
    </div>

</body>
</html>