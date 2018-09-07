<?php
namespace App\Exports;

use App\Models\Clients;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientsExport implements FromCollection,WithHeadings
{
    protected $data = '';
    protected $head = '';
    public function __construct($data,$head)
    {
        $this->data = $data;
        $this->head = $head;
    }

    public function collection()
    {
        return (new Collection($this->data));
    }

    public function headings(): array
    {
        return $this->head;
    }
}