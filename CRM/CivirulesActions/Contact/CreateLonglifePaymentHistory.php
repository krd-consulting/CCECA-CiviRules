<?php
class CRM_CivirulesActions_Contact_CreateLonglifePaymentHistory extends CRM_Civirules_Action {
	public function getExtraDataInputUrl($ruleActionId) {
  		return FALSE;
	}

    public function getReceiptNumber() {
        
        
        $dao =  CRM_Core_DAO::executeQuery('
            SELECT AUTO_INCREMENT
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = "civicrm-cceca"
            AND TABLE_NAME = "civicrm_value_longevity_payment_fields_6"
        ');

        $recordID;

        while($dao->fetch()) {
            $recordID = $dao->AUTO_INCREMENT;
        }


        $receiptNumber = sprintf("LP-%06d", $recordID);
       
        
        return $receiptNumber;
    }    

	public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {

		//get information on contact that's triggering the action
		$fee = 10; //10 dollars per active member as benefit


		$deadContactID = $triggerData->getEntityData('Contact')['contact_id'];
		$deadContactName = $triggerData->getEntityData('Contact')['display_name'];
		$note = $deadContactName . " passed away.";

		$triggerResult = civicrm_api3('Contact', 'get', array(
			'sequential' => 1,
			'return' => array("custom_37"),
			'id' => $deadContactID,
			));

		$deathDate = $triggerResult['values'][0]['custom_37'];


		//get all other active member records
		$result = civicrm_api3('Contact', 'get', array(
  			'sequential' => 1,
  			'return' => array("custom_18", "custom_19", "is_deceased"),
  			'custom_19' => 1, //only getting those who are active in longevity
  			'options' => array('limit' => 200),
			));

		//calculate benefit amount for deceased member
		$activeCount = $result['count'];
		$benefitAmount = ($activeCount) * $fee;

		$enterBenefit = civicrm_api3('Contact', 'create', array(
							'sequential' => 1,
							'id' => $deadContactID,
							'custom_28' => $benefitAmount,
		));
		
		//process balance for all other active records
		$contacts = $result['values'];
		foreach($contacts as $contact) {
			if (
                            ($contact['contact_id'] != $triggerData->getContactId()) //not self 
                            && ($contact['custom_19'] == 1) //longevity status is active
			    && ($contact['is_deceased'] == 0) //not marked as deceased
			   )
			{
				$charge = (-1 * $fee);
				$balance = $contact['custom_18'] + $charge;

				// Store payment history and balance.	
				$createResult = civicrm_api3('Contact', 'create', array(
  									'sequential' => 1,
  									'id' => $contact['contact_id'],
  									'custom_32' => $charge,
  									'custom_34' => $note,
									'custom_31' => $deathDate,
                                    'custom_40' =>  $this->getReceiptNumber()
				));
			}
		}
 
	}

}
?>
