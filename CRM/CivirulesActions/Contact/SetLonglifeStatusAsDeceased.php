<?php
class CRM_CivirulesActions_Contact_SetLonglifeStatusAsDeceased extends CRM_CivirulesActions_Generic_Api{
        protected function getApiEntity() {
                return 'Contact';
        }

        protected function getApiAction() {
                return 'Create';
        }

        protected function alterApiParameters($params, CRM_Civirules_TriggerData_TriggerData $triggerData) {
                $params['id'] = $triggerData->getContactId();
                $params['custom_19'] = 3;

                return $params;
        }

        public function getExtraDataInputUrl($ruleActionId) {
                return FALSE;
        }
}
?>
