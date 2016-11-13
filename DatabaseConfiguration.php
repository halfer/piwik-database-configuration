<?php

/**
 * A Piwik plugin to set database credentials based on environment variables
 */

namespace Piwik\Plugins\DatabaseConfiguration;

class DatabaseConfiguration extends \Piwik\Plugin
{
	public function registerEvents()
	{
		return [
			'Db.getDatabaseConfig' => 'getDatabaseConfig'
		];
	}

	public function getDatabaseConfig(&$dbConfig)
	{
		$dbConfig['host'] = getenv('PIWIK_DATABASE_HOST');
		$dbConfig['dbname'] = getenv('PIWIK_DATABASE_NAME');
		$dbConfig['username'] = getenv('PIWIK_DATABASE_USER');
		$dbConfig['password'] = getenv('PIWIK_DATABASE_PASSWORD');
	}
}
