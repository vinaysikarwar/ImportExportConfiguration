<?php
	
class WTC_Configuration_Block_Adminhtml_Configuration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		public function __construct()
		{

				parent::__construct();
				$this->_objectId = "config_id";
				$this->_blockGroup = "configuration";
				$this->_controller = "adminhtml_configuration";
				$this->_updateButton("save", "label", Mage::helper("configuration")->__("Save Item"));
				$this->_updateButton("delete", "label", Mage::helper("configuration")->__("Delete Item"));

				$this->_addButton("saveandcontinue", array(
					"label"     => Mage::helper("configuration")->__("Save And Continue Edit"),
					"onclick"   => "saveAndContinueEdit()",
					"class"     => "save",
				), -100);



				$this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
		}

		public function getHeaderText()
		{
				if( Mage::registry("configuration_data") && Mage::registry("configuration_data")->getId() ){

				    return Mage::helper("configuration")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("configuration_data")->getId()));

				} 
				else{

				     return Mage::helper("configuration")->__("Add Item");

				}
		}
}