<?php
/**
 * Created by PhpStorm.
 * User: christian
 * Date: 14/03/17
 * Time: 11:54
 */


namespace Insightly;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\json_decode;
use Insightly\Models\Contact;

class Insightly {

    const BASE_URL = "https://api.insight.ly/";
    const DEFAULT_VERSION = "v2.2";

    private $httpClient;
    private $apiKey;
    private $version;


    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
        $this->httpClient = new HttpClient([
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($apiKey)
            ]
        ]);

        $this->version = self::DEFAULT_VERSION;
    }

    public function getApiKey() {
        return $this->apiKey;
    }

    public function getContacts() {
        $contacts = array();

        $resource = self::BASE_URL . $this->version . Contact::ROUTE;
        $response = $this->httpClient->get($resource);
        if ($response->getStatusCode() === 200) {
            $contactArrays = json_decode($response->getBody(), true);
            foreach ($contactArrays as $contactArray) {
                $contact = new Contact($contactArray);
                $contacts[] = $contact;
            }
        }

        return $contacts;
    }

}