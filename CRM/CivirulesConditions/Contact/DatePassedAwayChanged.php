<?php
class CRM_CivirulesConditions_Contact_DatePassedAwayChanged extends CRM_CivirulesConditions_Generic_FieldChanged{
        protected function getEntity() {
                return 'contact';
        }

        protected function getField() {
                return 'custom_37';
        }

        public function getExtraDataInputUrl($ruleConditionId) {
                return false;
        }
        
	public function doesWorkWithTrigger(CRM_Civirules_Trigger $trigger, CRM_Civirules_BAO_Rule $rule) {
                return true;
       	}
}
?>
