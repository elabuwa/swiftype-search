<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 26/11/18
 * Time: 2:53 PM
 */

namespace Marcz\Swiftype;

use DataExtension;
use FieldList;
use TextField;

class SiteConfigExtension extends DataExtension
{

    private static $plural_name = "Swiftype Settings";

    private static $db = array(
        'DefaultMeta' => 'Varchar',
        'PageTypeEnabled' => 'Varchar'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Swiftype', array(
            TextField::create('DefaultMeta','Default Meta Type Content'),
            \CheckboxField::create('PageTypeEnabled','Enable Page Type Meta'),
        ));
    }
}