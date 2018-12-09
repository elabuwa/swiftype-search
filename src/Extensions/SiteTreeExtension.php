<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 26/11/18
 * Time: 10:51 AM
 */

namespace Marcz\Swiftype\Extensions;

use DataExtension;
use Marcz\Swiftype\Jobs\CrawlExport;
use Marcz\Swiftype\Jobs\JsonExport;
use QueuedJobService;
use SiteConfig;
use PageTypeMetas;
use Marcz\Swiftype\SwiftypeClient;

class SiteTreeExtension extends DataExtension{

    const SEARCH_INDEX = 'Page';

    public function MetaTags(&$tags)
    {
        $siteConfig = SiteConfig::current_site_config();
        $defaultMeta = $siteConfig->DefaultMeta;
        $pageCategoryMetaName = $siteConfig->PageCategoryMetaName;
        $PageTypeEnabled = (bool) $siteConfig->PageTypeEnabled;
        if($PageTypeEnabled === true){
            //Todo : combine segment number and value checking at a later stage
            $abLink =  $this->owner->AbsoluteLink();
            $segments = explode("/", $abLink);
            $segment = $segments[3];
            $meta = null;

            $result = PageTypeMetas::get()->filter(array(
                'segmentNumber' => 3,
                'key' => $segment
            ));
            if($result->exists()){
                $first = $result->first();
                $meta = $first->value;
                $tags .= "<meta class=\"swiftype\" name=\"$pageCategoryMetaName\" data-type=\"enum\" content=\"$meta\" />\n";
            } else {
                $tags .= "<meta class=\"swiftype\" name=\"$pageCategoryMetaName\" data-type=\"enum\" content=\"$defaultMeta\" />\n";
            }
        }
    }

    public function onAfterWrite()
    {
        $updatedURL = $this->owner->AbsoluteLink();
        $className = $this->owner->ClassName;
        $recordId = $this->owner->ID;

        $job = new CrawlExport(self::SEARCH_INDEX, $className, $recordId);
        singleton(QueuedJobService::class)->queueJob($job);

    }
}
