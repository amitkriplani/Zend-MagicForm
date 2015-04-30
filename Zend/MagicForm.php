<?php

class Zend_MagicForm extends Zend_Form {

    public function constructFromDbTable(Zend_DataObject_Abstract $model) {
        foreach ($model->describe() as $field) {
            if ($field['Extra'] == 'auto_increment') {
                continue;
            }
            $type = (strpos($field['Type'], '(') !== false) ? substr($field['Type'], 0, strpos($field['Type'], '(')) : $field['Type'];
            switch ($type) {
                case 'varchar':
                    $this->addElement('text', $field['Field'], array(
                        'label' => ucwords(str_replace('_', ' ', $field['Field'])),
                        'required' => (bool) $field['Null'] == 'NO',
                    ));
                    break;
                case 'text':
                    $this->addElement('textarea', $field['Field'], array(
                        'label' => ucwords(str_replace('_', ' ', $field['Field'])),
                        'required' => (bool) $field['Null'] == 'NO',
                    ));
                    break;
                default:
                    print_r($field);
                    break;
            }
        }
        $this->addElement('submit', 'save');
    }

}
