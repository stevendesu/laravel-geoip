<?php namespace Torann\GeoIP;

use Illuminate\Support\ServiceProvider;

class GeoIPServiceProvider extends ServiceProvider {

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
	public function boot()
	{
		$this->publishes([
			__DIR__.'/../../config/geoip.php' => config_path('geoip.php'),
		], 'config');
		
		$this->publishes([
			__DIR__.'/../../migrations/' => base_path('/database/migrations'),
		], 'migrations');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register providers.
		$this->app['geoip'] = $this->app->share(function($app)
		{
			return new GeoIP($app['config'], $app["session.store"], $app['db']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('geoip');
	}

}
