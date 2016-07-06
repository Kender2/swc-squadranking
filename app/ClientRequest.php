<?php
namespace App;

use GuzzleHttp\Client;

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

    public function makeRequest(RequestBody $body)
    {
        $response = $this->client->request('POST', '/j/batch/json', [
            'headers' => $this->defaultHeaders(),
            'body' => 'batch=' . urlencode(\GuzzleHttp\json_encode($body)),
        ]);
        $responseBody = $response->getBody();
        $responseJson = json_decode($responseBody);
        $data = $responseJson->data;

        return $data;
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
            'CAppVersion' => '4.0.0.7738',
            'X-Unity-Version' => '5.1.4p1',
            'User-Agent' => 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; SM-T110 Build/JDQ39)',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept-Encoding' => 'gzip',
            'Connection' => 'Keep-Alive',
        ];
    }
}
