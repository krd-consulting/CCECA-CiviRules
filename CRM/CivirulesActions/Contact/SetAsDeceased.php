<?php
class CRM_CivirulesActions_Contact_SetAsDeceased extends CRM_Civirules_Action {
	public function getExtraDataInputUrl($ruleActionId) {
                return FALSE;
        }

        public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
		$result = civicrm_api3('Contact', 'create', array(
  			'id' => $triggerData->getContactId(),
  			'is_deceased' => 1,
		));
	}
}
?>
