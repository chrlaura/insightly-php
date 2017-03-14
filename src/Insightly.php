<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 14/03/17
 * Time: 11:54
 */


namespace Insightly;

use GuzzleHttp\Client as HttpClient;

class Insightly {

    private $httpClient;
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
        $this->httpClient = new HttpClient();
    }

    public function getApiKey() {
        return $this->apiKey;
    }

}