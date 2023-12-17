<?php

namespace App\Export;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
class EventReportExport implements FromCollection
{
    protected mixed $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {

        $collection = collect([$this->getHeaders()]);

        foreach ($this->data as $item) {
            $row = []; // Создаем новую строку для каждой записи

            array_push($row, $item->name);
            array_push($row, $item->surname);
            array_push($row, $item->event_name);
            array_push($row, $item->date_event);
            array_push($row, $item->status);

            $collection->push($row); // Добавляем строку в коллекцию
        }

        return $collection;
    }

    private function getHeaders()
    {
        // Возвращаем массив с заголовками столбцов
        return ['Имя', 'Фамилия', 'Меропрятие', 'Дата меропрятие', 'статус']; // Замените на свои заголовки
    }
}
