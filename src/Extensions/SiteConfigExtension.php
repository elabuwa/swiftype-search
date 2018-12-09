<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 26/11/18
 * Time: 2:53 PM
 */

namespace Marcz\Swiftype\Extensions;

use DataExtension;
use FieldList;
use TextField;

class SiteConfigExtension extends DataExtension
{

    private static $plural_name = "Swiftype Settings";

    private static $db = array(
        'DefaultMeta' => 'Varchar',
        'PageTypeEnabled' => 'Varchar',
        'EngineKey' => 'Varchar',
        'DomainID' => 'Varchar',
        'EngineSlug' => 'Varchar',
        'PageCategoryMetaName' => 'Varchar'
    );

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab('Root.Swiftype', array(
            TextField::create('EngineKey','Engine Key'),
            TextField::create('DomainID','Domain ID'),
            TextField::create('EngineSlug','Engine Slug'),
            TextField::create('DefaultMeta','Default Meta Type Content'),
            TextField::create('PageCategoryMetaName','Page Category Meta Name'),
            \CheckboxField::create('PageTypeEnabled','Enable Page Type Meta'),
        ));
    }

}