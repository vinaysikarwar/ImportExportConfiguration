<?php
class WTC_Configuration_Block_Adminhtml_Configuration_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{

				$form = new Varien_Data_Form();
				$this->setForm($form);
				$fieldset = $form->addFieldset("configuration_form", array("legend"=>Mage::helper("configuration")->__("Item information")));

				
						$fieldset->addField("scope", "text", array(
						"label" => Mage::helper("configuration")->__("Scope"),
						"name" => "scope",
						));
					
						$fieldset->addField("scope_id", "text", array(
						"label" => Mage::helper("configuration")->__("Scope Id"),
						"name" => "scope_id",
						));
					
						$fieldset->addField("path", "text", array(
						"label" => Mage::helper("configuration")->__("Path"),
						"name" => "path",
						));
					
						$fieldset->addField("value", "text", array(
						"label" => Mage::helper("configuration")->__("Value"),
						"name" => "value",
						));
					

				if (Mage::getSingleton("adminhtml/session")->getConfigurationData())
				{
					$form->setValues(Mage::getSingleton("adminhtml/session")->getConfigurationData());
					Mage::getSingleton("adminhtml/session")->setConfigurationData(null);
				} 
				elseif(Mage::registry("configuration_data")) {
				    $form->setValues(Mage::registry("configuration_data")->getData());
				}
				return parent::_prepareForm();
		}
}
