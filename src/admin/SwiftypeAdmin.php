<?php

/**
 * Model Admin for Swiftype crawler engine.
**/
class SwiftypeAdmin extends ModelAdmin
{
    private static $url_segment = 'swiftype';

    private static $managed_models = array(
        'PageTypeMetas'
    );

    private static $menu_title = 'Swiftype';

}