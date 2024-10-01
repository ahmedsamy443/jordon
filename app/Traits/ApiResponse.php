<?php

namespace App\Traits;

trait ApiResponse
{
    


    protected function sendexternalResponse($message,$data,$statusCode = 200)
    {
       
        $response['message'] = $message;
        
        if ($data != null)
        {
            $response['data'] = $data;
        }
        else
        {
            $response['data'] = [];
        }
            
            $response['statusCode'] = $statusCode;
        return  response()->json($response,$statusCode);
    }

}
