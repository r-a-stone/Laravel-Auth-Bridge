<?php

namespace Webcode\BridgeBB;

use Illuminate\Support\ServiceProvider;

class BridgeBBServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot() {
        $this->package('webcode/bridgebb', 'bridgebb');
    }

    public function register() {
        $app = $this->app;
        $app['config']->set('database.connections') = array_merge(
                $app['config']->get('database.connections'), $app['config']->get('bridgebb::database.connections')
        );
       
    }

    public function provides() {
        return array();
    }

}
