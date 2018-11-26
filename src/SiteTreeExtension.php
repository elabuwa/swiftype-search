<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 26/11/18
 * Time: 10:51 AM
 */

namespace Marcz\Swiftype;

use DataExtension;
use SiteConfig;
use PageTypeMetas;

class SiteTreeExtension extends DataExtension{

    public function MetaTags(&$tags)
    {
        $siteConfig = SiteConfig::current_site_config();
        $defaultMeta = $siteConfig->DefaultMeta;
        $PageTypeEnabled = (bool) $siteConfig->PageTypeEnabled;
        if($PageTypeEnabled === true){
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
                $tags .= "<meta class=\"swiftype\" name=\"type\" data-type=\"enum\" content=\"$meta\" />\n";
            } else {
                $tags .= "<meta class=\"swiftype\" name=\"type\" data-type=\"enum\" content=\"$defaultMeta\" />\n";
            }
        }

//        switch ($segment){
//            case "business":
//                $meta = "business";
//                break;
//            case "agribusiness":
//                $meta = "agribusiness";
//                break;
//            case "wib":
//                $meta = "institutional";
//                break;
//            case "who-we-are":
//                $meta = "who-we-are";
//                break;
//            case "ask-westpac":
//                $meta = "ask-westpac";
//                break;
//            default:
//                $meta = "personal";
//        }

    }
}
