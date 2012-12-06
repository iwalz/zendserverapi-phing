<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * <http://www.rubber-duckling.net>
 */
require_once 'phing/Task.php';
require_once 'vendor/composer/autoload_classmap.php';
require_once 'vendor/autoload.php';

/**
 * ApplicationUpdate phing task.
 *
 * @license     MIT
 * @link        http://github.com/iwalz/zendserverapi-phing
 * @author      Ingo Walz <ingo.walz@googlemail.com>
 */
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
        $this->deployment = new \ZendService\ZendServerAPI\Deployment($this->server);
        $userParams = array();
        foreach($this->parameters as $parameter)
        {
            $userParams[$parameter->getName()] = $parameter->getValue();
        }
        try {
            /** @var $this->deployment \ZendService\ZendServerAPI\Deployment */
            $update = $this->deployment->applicationUpdate(
                    $this->appId, 
                    $this->appPackage, 
                    $this->ignoreFailures, 
                    $userParams);
        } catch(Exception $e) {
            throw new  \BuildException($e);
        }
        
        $this->buildProperties($update);
    }
}

?>