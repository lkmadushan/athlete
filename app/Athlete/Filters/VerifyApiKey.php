<?php namespace Athlete\Filters;

use Illuminate\Config\Repository as Config;
use Symfony\Component\Security\Core\Util\StringUtils;

class VerifyApiKey {

	/**
	 * API Key
	 *
	 * @var $apiKey
	 */
	protected $apiKey;

	/**
	 * Inject Configurations
	 *
	 * @param \Illuminate\Config\Repository $config
	 */
	public function __construct(Config $config)
	{
		$this->apiKey = $config->get('app.key');
	}

	/**
	 * API key filter
	 *
	 * @param $request
	 * @throws \Athlete\Filters\ApiKeyMismatchException
	 */
	public function filter($request)
	{
		if( ! $this->apiKeysMatch($request))
		{
			throw new ApiKeyMismatchException;
		}
	}

	/**
	 * Match API Keys
	 *
	 * @param $request
	 * @return bool
	 */
	public function apiKeysMatch($request)
	{
		$apiKey = $request->get('api_key') ?: $request->header('X-API-Key');

		return StringUtils::equals($this->apiKey, $apiKey);
	}
}