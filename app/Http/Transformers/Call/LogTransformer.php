<?php

namespace App\Http\Transformers\Call;
use App\Models\Log\Call;
use League\Fractal\TransformerAbstract;

class LogTransformer extends TransformerAbstract
{
    public function transform(Call $call)
    {
       return [
            'id' => $call->id,
            'record' => $call->record,
            'start_time' => $call->start_time->format('Y-m-d H:i:s'),
            'src' => $call->src,
            'dst' => $call->dst,
            'direct' => Call::$directMap[$call->direct],
            'answered' => $call->answered?'接通':'未接通',
            'dialing_sec' => $call->dialing_sec,
            'call_sec' => $call->call_sec,
        ];
    }

}
