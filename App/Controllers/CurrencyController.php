<?php

namespace App\Controllers;

use App\Repositories\BankRepository;
use App\Services\XmlToArray;

class CurrencyController
{
    public function index()
    {

        $repository = new \App\Repositories\BankRepository();

        return require_once __DIR__ . '/../Views/CurrencyShowView.php';
    }

    public function update()
    {

        $xml = new XmltoArray();
        $latestCurrencies = $xml->convert('https://www.bank.lv/vk/ecb.xml');

        $repository = new \App\Repositories\BankRepository();
        $repository->updateTable($latestCurrencies);
        //$repository->updateStored('USD','69');

        header('Location: /');
    }
}