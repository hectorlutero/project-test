<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ImportSpreadsheetService
{
    /**
     * @var ProductRepository
     * @var ServiceRepository
     */
    protected ProductRepository $productRepository;
    protected ServiceRepository $serviceRepository;

    /**
     * @param ProductRepository $companyRepository
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(ProductRepository $productRepository, ServiceRepository $serviceRepository)
    {
        $this->productRepository = $productRepository;
        $this->serviceRepository = $serviceRepository;
    }
    /**
     * Import Products
     * @return array
     */
    public function downloadModel($type)
    {

        if ($type) {

            if ($type === 'product')
                $entry = $this->productRepository->getProductFields();
            else
                $entry = $this->serviceRepository->getServiceFields();
            $columnsNames = [];
            foreach ($entry['fields'] as $key => $value) {
                if ($key !== 'product_category_id') {
                    array_push($columnsNames, $key);
                }
            }


            $type = ($type === 'service' ? "servico" : "produto");
            // (B) CREATE WORKSHEET
            $spreadsheetName = "planilha-modelo-" . $type;
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("First Sheet");

            $index = 1;
            // (C2) MORE WAYS SET VALUE
            if ($type === "servico") {
                $sheet->setCellValue([1, 1], 'nome_do_servico');
                $sheet->setCellValue([2, 1], 'descricao');
                $sheet->setCellValue([3, 1], 'preco');
                $sheet->setCellValue([4, 1], 'tempo_de_execucao');
                $sheet->setCellValue([5, 1], 'dia_util_inicio');
                $sheet->setCellValue([6, 1], 'dia_util_fim');
                $sheet->setCellValue([7, 1], 'sabados_inicio');
                $sheet->setCellValue([8, 1], 'sabados_fim');
                $sheet->setCellValue([9, 1], 'domingos_e_feriados_inicio');
                $sheet->setCellValue([10, 1], 'domingos_e_feriados_fim');
                $sheet->setCellValue([11, 1], 'e_24_7');
            } else {
                $sheet->setCellValue([1, 1], 'nome_do_produto');
                $sheet->setCellValue([2, 1], 'modelo');
                $sheet->setCellValue([3, 1], 'descricao');
                $sheet->setCellValue([4, 1], 'estoque');
                $sheet->setCellValue([5, 1], 'preco');
                $sheet->setCellValue([6, 1], 'sku');
            }

            // $sheet->setCellValue([1, $index], $column);
            $tempFilePath = './file.xlsx';
            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFilePath);

            $response = response()->download($tempFilePath, $spreadsheetName . '.xlsx', [
                'Content-Transfer-Encoding' => 'binary',
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            return $response;
        }
    }
    public function importData($fileData)
    {
        function formatTime($date)
        {
            if ($date !== null) {

                return date("H:i:s", strtotime($date));
            }
            return "NULL";
        }

        /**
         * @param array $service_work_days
         * @param $pre
         * @param $service_id
         * @param $now
         * @return void
         */


        $file = $fileData['spreadsheet'];
        if (!$file->isValid()) {
            throw new Exception('File upload failed');
        } else {


            $tmpFilePath = $file->getPathname();

            $spreadsheet = IOFactory::load($tmpFilePath);
            $worksheet = $spreadsheet->getActiveSheet();

            $data = $worksheet->toArray();

            $now = date("Y-m-d H:i:s");
            $array_errors = [];
            $count_errors = 0;
            $count_success = 0;
            $errors_indexes = [];
            if ($fileData['type'] === 'service') {
                foreach ($data as $key => $service) {


                    if ($key === 0) {

                        if (
                            $service[0] !== 'nome_do_servico' ||
                            $service[1] !== 'descricao' ||
                            $service[2] !== 'preco' ||
                            $service[3] !== 'tempo_de_execucao' ||
                            $service[4] !== 'dia_util_inicio' ||
                            $service[5] !== 'dia_util_fim' ||
                            $service[6] !== 'sabados_inicio' ||
                            $service[7] !== 'sabados_fim' ||
                            $service[8] !== 'domingos_e_feriados_inicio' ||
                            $service[9] !== 'domingos_e_feriados_fim' ||
                            $service[10] !== 'e_24_7'
                        ) {
                            $result = [
                                'status' => false,
                                'msg' => "Esta tabela é inválida para importação de serviços, baixe o modelo da tabela para importação correta",
                            ];

                            return $result;
                        }
                    }
                    if ($key !== 0) {
                        if (!$service[0]) {
                            $array_errors[] = "Campo nome não pode estar vazio em nenhum índice da tabela; serviço de índice: " . $key;
                            $errors_indexes[] = $key;
                        }
                        if (!$service[1]) {
                            $array_errors[] = "Campo descrição não pode estar vazio em nenhum índice da tabela; serviço de índice: " . $key;
                            $errors_indexes[] = $key;
                        }
                        if (!$service[2]) {
                            $array_errors[] = "Campo preço não pode estar vazio em nenhum índice da tabela; serviço de índice: " . $key;
                            $errors_indexes[] = $key;
                        }


                        if (!in_array($key, $errors_indexes)) {

                            $row = [];
                            $row['company_id'] = $fileData['company'];
                            $row['name'] = $service[0];
                            $row['slug'] = $service[0];
                            $row['status'] = 'DRAFT';
                            $row['description'] = $service[1];
                            $row['price'] = $service[2];
                            $row['execution_time'] = $service[3];
                            $row['working_days_start'] = $service[4];
                            $row['working_days_end'] = $service[5];
                            $row['saturdays_start'] = $service[6];
                            $row['saturdays_end'] = $service[7];
                            $row['sundays_n_holidays_start'] = $service[8];
                            $row['sundays_n_holidays_end'] = $service[9];
                            $row['is24_7'] = $service[10];
                            $row['id'] = 'new';

                            try {
                                $row = array_filter($row);
                                $result = $this->serviceRepository->save($row);
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Log::info($e->getMessage());
                                return throw new \InvalidArgumentException('Unable to update service data');
                            }

                            $count_success++;

                        } else
                            $count_errors++;
                    }
                }
                $msg = "";
                if ($count_errors > 0 && $count_success == 0) {
                    $status = false;
                    $msg .= "Encontramos alguns erros durante a importação.<br/>" . join("<br/>", $array_errors);
                }
                if ($count_success > 0 && $count_errors == 0) {
                    $status = 'success';
                    $msg .= "Importação feita com sucesso! Foram importados $count_success serviços.";
                }
                if ($count_success > 0 && $count_errors > 0) {
                    $status = 'warning';
                    $msg .= "Foram importados $count_success serviços. A importação falhou para alguns deles.<br/>" . join("<br/>", $array_errors);
                }
                $result = [
                    "status" => $status,
                    "msg" => $msg,
                    "company_id" => $fileData['company']
                ];

                return $result;
            } else {

                foreach ($data as $key => $product) {
                    if ($key === 0) {
                        if (
                            $product[0] !== 'nome_do_produto' ||
                            $product[1] !== 'modelo' ||
                            $product[2] !== 'descricao' ||
                            $product[3] !== 'estoque' ||
                            $product[4] !== 'preco' ||
                            $product[5] !== 'sku'
                        ) {

                            $result = [
                                'status' => false,
                                'msg' => "Esta tabela é inválida para importação de produtos, baixe o modelo da tabela para importação correta",
                            ];

                            return $result;
                        }
                    }

                    if ($key !== 0) {
                        if (count(array_diff(array_values($product), [NULL])) === 0) {
                            continue;
                        }

                        if (!$product[0]) {
                            $array_errors[] = "Campo nome não pode estar vazio em nenhum índice da tabela; produto de índice: " . $key;
                            $errors_indexes[] = $key;
                        }
                        if (!$product[2]) {
                            $array_errors[] = "Campo descrição não pode estar vazio em nenhum índice da tabela; produto de índice: " . $key;
                            $errors_indexes[] = $key;
                        }
                        if (!$product[3]) {
                            $array_errors[] = "Campo estoque não pode estar vazio em nenhum índice da tabela, mínimo valor deve ser 0; produto de índice: " . $key;
                            $errors_indexes[] = $key;
                        }
                        if (!$product[4]) {
                            $array_errors[] = "Campo preço não pode estar vazio em nenhum índice da tabela; produto de índice: " . $key;
                            $errors_indexes[] = $key;
                        }
                        if (!in_array($key, $errors_indexes)) {

                            $row = [];
                            $row['company_id'] = $fileData['company'];
                            $row['name'] = $product[0];
                            $row['status'] = 'DRAFT';
                            $row['model'] = $product[1];
                            $row['description'] = $product[2];
                            $row['stock'] = $product[3];
                            $row['price'] = $product[4];
                            $row['sku'] = $product[5];
                            $row['slug'] = $product[0];
                            $row['id'] = 'new';
                            try {
                                $row = array_filter($row);
                                $result = $this->productRepository->save($row);
                            } catch (\Exception $e) {
                                DB::rollBack();
                                Log::info($e->getMessage());
                                return throw new \InvalidArgumentException('Unable to update product data');
                            }
                            $count_success++;
                        } else
                            $count_errors++;
                    }
                }

                $msg = "";
                if ($count_errors > 0 && $count_success == 0) {
                    $status = false;
                    $msg .= "Encontramos alguns erros durante a importação.<br/>" . join("<br/>", $array_errors);
                }
                if ($count_success > 0 && $count_errors == 0) {
                    $status = 'success';
                    $msg .= "Importação feita com sucesso! Foram importados $count_success produtos.";
                }
                if ($count_success > 0 && $count_errors > 0) {
                    $status = 'warning';
                    $msg .= "Foram importados $count_success produtos. A importação falhou para alguns deles.<br/>" . join("<br/>", $array_errors);
                }

                $result = [
                    "status" => $status,
                    "msg" => $msg,
                    "company_id" => $fileData['company']
                ];

                return $result;
            }


        }
    }
}