<?php
class CRM_CivirulesActions_Contact_SetLonglifeBalance extends CRM_CivirulesActions_Generic_Api{
	protected function getApiEntity() {
    		return 'Contact';
  	}

	protected function getApiAction() {
    		return 'Create';
  	}

	protected function alterApiParameters($params, CRM_Civirules_TriggerData_TriggerData $triggerData) {
		$paymentAmount = $triggerData->getEntityData('Contact')['custom_32'];
		$contactID = $triggerData->getContactId();

		//get current balance
		$result = civicrm_api3('Contact', 'get', array(
  					'sequential' => 1,
  					'return' => array("custom_18"),
  					'id' => $contactID,
					));

		$balance = $result['values'][0]['custom_18'];

		//set params
		$params['id'] = $contactID;
		$params['custom_18'] = (int)$balance + (int)$paymentAmount;

		return $params; 
	}

	public function getExtraDataInputUrl($ruleActionId) {
    		return FALSE;
  	}
}
?>
