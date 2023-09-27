<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class InvoiceDpExport implements FromView, WithStyles, WithColumnWidths, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('pages.abp-page.print.invoice_dp', [
            'title' => 'Print Invoice DP',
            'breadcrumb' => 'This breadcrumb',
            'data' => $this->data,
        ]);
    }
    public function columnWidths(): array
    {
        return [
            'C' => 30,
            'G' => 40,
        ];
    }
    public function registerEvents(): array
    {

        return [
            AfterSheet::class => function (AfterSheet $event) {
                $rowHeights = [
                    1 => 30,
                    2 => 40,
                    3 => 20,
                    14 => 20,
                    22 => 70,
                ];
                $data = $this->data;

                $delegate = $event->sheet->getDelegate();

                foreach ($rowHeights as $rowIndex => $height) {
                    if ($rowIndex >= 14) {
                        $rowIndex += count($data['kapal']);
                    }
                    $delegate->getRowDimension($rowIndex)->setRowHeight($height);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $data = $this->data;
        $stylingRules = [
            'A4:C6',
            'F26:G26',
            'A26:C26',
            'A3:C6',
            'A7:G17',
            'D3:G6',
            'A3:C3',
            'D3:G3',
            'D18:G24',
            'A18:C24',
            'D18:G18',
            'A18:C18',
        ];

        $countKapal = count($data['kapal']);

        foreach ($stylingRules as &$rule) {
            // Pisahkan range kolom dan baris
            list($start, $end) = explode(':', $rule);

            // Ambil nomor baris awal
            $startRow = (int) filter_var($start, FILTER_SANITIZE_NUMBER_INT);

            // Jika nomor baris awal lebih besar atau sama dengan 14, tambahkan count($data['kapal']) ke range tersebut
            if ($startRow >= 14) {
                $endRow = (int) filter_var($end, FILTER_SANITIZE_NUMBER_INT);
                $newStartRow = $startRow + $countKapal;
                $newEndRow = $endRow + $countKapal;

                // Update aturan styling dengan range yang diperbarui
                $rule = "A{$newStartRow}:C{$newEndRow}";
            }
        }
        return [
            $stylingRules[0] => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Align text to the top
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Align text to the left
                ],
            ],
            $stylingRules[1] => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Align text to the top
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Align text to the left
                ],
            ],
            $stylingRules[2] => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Align text to the top
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Align text to the left
                ],
            ],
            $stylingRules[3] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            $stylingRules[4] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            $stylingRules[5] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            $stylingRules[6] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            $stylingRules[7] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            $stylingRules[8] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            $stylingRules[9] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            $stylingRules[10] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            $stylingRules[11] => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
        // $stylingRules = [
        //     'A3:C3',
        //     'D3:G3',
        //     'A4:C6',
        //     'A7:G13',
        //     'D3:G6',
        //     'A14:C14',
        //     'D14:G14',
        //     'A14:C20',
        //     'D14:G20',
        //     'A22:C22',
        //     'F22:G22',
        // ];

        // $stylingRules = [
        //     'A3:C3',
        //     'D3:G3',
        //     'A4:C6',
        //     'A7:G17',
        //     'D3:G6',
        //     'A18:C18',
        //     'D18:G18',
        //     'A18:C24',
        //     'D18:G24',
        //     'A26:C26',
        //     'F26:G26',
        // ];

        // $borderStyle = [
        //     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
        //     'color' => ['rgb' => '000000'],
        // ];

        // $centeredRanges = [0, 1, 5, 6];
        // $outlinedRanges = [0, 1, 5, 6];

        // foreach ($stylingRules as $index => $range) {
        //     $style = [
        //         'alignment' => [
        //             'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
        //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        //         ],
        //     ];

        //     if (in_array($index, $centeredRanges)) {
        //         $style['alignment'] = [
        //             'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        //             'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        //         ];
        //     }

        //     if (in_array($index, $outlinedRanges)) {
        //         $style['borders']['outline'] = $borderStyle;
        //     }

        //     $sheet->getStyle($range)->applyFromArray($style);
        // }
    }
}
