<?php

namespace App\Console\Commands;

use App\Manifest;
use App\SwcDataFileDownloader;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GrabData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sod:grab-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab swc data';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client(['base_uri' => 'https://starts0.content.disney.io/cloud-cms/']);
        $downloader = new SwcDataFileDownloader($client);
        $currentVersion = Manifest::latestVersion();
        $limit = $currentVersion + 10;
        for ($newVersion = $currentVersion + 1; $newVersion < $limit; $newVersion++) {
            if ($downloader->isDownloadAvailable($newVersion)) {
                $newManifest = $downloader->downloadManifest($newVersion);
                $changes = $newManifest->compareTo(Manifest::fromFile($currentVersion));
                foreach ($changes as $path => $hash) {
                    $this->info('Downloading version ' . $newVersion . ' of ' . $path);
                    $downloader->downloadFile($path, $hash);
                }
                $newManifest->save();
                $currentVersion = $newVersion;
            } else {
                $this->info('Version ' . $newVersion . ' is not available.');
            }
        }
    }
}
