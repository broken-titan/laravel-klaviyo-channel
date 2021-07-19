<?php

    namespace BrokenTitan\Klaviyo\Providers;

    use Illuminate\Contracts\Support\DeferrableProvider;
    use Illuminate\Support\ServiceProvider as ServiceProvider;
    use Klaviyo\Klaviyo;

    class KlaviyoServiceProvider extends ServiceProvider implements DeferrableProvider {
        /**
         * Bootstrap any application services.
         *
         * @return void
         */
        public function boot() {
            $this->publishes([
                __DIR__ . "/../../config/klaviyo.php" => config_path("klaviyo.php")
            ], "config");
        }

        /**
         * Register any application services.
         *
         * @return void
         */
        public function register() {
            $this->app->singleton(Klaviyo::class, function($app) {
                return new Klaviyo(config("klaviyo.key"), config("klaviyo.public_key"));
            });
        }

        /**
         * Get the services provided by the provider.
         *
         * @return array
         */
        public function provides() {
            return [Klaviyo::class];
        }
    }
