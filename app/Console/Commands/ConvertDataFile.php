<?php

namespace App\Console\Commands;

use App\JsonToDatabaseConverter;
use App\Manifest;
use File;
use Illuminate\Console\Command;

class ConvertDataFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sod:convert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $converter;

    /**
     * Create a new command instance.
     *
     * @param JsonToDatabaseConverter $converter
     */
    public function __construct(JsonToDatabaseConverter $converter)
    {
        $this->converter = $converter;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $file = 'base';
        $currentVersion = Manifest::latestVersion();
        do {
            $path = storage_path('app/manifests')
                . DIRECTORY_SEPARATOR
                . $currentVersion--
                . DIRECTORY_SEPARATOR
                . 'patches'
                . DIRECTORY_SEPARATOR
                . $file
                . '.json';
        } while ($currentVersion > 0 && !File::exists($path));

        if (!$currentVersion) {
            echo 'Failed to find ' . $file . '.json';
        }

        $json = File::get($path);
        $this->converter->convert($json, 'swcdata');
    }
}
