<?php

namespace Webcode\PhpBBBridge;

use Illuminate\Support\ServiceProvider;

class PhpBBBridgeServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('webcode/phpbbbridge');
        $this->app['config']['database.connections'] = array_merge(
                $this->app['config']['database.connections']
                , \Config::get('phpbbbridge::database.connections')
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

}
