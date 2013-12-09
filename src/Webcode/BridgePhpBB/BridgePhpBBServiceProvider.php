<?php

namespace Webcode\BridgePhpBB;

use Illuminate\Support\ServiceProvider;

class BridgePhpBBServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        $this->package('webcode/phpbbbridge', 'phpbb-bridge');
        $laravelConfig = array();
        $bridgeConfig = array();
        $laravelConfig = $this->app['config']['database.connections'];
        $bridgeConfig = \Config::get('phpbb-bridge::database.connections');
        $this->app['config']['database.connections'] = array_merge(
                $laravelConfig, $bridgeConfig
        );
    }

    public function register() {
        
    }

    public function provides() {
        return array();
    }

}
