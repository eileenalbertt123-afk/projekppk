<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Rekap Fasilitas</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #19183b;
            margin: 30px;
        }

        .header {
            margin-bottom: 25px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #708993;
            font-size: 11px;
        }

        .info {
            margin-top: 15px;
            margin-bottom: 25px;
            padding: 10px 12px;
            background: #f5f7f7;
            border: 1px solid #e2ebe9;
        }

        .info strong {
            color: #19183b;
        }

        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #19183b;
        }

        .section-description {
            color: #708993;
            font-size: 10px;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th {
            background: #19183b;
            color: white;
            padding: 9px 8px;
            text-align: left;
            font-size: 10px;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #e5e9e8;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background: #fafcfc;
        }

        .status {
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #708993;
        }

        .summary {
            margin-top: 8px;
            margin-bottom: 20px;
            font-size: 10px;
            color: #708993;
        }

        .footer {
            margin-top: 25px;
            padding-top: 10px;
            border-top: 1px solid #e2ebe9;
            color: #708993;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="title">
            Laporan Rekap Fasilitas
        </div>

        <div class="subtitle">
            Book&Fix - Campus Facility Management
        </div>
    </div>

    <div class="info">
        <strong>Periode:</strong>

        @if ($tanggalMulai || $tanggalAkhir)
            {{ $tanggalMulai ?: 'Awal' }}
            -
            {{ $tanggalAkhir ?: 'Sekarang' }}
        @else
            Semua periode
        @endif
    </div>

    {{-- REKAP OKUPANSI --}}
    <div class="section-title">
        1. Rekap Okupansi Fasilitas
    </div>

    <div class="section-description">
        Rekap jumlah penggunaan fasilitas berdasarkan periode yang dipilih.
    </div>

    <table>
        <thead>
            <tr>
                <th>Fasilitas</th>
                <th>Tipe</th>
                <th>Lokasi</th>
                <th>Jumlah Penggunaan</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($rekap as $item)
                <tr>
                    <td>
                        {{ $item->name }}
                    </td>

                    <td>
                        {{ $item->type }}
                    </td>

                    <td>
                        {{ $item->location }}
                    </td>

                    <td>
                        {{ $item->jumlah_penggunaan }} kali
                    </td>

                    <td class="status">
                        @if ($item->status === 'tersedia')
                            Tersedia
                        @elseif ($item->status === 'dalam_perbaikan')
                            Dalam Perbaikan
                        @else
                            Nonaktif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty">
                        Belum ada data okupansi fasilitas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        Total fasilitas:
        <strong>{{ $rekap->count() }}</strong>
    </div>

    {{-- REKAP KERUSAKAN --}}
    <div class="section-title">
        2. Rekap Frekuensi Kerusakan Fasilitas
    </div>

    <div class="section-description">
        Rekap jumlah laporan kerusakan berdasarkan fasilitas dan lokasi.
    </div>

    <table>
        <thead>
            <tr>
                <th>Fasilitas</th>
                <th>Lokasi</th>
                <th>Frekuensi Kerusakan</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($rekapKerusakan as $item)
                <tr>
                    <td>
                        {{ $item->nama_fasilitas }}
                    </td>

                    <td>
                        {{ $item->lokasi }}
                    </td>

                    <td>
                        {{ $item->jumlah_kerusakan }} laporan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="empty">
                        Belum ada data kerusakan fasilitas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        Total laporan kerusakan:
        <strong>{{ $rekapKerusakan->sum('jumlah_kerusakan') }}</strong>
    </div>

    <div class="footer">
        Dokumen ini dibuat oleh sistem Book&Fix.
    </div>

</body>

</html>