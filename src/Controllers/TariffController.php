<?php

namespace App\Controllers;


use App\Models\Tariff\Tariff;

class TariffController extends BaseController
{
    private Tariff $tariffModel;

    public function __construct()
    {
        $this->tariffModel = new Tariff();
    }

    /**
     * @return array
     */
    public function index(): array
    {
        $model = $this->tariffModel->getTariffs();
        return $this->getViewPath('tariff/index', compact('model'));
    }

    /**
     * @return array
     */
    public function edit(string $id): array
    {
        $tariff = $this->tariffModel->getTariffById($id);
        return $this->getViewPath('tariff/edit', compact('tariff'));
    }


    public function update()
    {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
            http_response_code(400);

            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);

            return [];
        }

        try {

            $data = $_POST;

            if (empty($data['id'])) {
                throw new \InvalidArgumentException('ID тарифа обязателен.');
            }

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
                    throw new \Exception('Не удалось загрузить логотип.');
                }

                $data['logo'] = $filePath;
            }

            $this->tariffModel->updateTariffById($data['id'], $data);

            header('Content-Type: application/json');
            http_response_code(200);

            echo json_encode(['status' => 'success', 'message' => 'Tariff updated successfully']);

        } catch (\Exception $e) {
            http_response_code(500);

            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }

        return [];
    }

    /**
     * @param string $id
     * @return array
     */
    public function show(string $id): array
    {
        $model = $this->tariffModel->getTariffById($id);
        return $this->getViewPath('tariff/show', compact('model'));
    }

}

