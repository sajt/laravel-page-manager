<?php

namespace webmuscets\PageManager;
use Illuminate\Support\ServiceProvider;
    
    class PageManagerServiceProvider extends ServiceProvider {
        public function boot()
        {
        	$this->loadRoutesFrom(__DIR__.'/routes/web.php');
        	$this->loadViewsFrom(__DIR__.'/resources/views', 'page-manager');
            $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        }
        
        public function register()
        {
        
        }
    
    }

?>