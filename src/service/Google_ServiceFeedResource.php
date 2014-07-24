<?php

class Google_ServiceFeedResource {

	private $service;
	private $client;

	public function __construct(Google_Service $service, Google_Client $client) {
		$this->service = $service;
		$this->client = $client;
	}

	public function sendFeedRequest($methodPath, array $params = array()) {
		$url = Google_Http_REST::createRequestUri(
			$this->service->servicePath,
			$methodPath,
			$params
		);
		
		$httpRequest = new Google_Http_Request(
			$url,
			'GET',
			null,
			null
		);
		
		$httpRequest = $this->client->getAuth()->sign($httpRequest);
		
		try {
 			//$response = $this->client->execute($httpRequest);
			// leave execue() because the json deserialization is in it
			// we need pure xml, su custom requesting
			
			$response = $this->client->getIo()->makeRequest($httpRequest);
		}
		catch(\Exception $e) {
		}
		
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
