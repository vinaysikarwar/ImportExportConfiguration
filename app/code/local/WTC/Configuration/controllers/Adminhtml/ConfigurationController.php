<?php

class WTC_Configuration_Adminhtml_ConfigurationController extends Mage_Adminhtml_Controller_Action
{
		protected function _initAction()
		{
				$this->loadLayout()->_setActiveMenu("configuration/configuration")->_addBreadcrumb(Mage::helper("adminhtml")->__("Configuration  Manager"),Mage::helper("adminhtml")->__("Configuration Manager"));
				return $this;
		}
		public function indexAction() 
		{
			    $this->_title($this->__("Configuration"));
			    $this->_title($this->__("Manager Configuration"));

				$this->_initAction();
				$this->renderLayout();
		}
		public function editAction()
		{			    
			    $this->_title($this->__("Configuration"));
				$this->_title($this->__("Configuration"));
			    $this->_title($this->__("Edit Item"));
				
				$id = $this->getRequest()->getParam("id");
				$model = Mage::getModel("configuration/configuration")->load($id);
				if ($model->getId()) {
					Mage::register("configuration_data", $model);
					$this->loadLayout();
					$this->_setActiveMenu("configuration/configuration");
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Configuration Manager"), Mage::helper("adminhtml")->__("Configuration Manager"));
					$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Configuration Description"), Mage::helper("adminhtml")->__("Configuration Description"));
					$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
					$this->_addContent($this->getLayout()->createBlock("configuration/adminhtml_configuration_edit"))->_addLeft($this->getLayout()->createBlock("configuration/adminhtml_configuration_edit_tabs"));
					$this->renderLayout();
				} 
				else {
					Mage::getSingleton("adminhtml/session")->addError(Mage::helper("configuration")->__("Item does not exist."));
					$this->_redirect("*/*/");
				}
		}

		public function newAction()
		{

		$this->_title($this->__("Configuration"));
		$this->_title($this->__("Configuration"));
		$this->_title($this->__("New Item"));

        $id   = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("configuration/configuration")->load($id);

		$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
		if (!empty($data)) {
			$model->setData($data);
		}

		Mage::register("configuration_data", $model);

		$this->loadLayout();
		$this->_setActiveMenu("configuration/configuration");

		$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Configuration Manager"), Mage::helper("adminhtml")->__("Configuration Manager"));
		$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Configuration Description"), Mage::helper("adminhtml")->__("Configuration Description"));


		$this->_addContent($this->getLayout()->createBlock("configuration/adminhtml_configuration_edit"))->_addLeft($this->getLayout()->createBlock("configuration/adminhtml_configuration_edit_tabs"));

		$this->renderLayout();

		}
		public function saveAction()
		{

			$post_data=$this->getRequest()->getPost();


				if ($post_data) {

					try {

						

						$model = Mage::getModel("configuration/configuration")
						->addData($post_data)
						->setId($this->getRequest()->getParam("id"))
						->save();

						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Configuration was successfully saved"));
						Mage::getSingleton("adminhtml/session")->setConfigurationData(false);

						if ($this->getRequest()->getParam("back")) {
							$this->_redirect("*/*/edit", array("id" => $model->getId()));
							return;
						}
						$this->_redirect("*/*/");
						return;
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						Mage::getSingleton("adminhtml/session")->setConfigurationData($this->getRequest()->getPost());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					return;
					}

				}
				$this->_redirect("*/*/");
		}



		public function deleteAction()
		{
				if( $this->getRequest()->getParam("id") > 0 ) {
					try {
						$model = Mage::getModel("configuration/configuration");
						$model->setId($this->getRequest()->getParam("id"))->delete();
						Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
						$this->_redirect("*/*/");
					} 
					catch (Exception $e) {
						Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
						$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
					}
				}
				$this->_redirect("*/*/");
		}

		
		public function massRemoveAction()
		{
			try {
				$ids = $this->getRequest()->getPost('config_ids', array());
				foreach ($ids as $id) {
                      $model = Mage::getModel("configuration/configuration");
					  $model->setId($id)->delete();
				}
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
			}
			catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			}
			$this->_redirect('*/*/');
		}
			
		/**
		 * Export order grid to CSV format
		 */
		public function exportCsvAction()
		{
			$fileName   = 'configuration.csv';
			$grid       = $this->getLayout()->createBlock('configuration/adminhtml_configuration_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
		} 
		/**
		 *  Export order grid to Excel XML format
		 */
		public function exportExcelAction()
		{
			$fileName   = 'configuration.xml';
			$grid       = $this->getLayout()->createBlock('configuration/adminhtml_configuration_grid');
			$this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
		}
		
		/**
		 * Export order grid to CSV format
		 */
		public function importAction()
		{
			$this->_title($this->__("Import Configuration"));
			$this->_title($this->__("Import Configuration"));

			$this->_initAction();
			$this->renderLayout();
		}
		
		public function importConfigurationAction(){
			if($this->getRequest()->isPost()){
				$storeFolder = getcwd().'/var/import'; 
				if (!file_exists($storeFolder)) {
					mkdir($storeFolder, 0777, true);
				}
				if (!empty($_FILES)) {
					$tempFile = $_FILES['file']['tmp_name'];
					$targetPath = $storeFolder . DS;  
					$targetFile =  $targetPath. $_FILES['file']['name']; 
					if(!move_uploaded_file($tempFile,$targetFile)){
						echo "Some Error Occured in Uploading File";
					}
					
					if($_FILES['file']['type'] == 'application/csv' || $_FILES['file']['type'] == 'text/csv'){
						if(file_exists($targetFile)){
							chmod($targetFile, 777); 
							Mage::getModel('configuration/configuration')->importConfiguration($targetFile);
						}
						else{
							echo "File Not Imported Successfully";
						}
					}
					else{
						echo "File is not in CSV Format";
					}
				}
				else{
					echo "Some Error Occured in Uploading File";
				}
			}
		}
}
