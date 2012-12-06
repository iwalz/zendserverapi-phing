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
 * ApplicationStatus phing task.
 *
 * @license     MIT
 * @link        http://github.com/iwalz/zendserverapi-phing
 * @author      Ingo Walz <ingo.walz@googlemail.com>
 */
class ApplicationStatus extends ZSApiTask
{
    private $baseUrl = null;
    private $userAppName = null;
    private $appName = null;
    private $deployment = null;

    public function setUserAppName($userAppName)
    {
        $this->userAppName = $userAppName;
    }

    public function setAppName($appName)
    {
        $this->appName = $appName;
    }

    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function main()
    {
        if (empty($this->returnProperty)) {
            throw new \BuildException('ApplicationStatus needs a "returnProperty" parameter');
        }

        $this->deployment = new \ZendService\ZendServerAPI\Deployment($this->server);

        try {
            /** @var $this->deployment \ZendService\ZendServerAPI\Deployment */
            $deploy = $this->deployment->applicationGetStatus();
        } catch(Exception $e) {
            throw new \BuildException($e);
        }

        $found = false;

        foreach($deploy as $app) {
            if($this->baseUrl && $this->baseUrl == $app->getBaseUrl()) {
                $found = true;
                $this->buildProperties($app);
                break;
            } elseif($this->userAppName && $this->userAppName == $app->getUserAppName()) {
                $found = true;
                $this->buildProperties($app);
                break;
            } elseif($this->appName && $this->appName == $app->getAppName()) {
                $found = true;
                $this->buildProperties($app);
                break;
            }
        }

        $this->project->setProperty($this->returnProperty, $found);
    }
}

?>