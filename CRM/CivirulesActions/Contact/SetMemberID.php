<?php

class CRM_CivirulesActions_Contact_SetMemberID extends CRM_CivirulesActions_Generic_Api {

	/**
	 * Returns highest member id + 1
	 * @return int The next member id.
	 */
	private function getNextMemberID() {
		$sql = "
        SELECT MAX(member_id_1)
        FROM civicrm_value_additional_profile_information_2";

  		$id = CRM_Core_DAO::singleValueQuery($sql) + 1;
  		
  		return $id;
	}

	protected function getApiEntity() {
		return 'Contact';
	}

	protected function getApiAction() {
		return 'Create';
	}

	protected function alterApiParameters(
		$params, 
		CRM_Civirules_TriggerData_TriggerData $triggerData
	) {
		$contact = $triggerData->getContactId();

		$params['id'] = $contact;
		try {
			$params['custom_1'] = $this->getNextMemberID();
		} catch (Exception $e) {

		}

		watchdog(
		  'Custom CiviRules Action (SetMemberID)',
		  'New Member Id (custom_1) for Contact(id: @contact) is: @member_id',
		  array(
		  	'@contact' => $contact,
		  	'@member_id' => $params['custom_1']
		  ),
		  WATCHDOG_INFO
		);

		return $params;
	}

	public function getExtraDataInputUrl($ruleActionId) {
    	return FALSE;
  	}

}