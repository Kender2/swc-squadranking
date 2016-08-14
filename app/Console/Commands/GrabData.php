<?php

namespace App\Console\Commands;

use app\SwcDataFileDownloader;
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
//        $current_version =
        $downloader= new SwcDataFileDownloader();

    }
}
