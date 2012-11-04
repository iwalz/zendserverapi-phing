<?php
require_once 'phing/Task.php';
require_once getcwd().'/vendor/composer/autoload_classmap.php';
require_once getcwd().'/vendor/autoload.php';

abstract class ZSApiTask extends Task
{
    protected $name = null;
    protected $returnProperty = null;
    
    public function setReturnProperty($returnProperty) {
        $this->returnProperty = $returnProperty;
    }
    
    public function getReturnProperty() {
        return $this->returnProperty;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function init() 
    {

    }
    
    public function setProperties($dataType) {
        $values = $dataType->getArray();
        foreach($values as $key => $value) {
            $this->project->setProperty($this->returnProperty.'.'.$key, $value);
        }
    }
    
    private function getArrayForDataType($dataType) {
        $rootKey = get_class($dataType);
        $rootArray = $dataType->getArray();
    }
}
?>