<?php

namespace JMS\Payment\CoreBundle\Tests\Functional;

use Symfony\Component\HttpKernel\Util\Filesystem;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
	private $config;

	public function __construct($config)
	{
		parent::__construct('test', true);

		$fs = new Filesystem();
		if (!$fs->isAbsolutePath($config)) {
			$config = __DIR__.'/config/'.$config;
		}

		if (!file_exists($config)) {
			throw new \RuntimeException(sprintf('The config file "%s" does not exist.', $config));
		}

		$this->config = $config;
	}

	public function registerBundles()
	{
		return array(
		    new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
		    new \Symfony\Bundle\DoctrineBundle\DoctrineBundle(),
		    new \Symfony\Bundle\DoctrineFixturesBundle\DoctrineFixturesBundle(),
		    new \Symfony\Bundle\TwigBundle\TwigBundle(),
		    new \JMS\Payment\CoreBundle\JMSPaymentCoreBundle(),
		    new \JMS\Payment\PaypalBundle\JMSPaymentPaypalBundle(),
		);
	}

	public function registerContainerConfiguration(LoaderInterface $loader)
	{
		$loader->load($this->config);
	}

	public function getCacheDir()
	{
	    return sys_get_temp_dir().'/JMSPaymentCoreBundle';
	}
}