<?php
namespace App\Traits;

use App\Models\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Log;

trait Guzzle
{
    public function process($path)
    {
        $client = New Client();

        try{
            $response =  $client->post($path);
            Response::create([
                'response' => $response->getBody()->getContents()
            ]);
        }catch (ClientException $e) {
            $responseBody = $e->getResponse()->getBody(true);
            Log::info($responseBody);
        }

        return;
    }
}
