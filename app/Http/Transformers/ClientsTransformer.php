<?php

namespace App\Http\Transformers;


use App\Models\Clients;
use League\Fractal\TransformerAbstract;

class ClientsTransformer extends TransformerAbstract
{
    public function transform(Clients $clients)
    {
        return [
                'id' => $clients->id,
                'name' => $clients->name,
                'phone_tel' => $clients->phone_tel
        ];
    }
}