<?php
class CRM_CivirulesActions_Contact_SetDatePassedAwayAsDeceasedDate extends CRM_Civirules_Action {
        public function getExtraDataInputUrl($ruleActionId) {
                return FALSE;
        }

        public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
		$result = civicrm_api3('Contact', 'get', array(
 			'sequential' => 1,
  			'return' => array("custom_37"),
  			'id' => $triggerData->getContactId(),
		));	

		$datePassedAway = $result['values'][0]['custom_37'];
			
		$result = civicrm_api3('Contact', 'create', array(
                        'id' => $triggerData->getContactId(),
                        'is_deceased' => 1,
			'deceased_date' => $datePassedAway
                ));
        }
}
?>
