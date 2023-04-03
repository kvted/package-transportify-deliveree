<?php

namespace MsysCorp\TransportifyDeliveree;

use MsysCorp\TransportifyDeliveree\TransportifyDeliveree;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(TransportifyDeliveree::class, function ($app) {
            $config = $app['config']['msyscorp_transportify_deliveree'];
            return new Client($config);
        });
    }
}
