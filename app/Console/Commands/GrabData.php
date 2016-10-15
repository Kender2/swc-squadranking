<?php

namespace App\Console\Commands;

use App\Manifest;
use App\SwcDataFileDownloader;
use GitWrapper\GitWorkingCopy;
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
     * @param SwcDataFileDownloader $downloader
     * @param GitWorkingCopy $git
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \GitWrapper\GitException
     * @throws \RuntimeException
     */
    public function handle(SwcDataFileDownloader $downloader, GitWorkingCopy $git)
    {
        $currentVersion = Manifest::latestVersion();
        $limit = $currentVersion + 10;
        for ($newVersion = $currentVersion + 1; $newVersion < $limit; $newVersion++) {
            if ($downloader->isDownloadAvailable($newVersion)) {
                $newManifest = $downloader->downloadManifest($newVersion);
                $changes = $newManifest->compareTo(Manifest::fromFile($currentVersion));
                foreach ($changes as $path => $hash) {
                    $this->info('Downloading version ' . $newVersion . ' of ' . $path);
                    $downloader->downloadFile($path, $hash);
                    $git->add($path);
                }
                $newManifest->save();
                if ($git->hasChanges()) {
                    $git->commit((string)$newVersion);
                }
                $currentVersion = $newVersion;
            } else {
                $this->info('Version ' . $newVersion . ' is not available.');
            }
        }
        // We always run this so that if a previous push failed it will be retried.
        if ($git->isTracking() && $git->isAhead()) {
            $git->push();
        }
    }
}
