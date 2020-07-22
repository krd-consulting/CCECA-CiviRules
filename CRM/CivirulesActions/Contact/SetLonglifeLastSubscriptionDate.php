
<?php
class CRM_CivirulesActions_Contact_SetLonglifeLastSubscriptionDate extends CRM_CivirulesActions_Generic_Api{
	protected function getApiEntity() {
    		return 'Contact';
  	}

	protected function getApiAction() {
    		return 'Create';
  	}

	protected function alterApiParameters($params, CRM_Civirules_TriggerData_TriggerData $triggerData) {
		$date = $triggerData->getEntityData('Contact')['custom_31'];
		$amount = $triggerData->getEntityData('Contact')['custom_32'];
		$contactID = $triggerData->getContactId();

		//set params
		$params['id'] = $contactID;
		$params['custom_16'] = $date;
	        $params['custom_15'] = $amount;

		return $params; 
	}

	public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
		if($triggerData->getEntityData('Contact')['custom_32'] > 0) {
			parent::processAction($triggerData);
		}
	}

	public function getExtraDataInputUrl($ruleActionId) {
    		return FALSE;
  	}
}
?>
