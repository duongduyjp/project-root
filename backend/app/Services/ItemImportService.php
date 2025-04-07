<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class ItemImportService
{
    /**
     * Import items from CSV file
     *
     * @param UploadedFile $file
     * @return array
     */
    public function import(UploadedFile $file)
    {
        try {
            $path = $file->getRealPath();
            $data = [];
            $handle = fopen($path, 'r');

            if ($handle !== false) {
                // Đọc và kiểm tra BOM
                $bom = fread($handle, 3);
                if ($bom !== pack('CCC', 0xEF, 0xBB, 0xBF)) {
                    // Nếu không phải BOM, quay lại đầu file
                    rewind($handle);
                }

                // Đọc từng dòng với dấu phân cách là chấm phẩy
                while (($row = fgetcsv($handle, 0, ',')) !== false) {
                    // Bỏ qua dòng trống
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // Convert encoding nếu cần
                    $row = array_map(function ($value) {
                        $encoding = mb_detect_encoding($value, ['SJIS', 'UTF-8', 'ASCII'], true);
                        if ($encoding !== 'UTF-8') {
                            return mb_convert_encoding($value, 'UTF-8', $encoding);
                        }
                        return $value;
                    }, $row);

                    $data[] = $row;
                }
                fclose($handle);
            }

            Log::info('Raw CSV data:', ['data' => $data]);

            // Bỏ qua header nếu có
            if (count($data) > 0) {
                $firstRow = $data[0];
                Log::info('First row:', ['row' => $firstRow]);
                if (in_array('商品コード', $firstRow)) {
                    array_shift($data);
                }
            }

            $importCount = 0;
            $updateCount = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                Log::info('Processing row:', [
                    'index' => $index,
                    'row' => $row,
                    'count' => count($row),
                    'row_data' => $row
                ]);

                // Trim tất cả các giá trị
                $row = array_map('trim', $row);

                if (count($row) < 13) {
                    $errors[] = "行 " . ($index + 1) . ": データが不足しています。(必要な列: 商品コード、商品名、契約種別、重量、日極単価A、日極単価B、日極単価C、販売単価A、販売単価B、販売単価C、基本料単価A、基本料単価B、基本料単価C)";
                    continue;
                }

                try {
                    $itemData = [
                        'item_no' => $row[0],
                        'item_name' => $row[1],
                        'contract_type' => $row[2],
                        'weight' => $row[3],
                        'prices' => [
                            'A' => [
                                'daily' => (float)str_replace(',', '', $row[4]),
                                'sale' => (float)str_replace(',', '', $row[7]),
                                'basic_price' => (float)str_replace(',', '', $row[10])
                            ],
                            'B' => [
                                'daily' => (float)str_replace(',', '', $row[5]),
                                'sale' => (float)str_replace(',', '', $row[8]),
                                'basic_price' => (float)str_replace(',', '', $row[11])
                            ],
                            'C' => [
                                'daily' => (float)str_replace(',', '', $row[6]),
                                'sale' => (float)str_replace(',', '', $row[9]),
                                'basic_price' => (float)str_replace(',', '', $row[12])
                            ]
                        ]
                    ];

                    Log::info('Item data before save:', $itemData);

                    $item = Item::updateOrCreate(
                        ['item_no' => $itemData['item_no']],
                        $itemData
                    );

                    if ($item->wasRecentlyCreated) {
                        $importCount++;
                    } else {
                        $updateCount++;
                    }
                } catch (\Exception $e) {
                    Log::error('Error saving item:', [
                        'error' => $e->getMessage(),
                        'data' => $itemData ?? null
                    ]);
                    $errors[] = "行 " . ($index + 1) . ": " . $e->getMessage();
                }
            }

            return [
                'success' => empty($errors),
                'importCount' => $importCount,
                'updateCount' => $updateCount,
                'errors' => $errors
            ];
        } catch (\Exception $e) {
            Log::error('Import failed:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
