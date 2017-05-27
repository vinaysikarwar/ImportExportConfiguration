<?php
class WTC_Configuration_Model_Mysql4_Configuration extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("configuration/configuration", "config_id");
    }
}