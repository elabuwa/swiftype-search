<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 28/11/18
 * Time: 11:55 AM
 */

namespace Marcz\Swiftype;

use GuzzleHttp\Ring\Client\CurlHandler;

class SwiftypeCrawlClient
{
    protected $apiKey;
    protected $engineSlug;
    protected $domainID;
    protected $engineKey;
    protected $handler;
    protected $headers;
    protected $endpoint;
    protected $httpMethod;
    protected $scheme;
    protected $body;
    protected $async;

    const baseEndPoint = "//api.swiftype.com/api/v1/engines/";

    //Todo : Async handling

    public function __construct($engineSlug, $domainID, $engineKey, $apiKey)
    {
        $this->engineSlug = $engineSlug;
        $this->domainID = $domainID;
        $this->engineKey = $engineKey;
        $this->apiKey = $apiKey;
        $this->handler = new CurlHandler();
        $this->headers = array();
        $this->scheme = 'https';
        $this->async = false;
        $this->body = '';
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setEndPoint($endPoint)
    {
        $this->endpoint = $endPoint;
    }


    public function crawlURL($url){
        $this->endpoint = $this::baseEndPoint . $this->engineSlug . "/domains/" . $this->domainID . "/crawl_url.json";
        $this->httpMethod = "PUT";
        $this->headers = array();
        $this->scheme = "https";
        $data['auth_token'] = $this->apiKey;
        $data['url'] = $url;
        $this->body = json_encode($data);

        $results = $this->execute();
        return $results;
    }

    private function execute(){
        $response = $this->handler([
            'http_method' => $this->httpMethod,
            'scheme'      => $this->scheme,
            'uri'         => $this->endpoint,
            'headers'     => $this->headers,
            'body'        => $this->body,
            'future'      => $this->async
        ]);

        return $response;
    }

}