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
  }
}

class Google_WebmasterToolsSitesService extends Google_ServiceFeedResource {
  
  public function listAll() {
    $methodPath = 'sites';
	
    $response = $this->sendFeedRequest($methodPath);
	$data = $this->parseResponse($response);
	
	return $data;
  }
}
