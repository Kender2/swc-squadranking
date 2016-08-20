<?php
namespace App;

use File;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;

class SwcDataFileDownloader
{
    /**
     * SwcDataFileDownloader constructor.
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function isDownloadAvailable($version)
    {
        if ($version === null) {
            return true;
        }
        try {
            $url = 'manifest/starts/prod/' . $version . '.json';
            $this->client->request('HEAD', $url);
        } catch (ClientException $e) {
            return false;
        }
        return true;
    }

    public function downloadManifest($version)
    {
        $url = 'manifest/starts/prod/' . $version . '.json';
        $response = $this->client->request('GET', $url);
        $jsonText = $response->getBody()->getContents();

        $path = storage_path('app/manifests');
        File::makeDirectory($path . DIRECTORY_SEPARATOR . $version, null, true, true);
        $manifest = Manifest::fromJsonString($jsonText);
        $filename = $version . '.json';
        File::put($path . DIRECTORY_SEPARATOR . $filename, $jsonText);
        return $manifest;
    }

    public function downloadFile($path, $hash, $version)
    {
        $url = 'starts/prod/' . $path . '/' . $hash . '.' . basename($path);
        $filePath = storage_path('app/manifests') . DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR . $path;
        File::makeDirectory(dirname($filePath), null, true, true);
        return $this->client->request('GET', $url, ['sink' => $filePath]);
    }

}
