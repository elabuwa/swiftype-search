<?php
/**
 * Created by PhpStorm.
 * User: dileepratnayake
 * Date: 26/11/18
 * Time: 2:17 PM
 */

class PageTypeMetas extends DataObject
{
    private static $plural_name = "Page Type Metas";

    private static $db = array(
        'segmentNumber' => 'Int',
        'key' => 'Varchar',
        'value' => 'Varchar'
    );

    private static $summary_fields = array(
        'segmentNumber' => 'Segment Number',
        'key' => 'Key',
        'value' => 'Meta Content'
    );

    

}