<?php
class CRM_CivirulesConditions_Contact_DeathBenefitIssueDateChanged extends CRM_CivirulesConditions_Generic_FieldChanged{
        protected function getEntity() {
                return 'contact';
        }

        protected function getField() {
                return 'custom_29';
        }

        public function getExtraDataInputUrl($ruleConditionId) {
                return false;
        }

	public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData) {
                // get balances modified and status
                $result = civicrm_api3('Contact', 'get', array(
                        'sequential' => 1,
                        'return' => array("custom_36", "custom_19"),
                        'id' => $triggerData->getContactId(),
                ));

                $balanceModified = $result['values'][0]['custom_36'];
                $status = $result['values'][0]['custom_19'];

                if($balanceModified == true || $status != 1)
                        return false;

                return parent::isConditionValid($triggerData);
        }

        public function doesWorkWithTrigger(CRM_Civirules_Trigger $trigger, CRM_Civirules_BAO_Rule $rule) {
                return true;
        }
}
?>
