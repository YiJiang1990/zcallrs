<?php

namespace App\Http\Transformers;



use App\Models\ImportLog;
use League\Fractal\TransformerAbstract;

class ImportLogTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user'];

    public function transform(ImportLog $importLog)
    {
        return [
            'id' => $importLog->id,
            'number' => $importLog->number,
            'uid' => $importLog->uid,
            'type' => ( $importLog->type == 'clients')? '客户': (( $importLog->type == 'temporary')? '公海': '联系人'),
            'created_at' => $importLog->created_at->toDateTimeString()
        ];
    }

    public function includeUser(ImportLog $importLog)
    {
        return $this->item($importLog->user, new UserTransformer());
    }
}