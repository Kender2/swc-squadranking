<?php
namespace App;

use App\Exceptions\ResponseException;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Log;

class ClientRequest
{
    private $client;
    const LOG_MAX_LENGTH = 500;

    /**
     * ClientRequest constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('sod.game_url'),
            'timeout' => 30,
        ]);
    }

    public function makeRequest(GameRequest $body)
    {
        $jsonBody = \GuzzleHttp\json_encode($body);
        Log::info('Making request: ' . $body->getActions());
        Log::debug('RAW req: ' . $jsonBody);

        $response = $this->client->request('POST', '/j/batch/json', [
            'headers' => $this->defaultHeaders(),
            'body' => 'batch=' . urlencode($jsonBody),
        ]);
        $responseBody = $response->getBody();
        $responseObject = new GameResponse($responseBody);
        if (!$responseObject) {
            throw new ResponseException($response);
        }
        Log::info('Received response: ' . $responseObject->getStatus());
        Log::debug('RAW res: ' . Str::limit($responseBody, self::LOG_MAX_LENGTH));

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
            'CAppVersion' => '4.6.2.9183',
            'X-Unity-Version' => '5.1.4p1',
            'User-Agent' => 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; SM-T110 Build/JDQ39)',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept-Encoding' => 'gzip',
            'Connection' => 'Keep-Alive',
        ];
    }
}
