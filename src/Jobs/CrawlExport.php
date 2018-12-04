<?php

namespace Marcz\Swiftype\Jobs;

use AbstractQueuedJob;
use Marcz\Swiftype\SwiftypeCrawlClient;
use QueuedJob;
use SiteConfig;
use Marcz\Swiftype\SwiftypeClient;
use Exception;
use DataList;
use Director;


class CrawlExport extends AbstractQueuedJob implements QueuedJob
{
    protected $client;

    /**
     * @param string $className
     * @param int $recordID
     */
    public function __construct($indexName = null, $className = null, $recordID = 0)
    {
        $this->indexName = $indexName;
        $this->className = $className;
        $this->recordID  = (int) $recordID;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Crawl document export: "' . $this->className . '" with ID ' . $this->recordID;
    }

    /**
     * @return string
     */
    public function getJobType()
    {
        return QueuedJob::QUEUED;
    }

    public function process()
    {

        if (!$this->indexName) {
            throw new Exception('Missing indexName defined on the constructor');
        }

        if (!$this->className) {
            throw new Exception('Missing className defined on the constructor');
        }
        if (!$this->recordID) {
            throw new Exception('Missing recordID defined on the constructor');
        }

        $list   = new DataList($this->className);
        $record = $list->byID($this->recordID);


        if (!$record) {
            throw new Exception('Record not found.');
        }


        $siteConfig = SiteConfig::current_site_config();
        //echo \Director::absoluteBaseURL();


        $engineKey = $siteConfig->EngineKey;
        $domainID = $siteConfig->DomainID;
        $engineSlug = $siteConfig->EngineSlug;
        $apiKey = SS_SWIFTYPE_AUTH_TOKEN;

        $baseUrl = rtrim(\Director::absoluteBaseURL(),'/');
        $Link = \DataObject::get_by_id("SiteTree", $this->recordID)->Link();

        $pageUrl = $baseUrl . $Link;

        $crawlClient = new SwiftypeCrawlClient($engineSlug, $domainID, $engineKey, $apiKey);
        $crawlResults = $crawlClient->crawlURL($pageUrl);

        print_r($crawlResults);
        die();
        $this->addMessage('Todo: Implement crawling feature.');
        $this->isComplete = true;
    }

    /**
     * Called when the job is determined to be 'complete'
     * Clean-up object properties
     */
    public function afterComplete()
    {
        $this->indexName = null;
        $this->className = null;
        $this->recordID  = 0;
    }

    public function createClient($client = null)
    {
        if (!$client) {
            $this->client = SwiftypeClient::create();
        }

        $this->client->initIndex($this->indexName);

        return $this->client;
    }
}
