<?php

namespace App\Exports;

use App\Models\Facility;
use App\Models\Report;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FacilityRecapExport implements FromCollection, WithHeadings, WithEvents, WithTitle
{
    protected $tanggalMulai;
    protected $tanggalAkhir;

    public function __construct($tanggalMulai = null, $tanggalAkhir = null)
    {
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
    }

    public function collection(): Collection
    {
        /*
         * Rekap penggunaan fasilitas
         */
        $rekap = Facility::withCount([
            'reservationDetails as jumlah_penggunaan' => function ($query) {
                $query->whereHas('reservation', function ($q) {
                    $q->where('status', 'disetujui');

                    if ($this->tanggalMulai) {
                        $q->whereDate(
                            'start_time',
                            '>=',
                            $this->tanggalMulai
                        );
                    }

                    if ($this->tanggalAkhir) {
                        $q->whereDate(
                            'start_time',
                            '<=',
                            $this->tanggalAkhir
                        );
                    }
                });
            }
        ])->get();

        /*
         * Rekap frekuensi kerusakan
         */
        $rekapKerusakan = Report::with('facility')
            ->when($this->tanggalMulai, function ($query) {
                $query->whereDate(
                    'created_at',
                    '>=',
                    $this->tanggalMulai
                );
            })
            ->when($this->tanggalAkhir, function ($query) {
                $query->whereDate(
                    'created_at',
                    '<=',
                    $this->tanggalAkhir
                );
            })
            ->get()
            ->groupBy('facility_id')
            ->map(function ($reports) {
                $reportPertama = $reports->first();

                return [
                    'nama_fasilitas' => $reportPertama->facility?->name ?? '-',
                    'lokasi' => $reportPertama->facility?->location ?? '-',
                    'jumlah_kerusakan' => $reports->count(),
                ];
            })
            ->values();

        /*
         * Data utama untuk Excel.
         *
         * Bagian okupansi menggunakan 6 kolom.
         * Bagian kerusakan menggunakan 3 kolom pertama.
         */
        $data = collect();

        foreach ($rekap as $fasilitas) {
            $data->push([
                $fasilitas->name,
                $fasilitas->type,
                $fasilitas->location,
                $fasilitas->capacity,
                $fasilitas->status,
                $fasilitas->jumlah_penggunaan,
            ]);
        }

        /*
         * Baris kosong sebagai pemisah
         */
        $data->push([
            '',
            '',
            '',
            '',
            '',
            '',
        ]);

        /*
         * Judul bagian kerusakan
         */
        $data->push([
            'REKAP FREKUENSI KERUSAKAN FASILITAS',
            '',
            '',
            '',
            '',
            '',
        ]);

        /*
         * Header bagian kerusakan
         */
        $data->push([
            'Nama Fasilitas',
            'Lokasi',
            'Frekuensi Kerusakan',
            '',
            '',
            '',
        ]);

        /*
         * Data kerusakan
         */
        foreach ($rekapKerusakan as $kerusakan) {
            $data->push([
                $kerusakan['nama_fasilitas'],
                $kerusakan['lokasi'],
                $kerusakan['jumlah_kerusakan'],
                '',
                '',
                '',
            ]);
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Nama Fasilitas',
            'Tipe',
            'Lokasi',
            'Kapasitas',
            'Status',
            'Jumlah Penggunaan',
        ];
    }

    public function title(): string
    {
        return 'Rekap Fasilitas';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                /*
                 * Tambahkan ruang untuk judul utama
                 */
                $sheet->insertNewRowBefore(1, 4);

                /*
                 * Judul utama
                 */
                $sheet->mergeCells('A1:F1');

                $sheet->setCellValue(
                    'A1',
                    'REKAP PENGGUNAAN DAN KERUSAKAN FASILITAS'
                );

                /*
                 * Nama sistem
                 */
                $sheet->mergeCells('A2:F2');

                $sheet->setCellValue(
                    'A2',
                    'Book&Fix - Campus Facility Management'
                );

                /*
                 * Periode
                 */
                $periode = 'Semua periode';

                if ($this->tanggalMulai || $this->tanggalAkhir) {
                    $periode =
                        ($this->tanggalMulai ?: 'Awal') .
                        ' - ' .
                        ($this->tanggalAkhir ?: 'Sekarang');
                }

                $sheet->mergeCells('A3:F3');

                $sheet->setCellValue(
                    'A3',
                    'Periode: ' . $periode
                );

                /*
                 * Baris kosong
                 */
                $sheet->mergeCells('A4:F4');

                $sheet->setCellValue('A4', '');

                /*
                 * Header okupansi berada di baris 5
                 */
                $sheet->getStyle('A5:F5')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => 'FFFFFF',
                        ],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '19183B',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => 'D9E2E1',
                            ],
                        ],
                    ],
                ]);

                /*
                 * Hitung jumlah fasilitas untuk menentukan
                 * posisi bagian kerusakan.
                 */
                $jumlahFasilitas = Facility::count();

                /*
                 * Data okupansi dimulai dari baris 6.
                 */
                $barisTerakhirOkupansi = 5 + $jumlahFasilitas;

                /*
                 * Baris setelah data okupansi:
                 *
                 * +1 = baris kosong
                 * +2 = judul kerusakan
                 * +3 = header kerusakan
                 */
                $barisJudulKerusakan = $barisTerakhirOkupansi + 2;
                $barisHeaderKerusakan = $barisJudulKerusakan + 1;
                $barisDataKerusakan = $barisHeaderKerusakan + 1;

                /*
                 * Judul bagian kerusakan
                 */
                $sheet->mergeCells(
                    'A' . $barisJudulKerusakan . ':F' . $barisJudulKerusakan
                );

                $sheet->setCellValue(
                    'A' . $barisJudulKerusakan,
                    'REKAP FREKUENSI KERUSAKAN FASILITAS'
                );

                $sheet->getStyle(
                    'A' . $barisJudulKerusakan . ':F' . $barisJudulKerusakan
                )->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 13,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                /*
                 * Header kerusakan
                 */
                $sheet->setCellValue(
                    'A' . $barisHeaderKerusakan,
                    'Nama Fasilitas'
                );

                $sheet->setCellValue(
                    'B' . $barisHeaderKerusakan,
                    'Lokasi'
                );

                $sheet->setCellValue(
                    'C' . $barisHeaderKerusakan,
                    'Frekuensi Kerusakan'
                );

                $sheet->getStyle(
                    'A' . $barisHeaderKerusakan .
                    ':C' . $barisHeaderKerusakan
                )->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => 'FFFFFF',
                        ],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '19183B',
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => [
                                'rgb' => 'D9E2E1',
                            ],
                        ],
                    ],
                ]);

                /*
                 * Hitung jumlah fasilitas yang memiliki laporan
                 * kerusakan pada periode yang dipilih.
                 */
                $jumlahDataKerusakan = Report::query()
                    ->when($this->tanggalMulai, function ($query) {
                        $query->whereDate(
                            'created_at',
                            '>=',
                            $this->tanggalMulai
                        );
                    })
                    ->when($this->tanggalAkhir, function ($query) {
                        $query->whereDate(
                            'created_at',
                            '<=',
                            $this->tanggalAkhir
                        );
                    })
                    ->whereNotNull('facility_id')
                    ->distinct('facility_id')
                    ->count('facility_id');

                /*
                 * Baris terakhir data kerusakan
                 */
                $barisTerakhirKerusakan =
                    $barisDataKerusakan +
                    max($jumlahDataKerusakan - 1, 0);

                /*
                 * Style isi tabel okupansi
                 */
                if ($jumlahFasilitas > 0) {
                    $sheet->getStyle(
                        'A6:F' . $barisTerakhirOkupansi
                    )->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => [
                                    'rgb' => 'E2E8E7',
                                ],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    /*
                     * Kapasitas
                     */
                    $sheet->getStyle(
                        'D6:D' . $barisTerakhirOkupansi
                    )->getAlignment()->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );

                    /*
                     * Jumlah penggunaan
                     */
                    $sheet->getStyle(
                        'F6:F' . $barisTerakhirOkupansi
                    )->getAlignment()->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );
                }

                /*
                 * Style isi tabel kerusakan
                 */
                if ($jumlahDataKerusakan > 0) {
                    $sheet->getStyle(
                        'A' . $barisDataKerusakan .
                        ':C' . $barisTerakhirKerusakan
                    )->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                                'color' => [
                                    'rgb' => 'E2E8E7',
                                ],
                            ],
                        ],
                        'alignment' => [
                            'vertical' => Alignment::VERTICAL_CENTER,
                        ],
                    ]);

                    /*
                     * Frekuensi kerusakan rata tengah
                     */
                    $sheet->getStyle(
                        'C' . $barisDataKerusakan .
                        ':C' . $barisTerakhirKerusakan
                    )->getAlignment()->setHorizontal(
                        Alignment::HORIZONTAL_CENTER
                    );
                }

                /*
                 * Style judul utama
                 */
                $sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                /*
                 * Style subtitle
                 */
                $sheet->getStyle('A2:F2')->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size' => 11,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                /*
                 * Style periode
                 */
                $sheet->getStyle('A3:F3')->applyFromArray([
                    'font' => [
                        'size' => 10,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                /*
                 * Lebar kolom
                 */
                $sheet->getColumnDimension('A')->setWidth(28);
                $sheet->getColumnDimension('B')->setWidth(24);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(14);
                $sheet->getColumnDimension('E')->setWidth(20);
                $sheet->getColumnDimension('F')->setWidth(20);

                /*
                 * Tinggi baris
                 */
                $sheet->getRowDimension(1)->setRowHeight(25);
                $sheet->getRowDimension(5)->setRowHeight(25);

                /*
                 * Freeze header okupansi
                 */
                $sheet->freezePane('A6');

                /*
                 * Filter hanya untuk tabel okupansi
                 */
                if ($jumlahFasilitas > 0) {
                    $sheet->setAutoFilter(
                        'A5:F' . $barisTerakhirOkupansi
                    );
                }
            },
        ];
    }
}