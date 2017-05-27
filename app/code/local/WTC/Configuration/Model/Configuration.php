<?php

class WTC_Configuration_Model_Configuration extends Mage_Core_Model_Abstract
{
    protected function _construct(){

       $this->_init("configuration/configuration");

    }
	
	
	public function importConfiguration($csv){
		
		$pincodeArray = $this->csv_to_array($csv);
		$arr = array_intersect_key($pincodeArray, array_unique(array_map('serialize', $pincodeArray)));
		$records = (array_chunk($arr, 10000));
		$resource  = Mage::getSingleton('core/resource');
		$connection   = $resource->getConnection('core_write');
		$table = $resource->getTableName('wtc_pincode_validator');
		$count = 0;
		$excludePaths = array('web/secure/base_url','web/unsecure/base_url');
		foreach($records as $rows){
			foreach($rows as $row){
				$coreConfig = new Mage_Core_Model_Config();
				if(!in_array($row['Path'],$excludePaths)){
					$path = $row['Path'];
					$value = $row['Value'];
					$scope = $row['Scope'];
					$scopeId = $row['Scope Id'];
					try{
						$config = $coreConfig->saveConfig($path, $value, $scope, $scopeId);
						$count++;
					}
					catch(exception $ex){
						print_r($ex);
					}
				}
			}
		}
		if($count > 0){
			echo "Configuration Successfully updated";
		}		
	}
	
	public function csv_to_array($filename='', $delimiter=',')
	{
		if(!file_exists($filename) || !is_readable($filename))
			return FALSE;
		
		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}

}
	 