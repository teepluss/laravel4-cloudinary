<?php namespace Teepluss\Cloudinary;

use Illuminate\Support\ServiceProvider;

class CloudinaryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap classes for packages.
	 *
	 * @return void
	 */
	public function boot()
	{
		$enabled = $this->app->share(function($app)
		{
			return $app['config']->get('cloudinary::enabled', false);
		});
		
		if ($enabled) {
			$this->package('teepluss/cloudinary');
		}
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['cloudinary'] = $this->app->share(function($app)
		{
			return new CloudinaryWrapper($app['config']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('cloudinary');
	}

}
