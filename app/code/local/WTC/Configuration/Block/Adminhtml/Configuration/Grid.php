<?php

class WTC_Configuration_Block_Adminhtml_Configuration_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

		public function __construct()
		{
				parent::__construct();
				$this->setId("configurationGrid");
				$this->setDefaultSort("config_id");
				$this->setDefaultDir("DESC");
				$this->setSaveParametersInSession(true);
		}

		protected function _prepareCollection()
		{
				$collection = Mage::getModel("configuration/configuration")->getCollection();
				$this->setCollection($collection);
				return parent::_prepareCollection();
		}
		protected function _prepareColumns()
		{
				$this->addColumn("config_id", array(
				"header" => Mage::helper("configuration")->__("ID"),
				"align" =>"right",
				"width" => "50px",
			    "type" => "number",
				"index" => "config_id",
				));
                
				$this->addColumn("scope", array(
				"header" => Mage::helper("configuration")->__("Scope"),
				"index" => "scope",
				));
				$this->addColumn("scope_id", array(
				"header" => Mage::helper("configuration")->__("Scope Id"),
				"index" => "scope_id",
				));
				$this->addColumn("path", array(
				"header" => Mage::helper("configuration")->__("Path"),
				"index" => "path",
				));
				$this->addColumn("value", array(
				"header" => Mage::helper("configuration")->__("Value"),
				"index" => "value",
				));
			$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV')); 
			$this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

				return parent::_prepareColumns();
		}

		public function getRowUrl($row)
		{
			   return $this->getUrl("*/*/edit", array("id" => $row->getId()));
		}


		
		protected function _prepareMassaction()
		{
			$this->setMassactionIdField('config_id');
			$this->getMassactionBlock()->setFormFieldName('config_ids');
			$this->getMassactionBlock()->setUseSelectAll(true);
			$this->getMassactionBlock()->addItem('remove_configuration', array(
					 'label'=> Mage::helper('configuration')->__('Remove Configuration'),
					 'url'  => $this->getUrl('*/adminhtml_configuration/massRemove'),
					 'confirm' => Mage::helper('configuration')->__('Are you sure?')
				));
			return $this;
		}
			

}