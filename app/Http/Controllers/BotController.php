<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class BotController extends Controller
{
    //
    function getReply(Request $request)
    {
//        
        $result= OpenAI::completions()->create([
            'max_tokens'=>100,
            'model'=>'text-davinci-003',
            'prompt'=>$request->message
        ]);

        $response = array_reduce(
            $result->toArray()['choices'],
            fn(string $result,array $choice)=>$result.$choice['text'],""
        );
        return $response;

    }

}
