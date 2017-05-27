<?php
class WTC_Configuration_Block_Adminhtml_Configuration_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("configuration_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("configuration")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("configuration")->__("Item Information"),
				"title" => Mage::helper("configuration")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("configuration/adminhtml_configuration_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
