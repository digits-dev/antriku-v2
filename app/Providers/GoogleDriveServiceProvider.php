<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemAdapter;
use League\Flysystem\Filesystem;
use Masbug\Flysystem\GoogleDriveAdapter;
use Storage;

class GoogleDriveServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Storage::extend('google', function ($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['client_id']);
            $client->setClientSecret($config['client_secret']);
            $client->refreshToken($config['refresh_token']);

            $service = new \Google_Service_Drive($client);
            $adapter = new GoogleDriveAdapter($service, $config['folder_id'] ?? null);

            return new FilesystemAdapter(new Filesystem($adapter));
        });
    }
}
