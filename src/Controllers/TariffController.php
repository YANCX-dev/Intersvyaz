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
        echo "ID is {$id}";
        return $this->getViewPath('tariff/edit');
    }

    public function update(string $id)
    {
        $data = $_POST;

        if (empty($data['name']) || empty($data['price'])) {
            throw new \RuntimeException('Invalid input');
        }


        echo "SUCCESS UPDATE";
    }

    public function show(string $id): array
    {
        $model = $this->tariffModel->getTariffById($id);
        return $this->getViewPath('tariff/show', compact('model'));
    }

}

