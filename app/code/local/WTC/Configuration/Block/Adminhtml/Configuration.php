<?php


class WTC_Configuration_Block_Adminhtml_Configuration extends Mage_Adminhtml_Block_Widget_Grid_Container{

	public function __construct()
	{

	$this->_controller = "adminhtml_configuration";
	$this->_blockGroup = "configuration";
	$this->_headerText = Mage::helper("configuration")->__("Configuration Manager");
	$this->_addButtonLabel = Mage::helper("configuration")->__("Add New Item");
	parent::__construct();
	
	}

}