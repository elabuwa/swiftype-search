<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 28/11/18
 * Time: 11:55 AM
 * This class attempts to cover all requirements for Swiftype site crawler api functions
 */

namespace Marcz\Swiftype;

use GuzzleHttp\Client;


class SwiftypeCrawlClient
{
    //Some of these are not being used since moved away from guzzle/ringphp. Need to clean up.
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

    const baseEndPoint = "https://api.swiftype.com/api/v1/engines/";


    /*
    the engine slug, domain ID, engine key, apiKey can be retrieved from the swiftype dashboard.
    These are required for the new object */

    public function __construct($engineSlug, $domainID, $engineKey, $apiKey)
    {
        $this->engineSlug = $engineSlug;
        $this->domainID = $domainID;
        $this->engineKey = $engineKey;
        $this->apiKey = $apiKey;
        $this->headers = array();
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

    public function crawlURL($url)
    {
        $this->endpoint = $this::baseEndPoint . $this->engineSlug . "/domains/" . $this->domainID . "/crawl_url.json";

        //set the body as required by swiftype
        $data['auth_token'] = $this->apiKey;
        $data['url'] = $url;
        $this->body = json_encode($data);

        $client = new Client();
        $res = $client->request(
            'PUT',
            $this->endpoint,
            [
                'headers' => [
                    'Content-Type'     => 'application/json',
                ],
                'body' => $this->body
            ]

        );
        return $res;
    }
    public function getSearchResults($query,$pageNumber = 1, $perPage = 10, $allCategories = true, $documentTypes = [])
    {
        $this->endpoint = "https://search-api.swiftype.com/api/v1/public/engines/search.json";
        $SiteConfig = \SiteConfig::current_site_config();
        $pageCategoryName = $SiteConfig->PageCategoryMetaName;

        $body['q'] = $query;
        $body['engine_key'] = $this->engineKey;
        $body['page'] = $pageNumber;
        $body['per_page'] = $perPage;

        if($allCategories === false && count($documentTypes)){
            $body['filters']['page'][$pageCategoryName] = $documentTypes;
        }

        $client =  new \GuzzleHttp\Client();
        $response = $client->request('GET', $this->endpoint, ['body' => json_encode($body), 'headers' => ['Content-Type'     => 'application/json']]);
        return $response->getBody();

    }

}