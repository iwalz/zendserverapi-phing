<?php
require_once 'phing/Task.php';
require_once getcwd().'/vendor/composer/autoload_classmap.php';
require_once getcwd().'/vendor/autoload.php';

class ApplicationRollback extends ZSApiTask
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
            $rollback = $this->deployment->applicationRollback($this->appId);
        } catch(Exception $e) {
            echo "Remove failed: " . $e->getMessage() . PHP_EOL;
            return -1;
        }
        
        $this->setProperties($rollback);
    }
}

?>