<?php

namespace App\Http\Transformers;


use App\Models\Clients\Record;
use League\Fractal\TransformerAbstract;

class RecordTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['chance'];

    public function transform(Record $record)
    {
        return [
            'id' => $record->id,
            'chance_id' => $record->chance_id,
            'name' => $record->name,
            'record_time' => $record->record_time
        ];
    }

    public function includeChance(Record $record)
    {
        return $this->item($record->chance, new ChanceTransformer());
    }
}