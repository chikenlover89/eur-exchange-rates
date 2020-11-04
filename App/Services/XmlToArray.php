<?php

namespace App\Services;

class XmlToArray
{
    public function convert(string $adress): array
    {
        $input = file_get_contents($adress);
        $service = new \Sabre\Xml\Service();
        $service->elementMap = [
            '{http://www.bank.lv/vk/LBCurrencyRates.xsd}' => 'Sabre\Xml\Element\KeyValue',
        ];
        $data = $service->parse($input);

        $output = [];
        foreach ($data[1]['value'] as $item) {
            $output[$item['value'][0]['value']] = $item['value'][1]['value'];
        }

        return $output;
    }
}