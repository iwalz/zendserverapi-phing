<?php
require_once 'phing/Task.php';
require_once __DIR__.'/../../vendor/composer/autoload_classmap.php';
require_once __DIR__.'/../../vendor/autoload.php';

class ApplicationDeploy extends ZSApiTask
{
    private $appPackage = null;
    private $baseUrl = null;
    private $createVhost = null;
    private $defaultServer = null;
    private $ignoreFailures = null;
    private $userAppName = null;
    private $parameters = array();
    private $deployment = null;
    
    public function setUserAppName($userAppName)
    {
        $this->userAppName = $userAppName;
    }
    
    public function setAppPackage($appPackage) 
    {
        $this->appPackage = $appPackage;
    }
    
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }
    
    public function setCreateVhost($createVhost)
    {
        if(1 == $createVhost) {
            $this->createVhost = true;
        } else {
            $this->createVhost = false;
        }
    }
    
    public function setDefaultServer($defaultServer)
    {
        if(1 == $defaultServer) {
            $this->defaultServer = true;
        } else {
            $this->defaultServer = false;
        }
    }
    
    public function setIgnoreFailures($ignoreFailures)
    {
        if(1 == $ignoreFailures) {
            $this->ignoreFailures = true;
        } else {
            $this->ignoreFailures = false;
        }
    }
    
    public function addParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;
    }
    
    public function init () 
    {
        $this->ignoreFailures = false;
        $this->defaultServer = false;
        $this->createVhost = false;
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
            $deploy = $this->deployment->applicationDeploy(
                $this->appPackage, 
                $this->baseUrl, 
                $this->createVhost, 
                $this->defaultServer, 
                $this->userAppName,
                $this->ignoreFailures,
                $userParams);
        } catch(Exception $e) {
            echo "Deploy failed: " . $e->getMessage() . PHP_EOL;
            return -1;
        }
        
        $this->setProperties($deploy);
    }
}

?>