<?php

namespace Marcz\Swiftype\Extensions;

use Extension;
use Requirements;

class SwiftypeAdminExtension extends Extension
{
    public function init()
    {
        Requirements::javascript('marczhermo/swiftype-search: client/dist/js/bundle.js');
        Requirements::css('marczhermo/swiftype-search: client/dist/styles/bundle.css');
    }
}
