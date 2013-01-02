<?php
use ZendService\ZendServerAPI\DataTypes\DataType;

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
abstract class ZSApiTask extends Task
{
    protected $server = null;
    /**
     * @var string
     */
    protected $returnProperty = null;

    /**
     * @param string $returnProperty
     */
    public function setReturnProperty($returnProperty) {
        $this->returnProperty = $returnProperty;
    }
    
    /**
     * @return string
     */
    public function getReturnProperty() {
        return $this->returnProperty;
    }
    
    public function setServer($server) {
        $this->server = $server;
    }
    
    public function getServer() {
        return $this->server;
    }
    
    /**
     * Sets all application properties to the phing environment.
     *
     * @param DataType|array $dataType
     * @param string $parent
     * @return boolean
     */
    public function buildProperties($dataType, $parent = null) {
        if($dataType instanceof DataType)
            $values = $dataType->extract();
        elseif(is_array($dataType)) 
            $values = $dataType;
        
        foreach($values as $key => $value) {

            if(is_array($value)) {
                $this->buildProperties($value, $key);
            } else {
                if(is_null($parent)) {
                    $propertyKey = $this->returnProperty.'.'.$key;
                    $this->project->setProperty($propertyKey, $value);
                } else {
                    $propertyKey = $this->returnProperty.'.'.$parent.'.'.$key;
                    $this->project->setProperty($propertyKey, $value);
                }
            }
        }
    }
    
}
?>
