<?php

namespace App\Controllers;


use App\Helpers\Validator;
use App\Models\Tariff\Tariff;
use Cassandra\Date;
use Dompdf\Dompdf;
use Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use League\Csv\Writer;
use SplTempFileObject;

class TariffController extends BaseController
{
    private Tariff $tariffModel;

    public function __construct()
    {
        $this->tariffModel = new Tariff();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function index(): array
    {
        $model = $this->tariffModel->getTariffs();
        return $this->getViewPath('tariff/index', compact('model'));
    }

    public function csvToolsPage(): array
    {
        return $this->getViewPath('tariff/csvtools', []);
    }

    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function edit(string $id): array
    {
        $tariff = $this->tariffModel->getTariffById($id);
        return $this->getViewPath('tariff/edit', compact('tariff'));
    }


    /**
     * @return array
     */
    public function update(): array
    {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(400);

            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);

            return [];
        }

        try {

            $data = $_POST;

            $validator = new Validator();

            $validator
                ->required('id', $data['id'])
                ->required('name', $data['name'])
                ->string('name', $data['name'])
                ->minLength('name', $data['name'], 3)
                ->required('description', $data['description'])
                ->minLength('description', $data['description'], 5)
                ->string('description', $data['description'])
                ->required('price', $data['price'])
                ->number('price', $data['price'])
                ->required('created_at', $data['created_at'])
                ->date('created_at', $data['created_at'])
                ->required('expires_at', $data['expires_at'])
                ->date('expires_at', $data['expires_at'])
                ->required('speed', $data['speed'])
                ->maxLength('speed', $data['speed'], 5)
                ->number('speed', $data['speed']);

            if ($validator->hasErrors()) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => $validator->getErrors()]);
                return [];
            }

            if (empty($data['id'])) {
                throw new \InvalidArgumentException('ID тарифа обязателен.');
            }

            $currentTariff = $this->tariffModel->getTariffById($data['id']);
            $currentLogo = $currentTariff['logo'] ?? null;

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {

                $logo = $_FILES['logo'];
                $allowedTypes = ['image/jpeg', 'image/png'];

                if (!in_array($logo['type'], $allowedTypes)) {
                    throw new \InvalidArgumentException('Неподдерживаемый формат файла. Используйте JPG или PNG.');
                }

                if ($logo['size'] > 2 * 1024 * 1024) {
                    throw new \InvalidArgumentException('Размер файла слишком большой. Максимум 2MB.');
                }

                $extension = pathinfo($logo['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('logo_', true) . '.' . $extension;

                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/tariff/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filePath = 'uploads/tariff/' . $newFileName;

                if (!move_uploaded_file($logo['tmp_name'], $filePath)) {
                    throw new Exception('Не удалось загрузить логотип.');
                }

                if ($currentLogo && file_exists($currentLogo)) {
                    unlink($currentLogo);
                }

                $data['logo'] = $filePath;
            }

            $this->tariffModel->updateTariffById($data['id'], $data);

            header('Content-Type: application/json');
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Tariff updated successfully']);

            return [];

        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);

            return [];
        }


    }

    /**
     * @param string $id
     * @return array|void
     */
    public function show(string $id)
    {
        try {
            $model = $this->tariffModel->getTariffById($id);
            return $this->getViewPath('tariff/show', compact('model'));
        } catch (Exception $e) {
            http_response_code(404);
        }

    }


    public function exportTariffsToCSV(): array
    {
        try {
            $tariffs = $this->tariffModel->getAllTariffs();

            if (empty($tariffs)) {
                throw new \RuntimeException('Нет данных для экспорта');
            }

            $csv = Writer::createFromFileObject(new SplTempFileObject());
            $csv->setDelimiter(';');

            $csv->insertOne(['Id', 'Name', 'Description', 'Price', 'Created_at', 'Expires_at', 'Speed', 'Logo']);

            foreach ($tariffs as $tariff) {
                $csv->insertOne([
                    $tariff['id'],
                    $tariff['name'],
                    $tariff['description'],
                    $tariff['price'],
                    $tariff['created_at'],
                    $tariff['expires_at'],
                    $tariff['speed'],
                    $tariff['logo'] ?? '',
                ]);

            }

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="tariffs_export_' . date('Y-m-d_H-i-s') . '.csv"');
            echo $csv->toString();

        } catch (Exception $e) {
            echo $e->getMessage();
        }

        return [];
    }


    /**
     * @throws UnavailableStream
     * @throws \DateMalformedStringException
     * @throws InvalidArgument
     * @throws \League\Csv\Exception
     */
    public function importTariffsFromCSV(): array
    {
        if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('Ошибка при загрузке файла');
        }

        $filePath = $_FILES['csv_file']['tmp_name'];

        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        $errors = [];

        foreach ($records as $index => $record) {
            $success = $this->tariffModel->createTariff([
                'name' => $record['Name'],
                'description' => $record['Description'],
                'price' => $record['Price'],
                'speed' => $record['Speed'],
                'created_at' => (new \DateTime())->format('Y-m-d'),
                'expires_at' => (new \DateTime($record['Expires_at']))->format('Y-m-d'),
                'logo' => $record['Logo'] ?? null,
            ]);

            if (!$success) {
                $errors[] = "Ошибка при импорте записи на строке (Имя тарифа не уникально) " . ($index + 1);
            }
        }

        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        header('Location: /');

        return [];
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function exportTariffsToPDF(): array
    {
        $tariffs = $this->tariffModel->getAllTariffs();

        if (empty($tariffs)) {
            throw new \RuntimeException('Нет данных для экспорта');
        }

        $html = '
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <h1>Список тарифов</h1>';
        $html .= '<table>';
        $html .= '<thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Цена</th>
                    <th>Скорость</th>
                    <th>Дата подключения</th>
                    <th>Дата окончания</th>
                </tr>
              </thead>';
        $html .= '<tbody>';

        foreach ($tariffs as $tariff) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($tariff['id']) . '</td>';
            $html .= '<td>' . htmlspecialchars($tariff['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($tariff['description']) . '</td>';
            $html .= '<td>' . htmlspecialchars($tariff['price']) . ' ₽</td>';
            $html .= '<td>' . htmlspecialchars($tariff['speed']) . ' Мбит/с</td>';
            $html .= '<td>' . (new \DateTime($tariff['created_at']))->format('d.m.Y') . '</td>';
            $html .= '<td>' . (new \DateTime($tariff['expires_at']))->format('d.m.Y') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';


        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);


        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="tariffs.pdf"');
        echo $dompdf->output();

        return [];
    }

    public function dd($args)
    {
        echo '<pre>';
        var_dump($args);
        echo '</pre>';
    }

}

