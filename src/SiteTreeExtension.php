<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 26/11/18
 * Time: 10:51 AM
 */

namespace Marcz\Swiftype;

use DataExtension;


class SiteTreeExtension extends DataExtension{

    public function MetaTags(&$tags)
    {
        $abLink =  $this->owner->AbsoluteLink();
        $segments = explode("/", $abLink);
        $segment = $segments[3];
        $meta = "";
        switch ($segment){
            case "business":
                $meta = "business";
                break;
            case "agribusiness":
                $meta = "agribusiness";
                break;
            case "wib":
                $meta = "institutional";
                break;
            case "who-we-are":
                $meta = "who-we-are";
                break;
            case "ask-westpac":
                $meta = "ask-westpac";
                break;
            default:
                $meta = "personal";
        }
        $tags .= "<meta class=\"swiftype\" name=\"type\" data-type=\"enum\" content=\"$meta\" />\n";
    }
}
