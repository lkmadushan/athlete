<?php namespace Athletes\Filters;

use Illuminate\Config\Repository as Config;
use Symfony\Component\Security\Core\Util\StringUtils;

class VerifyApiKey {

	protected $apiKey;

	public function __construct(Config $config)
	{
		$this->apiKey = $config->get('app.key');
	}

	public function filter($request)
	{
		if( ! $this->apiKeysMatch($request))
		{
			throw new ApiKeyMismatchException('Valid api key is required!');
		}
	}

	public function apiKeysMatch($request)
	{
		$apiKey = $request->get('api_key') ?: $request->header('X-API-Key');

		return StringUtils::equals($this->apiKey, $apiKey);
	}
}