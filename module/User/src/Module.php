<?php 
namespace User;

class Module
{

	public function getConfig():array 
	{
		return include __DIR__.'/../config/module.config.php';
	}
}