<?php
require_once 'phing/Task.php';
require_once 'vendor/composer/autoload_classmap.php';
require_once 'vendor/autoload.php';

class ApplicationUpdate extends ZSApiTask
{
    private $appId = null;
    private $appPackage = null;
    private $ignoreFailures = null;
    private $deployment = null;
    
    public function setAppId($appId) {
        $this->appId = $appId;
    }
    
    public function setIgnoreFailures($ignoreFailures)
    {
        if(1 == $ignoreFailures) {
            $this->ignoreFailures = true;
        } else {
            $this->ignoreFailures = false;
        }
    }
    
    public function setAppPackage($appPackage)
    {
        $this->appPackage = $appPackage;
    }
    
    public function addParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;
    }
    
    public function init()
    {
        $this->ignoreFailures = false;
    }
    
    public function main() 
    {
        $this->deployment = new \ZendServerAPI\Deployment($this->name);
        $userParams = array();
        foreach($this->parameters as $parameter)
        {
            $userParams[$parameter->getName()] = $parameter->getValue();
        }
        try {
            /** @var $this->deployment \ZendServerAPI\Deployment */
            $update = $this->deployment->applicationUpdate(
                    $this->appId, 
                    $this->appPackage, 
                    $this->ignoreFailures, 
                    $userParams);
        } catch(Exception $e) {
            echo "Remove failed: " . $e->getMessage() . PHP_EOL;
            return -1;
        }
        
        $this->setProperties($update);
    }
}

?>