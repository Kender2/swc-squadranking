<?php
namespace App;

use App\Exceptions\ResponseException;
use GuzzleHttp\Client;
use Log;

class ClientRequest
{
    private $client;

    /**
     * ClientRequest constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('sod.game_url'),
        ]);
    }

    public function makeRequest(GameRequest $body)
    {
        $jsonBody = \GuzzleHttp\json_encode($body);
        Log::debug('Making request: ' . $body->getActions());

        $response = $this->client->request('POST', '/j/batch/json', [
            'headers' => $this->defaultHeaders(),
            'body' => 'batch=' . urlencode($jsonBody),
        ]);
        $responseBody = $response->getBody();
        $responseObject = new GameResponse($responseBody);
        if (!$responseObject) {
            throw new ResponseException($response);
        }
        Log::debug('Received response: ' . $responseObject->getStatus());

        return $responseObject;
    }

    private function defaultHeaders()
    {
        return [
            'DModel' => 'samsung SM-T110',
            'DType' => 'Handheld',
            'DOS' => 'Android OS 4.2.2 / API-17 (JDQ39/T110UEUANE4)',
            'DMemory' => '816 MB',
            'DProcessors' => '2',
            'DProcessorType' => 'ARMv7 VFPv3 NEON',
            'DGName' => 'GC1000 core',
            'DGVendor' => 'Vivante Corporation',
            'DGVersion' => 'OpenGL ES 2.0',
            'DGMemory' => '208 MB',
            'DGShaderLevel' => '30',
            'CAppVersion' => '4.1.0.8149',
            'X-Unity-Version' => '5.1.4p1',
            'User-Agent' => 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; SM-T110 Build/JDQ39)',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept-Encoding' => 'gzip',
            'Connection' => 'Keep-Alive',
        ];
    }
}
