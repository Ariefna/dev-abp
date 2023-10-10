<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InvoiceDpExport implements FromView, WithStyles, WithColumnWidths, WithEvents, ShouldAutoSize
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
                $sheet = $event->sheet;
                $keywords = ['FREIGHT PO', 'Harga Cont', 'Subtotal', 'DP', 'PPN'];
                $rowCount = 0; // Initialize the row count
                $descriptionFound = false;
                $amountFound = false;

                foreach ($sheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();

                    foreach ($cellIterator as $cell) {
                        $cellValue = $cell->getValue();

                        // Check for 'Description' and 'Amount' headers
                        if ($cellValue === 'Description' || $cellValue === 'Amount') {
                            if ($cellValue === 'Description') {
                                $descriptionFound = true;
                            }
                            if ($cellValue === 'Amount') {
                                $amountFound = true;
                            }

                            // Get the row index where 'Description' or 'Amount' is found
                            $descriptionRow = $row->getRowIndex();

                            // Apply border style to the entire row
                            $sheet->getStyle("A$descriptionRow:C$descriptionRow")->applyFromArray([
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                    'right' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                            ]);
                            $sheet->getStyle("D$descriptionRow:G$descriptionRow")->applyFromArray([
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                    'right' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                                ],
                            ]);
                        }

                        // Check if the cell value contains any of the specified keywords
                        foreach ($keywords as $keyword) {
                            if (stripos($cellValue, $keyword) !== false) {
                                // Increment the row count when a keyword is found
                                $rowCount++;

                                // Apply border styles to the entire row (left and right borders)
                                $rowIndex = $row->getRowIndex();
                                $sheet->getStyle("A$rowIndex:C$rowIndex")->applyFromArray([
                                    'borders' => [
                                        'right' => [
                                            'borderStyle' => Border::BORDER_THICK,
                                            'color' => ['rgb' => '000000'],
                                        ],
                                        'left' => [
                                            'borderStyle' => Border::BORDER_THICK,
                                            'color' => ['rgb' => '000000'],
                                        ],
                                    ],
                                    'alignment' => [
                                        'vertical' => Alignment::VERTICAL_CENTER,
                                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                                    ],
                                ]);
                                $sheet->getStyle("D$rowIndex:G$rowIndex")->applyFromArray([
                                    'borders' => [
                                        'right' => [
                                            'borderStyle' => Border::BORDER_THICK,
                                            'color' => ['rgb' => '000000'],
                                        ],
                                        'left' => [
                                            'borderStyle' => Border::BORDER_THICK,
                                            'color' => ['rgb' => '000000'],
                                        ],
                                    ],
                                    'alignment' => [
                                        'vertical' => Alignment::VERTICAL_CENTER,
                                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                                    ],
                                ]);

                                // Remove bottom border
                                $sheet->getStyle("A$rowIndex:G$rowIndex")->getBorders()
                                    ->getBottom()->setBorderStyle(Border::BORDER_NONE);

                                break; // No need to check other cells in the same row once a keyword is found
                            }
                        }

                        // Check for the specific value 'Total Invoice'
                        if (stripos($cellValue, 'Total Invoice') !== false) {
                            // Apply border styles to the entire row (left, right, and bottom borders)
                            $rowIndex = $row->getRowIndex();
                            $sheet->getStyle("A$rowIndex:C$rowIndex")->applyFromArray([
                                'borders' => [
                                    'right' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                    'left' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                    'bottom' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                                ],
                            ]);
                            $sheet->getStyle("D$rowIndex:G$rowIndex")->applyFromArray([
                                'borders' => [
                                    'right' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                    'left' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                    'bottom' => [
                                        'borderStyle' => Border::BORDER_THICK,
                                        'color' => ['rgb' => '000000'],
                                    ],
                                ],
                                'alignment' => [
                                    'vertical' => Alignment::VERTICAL_CENTER,
                                    'horizontal' => Alignment::HORIZONTAL_LEFT,
                                ],
                            ]);

                            // Remove top border
                            $sheet->getStyle("A$rowIndex:G$rowIndex")->getBorders()
                                ->getTop()->setBorderStyle(Border::BORDER_NONE);
                        }
                        if (stripos($cellValue, 'Note') !== false) {
                            // Apply border styles to the entire row (left, right, and bottom borders)
                            $rowIndex = $row->getRowIndex();

                            // Remove top border
                            $sheet->getStyle("A$rowIndex:G$rowIndex")->getBorders()
                                ->getTop()->setBorderStyle(Border::BORDER_NONE);

                                $sheet->getRowDimension($rowIndex)->setRowHeight(80);

                                // Apply top alignment
                                $alignment = $sheet->getStyle("A$rowIndex:G$rowIndex")->getAlignment();
                                $alignment->setVertical(Alignment::VERTICAL_TOP);
                        }                        
                    }
                }
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(45);

                // Display the count using dd
                // dd("Count of rows containing specified keywords: $rowCount");

                // Modify other styling or logic here as needed
            },
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            'A4:C6' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Align text to the top
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Align text to the left
                ],
            ],
            'F26:G26' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Align text to the top
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Align text to the left
                ],
            ],
            'A26:C26' => [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Align text to the top
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT, // Align text to the left
                ],
            ],
            'A3:C6' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'A7:G17' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'D3:G6' => [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
            'A3:C3' => [
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
            'D3:G3' => [
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
    }

}