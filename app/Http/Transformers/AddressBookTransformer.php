<?php

namespace App\Http\Transformers;

use App\Models\AddressBook;
use League\Fractal\TransformerAbstract;

class AddressBookTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['clients'];

    public function transform(AddressBook $addressBook)
    {
        return [
                'id' => $addressBook->id,
                'name' => $addressBook->name,
                'tel' => $addressBook->tel,
                'email' => $addressBook->email,
                'client_id' => $addressBook->client_id,
        ];
    }

    public function includeClients(AddressBook $addressBook)
    {
        return $this->item($addressBook->clients, new ClientsTransformer());
    }

}