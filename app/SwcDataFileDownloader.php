<?php
namespace App;

use File;
use GuzzleHttp\ClientInterface;

class SwcDataFileDownloader
{
    /**
     * SwcDataFileDownloader constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Check if a version of the manifest is available.
     *
     * @param string $version
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function isDownloadAvailable($version)
    {
        if ($version === null) {
            return true;
        }
        try {
            $url = 'manifest/starts/prod/' . $version . '.json';
            $this->client->request('HEAD', $url);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Download a manifest.
     *
     * @param string $version
     * @return Manifest
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \RuntimeException
     */
    public function downloadManifest($version)
    {
        $url = 'manifest/starts/prod/' . $version . '.json';
        $response = $this->client->request('GET', $url);
        $jsonText = $response->getBody()->getContents();

        $path = storage_path('app/manifests');
        $manifest = Manifest::fromJsonString($jsonText);
        $filename = $version . '.json';
        File::put($path . DIRECTORY_SEPARATOR . $filename, $jsonText);
        return $manifest;
    }

    /**
     * Downloads a data file.
     *
     * @param string $path
     * @param string $hash
     * @return string Path to downloaded file.
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function downloadFile($path, $hash)
    {
        $url = 'starts/prod/' . $path . '/' . $hash . '.' . basename($path);
        $filePath = storage_path('app/data') . DIRECTORY_SEPARATOR . $path;
        File::makeDirectory(dirname($filePath), null, true, true);
        return $this->client->request('GET', $url, ['sink' => $filePath]);
    }

}
