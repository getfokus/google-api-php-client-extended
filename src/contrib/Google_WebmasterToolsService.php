<?php

/**
 * Service definition for Google_WebmasterTools.
 *
 * <p>
 * The Google Webmaster Tools Developer API.
 * </p>
 *
 * <p>
 * For more information about this service, see the
 * <a href="https://developers.google.com/webmaster-tools/" target="_blank">API Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 * @author Jan Kondratowicz
 * @author Piotr Pelczar
 */
class Google_WebmasterToolsService extends Google_Service {

	private $client;
	public $sites;
	public $messages;
	public $sitemaps;
	public $crawl;
	public $keywords;

	/**
	 * Constructs the internal representation of the Webmaster Tools service.
	 *
	 * @param Google_Client $client
	 */
	public function __construct(Google_Client $client) {
		$this->servicePath = 'https://www.google.com/webmasters/tools/feeds/';
		$this->version = 'v2';
		$this->serviceName = 'webmasterTools';

		$this->client = $client;

		$this->sites = new Google_WebmasterToolsSitesService($this, $client);
		$this->messages = new Google_WebmasterToolsMessagesService($this, $client);
		$this->sitemaps = new Google_WebmasterToolsSitemapsService($this, $client);
		$this->crawl = new Google_WebmasterToolsCrawlService($this, $client);
		$this->keywords = new Google_WebmasterToolsKeywordsService($this, $client);
	}

}

class Google_WebmasterToolsSitesService extends Google_ServiceFeedResource {

	public function listAll() {
		$methodPath = 'sites';

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		if (!isset($data['entry']))
			return array();

		if (isset($data['entry']['id'])) // only one item
			return array($data['entry']);

		return $data['entry'];
	}

	public function getByUrl($siteUrl) {
		$methodPath = 'sites/' . urlencode($siteUrl);

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		return $data;
	}

}

class Google_WebmasterToolsKeywordsService extends Google_ServiceFeedResource {

	public function listAll($siteUrl) {
		$methodPath = urlencode($siteUrl) . '/keywords/';

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		if (isset($data['wt:keyword']))
			return $data['wt:keyword'];

		return array();
	}

}

class Google_WebmasterToolsMessagesService extends Google_ServiceFeedResource {

	public function listAll() {
		$methodPath = 'messages';

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		if (!isset($data['entry']))
			return array();

		if (isset($data['entry']['id'])) // only one item
			return array($data);

		return $data['entry'];
	}

	public function get($messageId) {
		$methodPath = 'messages/' . urlencode($messageId);

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		return $data;
	}

}

class Google_WebmasterToolsSitemapsService extends Google_ServiceFeedResource {

	public function listAll($siteUrl) {
		$methodPath = urlencode($siteUrl) . '/sitemaps/';

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		if (!isset($data['entry']))
			return array();

		if (isset($data['entry']['id'])) // only one item
			return array($data);

		return $data['entry'];
	}

}

class Google_WebmasterToolsCrawlService extends Google_ServiceFeedResource {

	public function listAll($siteUrl) {
		$methodPath = urlencode($siteUrl) . '/crawlissues/';

		$response = $this->sendFeedRequest($methodPath);
		$data = $this->parseResponse($response);

		if (!isset($data['entry']))
			return array();

		if (isset($data['entry']['id'])) // only one item
			return array($data);

		return $data['entry'];
	}

}
