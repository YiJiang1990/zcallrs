<?php

namespace App\Http\Transformers;

use App\Models\Clients\Chance;
use League\Fractal\TransformerAbstract;

class ChanceTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['clients','product','addressBook','selectsTab','follow','record'];

    public function transform(Chance $chance)
    {
        return [
                'id' => $chance->id,
                'client_id' => $chance->client_id,
                'product_id' => $chance->product_id,
                'address_book_id' => $chance->address_book_id,
                'selects_tab_id' => $chance->selects_tab_id,
        ];
    }

    public function includeClients(Chance $chance)
    {
        return $this->item($chance->clients, new ClientsTransformer());
    }

    public function includeProduct(Chance $chance)
    {
        return $this->item($chance->product, new ProductTransformer());
    }

    public function includeAddressBook(Chance $chance)
    {
        return $this->item($chance->addressBook, new AddressBookTransformer());
    }

    public function includeSelectsTab(Chance $chance)
    {
        return $this->item($chance->selectsTab, new SelectTabTransformer());
    }

    public function includeFollow(Chance $chance)
    {
        return $this->collection($chance->follow,new FollowTransformer());
    }

    public function includeRecord(Chance $chance)
    {
        return $this->collection($chance->record,new RecordTransformer());
    }
}