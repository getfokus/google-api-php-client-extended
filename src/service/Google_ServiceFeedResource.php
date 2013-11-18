<?php

class Google_ServiceFeedResource {

	private $service;
	private $client;

	public function __construct(Google_Service $service, Google_Client $client) {
		$this->service = $service;
		$this->client = $client;
	}

	public function sendFeedRequest($methodPath, array $params = array()) {
		$url = Google_REST::createRequestUri($this->service->servicePath, $methodPath, $params);

		$httpRequest = new Google_HttpRequest($url, 'GET', null, null);

		$response = $this->client->getIo()->authenticatedRequest($httpRequest);

		return $response;
	}

	public function parseResponse($response) {
		try {
			$body = $response->getResponseBody();

			$array = Google_XmlParserUtil::XmlToArray($body);

			return $array;
		} catch (Exception $e) {
			return array();
		}
	}

}
