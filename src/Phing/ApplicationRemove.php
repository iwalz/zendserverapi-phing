<?php
require_once 'phing/Task.php';
require_once __DIR__.'/../../vendor/composer/autoload_classmap.php';
require_once __DIR__.'/../../vendor/autoload.php';

class ApplicationRemove extends ZSApiTask
{
    private $appId = null;
    private $deployment = null;
    
    public function setAppId($appId) {
        $this->appId = $appId;
    }
    
    public function main() 
    {
        $this->deployment = new \ZendServerAPI\Deployment($this->name);
        try {
            /** @var $this->deployment \ZendServerAPI\Deployment */
            $remove = $this->deployment->applicationRemove($this->appId);
        } catch(Exception $e) {
            echo "Remove failed: " . $e->getMessage() . PHP_EOL;
            return -1;
        }
        
        $this->setProperties($remove);
    }
}

?>