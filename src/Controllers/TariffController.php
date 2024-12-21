<?php

namespace App\Controllers;


class TariffController extends BaseController
{

    /**
     * @return string
     */
    public function index(): string
    {
        return $this->getViewPath('tariff/index');
    }

    /**
     * @return string
     */
    public function edit(): string
    {
        return $this->getViewPath('tariff/edit');
    }

}

