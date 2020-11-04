<?php

namespace App\Repositories;

class BankRepository
{
    public function getAll(): array
    {
        $currencies = query()
            ->select('name', 'value')
            ->from('currency')
            ->execute()
            ->fetchAllAssociative();
        foreach ($currencies as $c) {
            $formatC[$c['name']] = $c['value'];
        }

        return $formatC;

    }

    public function storeOne(string $name, string $value): void
    {
        query()
            ->insert('currency')
            ->values([
                'name' => ':name',
                'value' => ':value',
            ])
            ->setParameters([
                'name' => $name,
                'value' => $value,
            ])
            ->execute();
    }

    public function isStored(string $name): bool
    {
        $currency = query()
            ->select('name', 'value')
            ->from('currency')
            ->where('name = :name')
            ->setParameter(':name', $name)
            ->execute()
            ->fetchAssociative();

        if ($currency == false) {
            return false;
        }
        return true;
    }

    public function returnStored(string $name): array
    {
        $currency = query()
            ->select('name', 'value')
            ->from('currency')
            ->where('name = :name')
            ->setParameter(':name', $name)
            ->execute()
            ->fetchAssociative();

        if ($currency == false) {
            return [];
        }
        return $currency;
    }

    public function updateStored(string $name, string $value): void
    {
        $currency = query()
            ->update('currency')
            ->set('value', $value)
            ->where('name = :name')
            ->setParameter(':name', $name)
            ->execute();

    }

    public function updateTable(array $newValues): void
    {
        foreach ($newValues as $i => $v) {
            if ($this->isStored($i)) {
                $this->updateStored($i, $v);
            } else {
                if(strlen($i)==3){
                    $this->storeOne($i, $v);
                }
            }

        }
    }

}