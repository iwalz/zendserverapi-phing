# Zend Server API - phing integration
=====================================

<b>For usage instructions, see the [Wiki section](https://github.com/iwalz/zendserverapi-phing/wiki)</b>

## Installation via composer 
To install the Zend Server API phing integration, your <code>composer.json</code> file should look like this:
<pre>
{
  "repositories": [
		{
			"type": "composer",
			"url": "http://packages.zendframework.com/"
		}
	],
    "require": {
        "zendserverapi/zendserverapi-phing": "dev-master"
    },
    "minimum-stability": "dev"
}
</pre>

Run <code>composer.phar install</code> from your project root and you should be ready to go.

<b>Please note:</b>You don't really need the repositories section in your <code>composer.json</code> - the side effect will be, that you've the whole zf2 framework installed via composer. The library still works as expected, but there will be an overhead during installation.

## Configure your servers
You can find the configuration file, starting from your project root, at <code>vendor/zendserverapi/zendserverapi/config/config.php</code>.

A valid configfile may look like this:
```php
<?php

return array(
  "servers" => array (
    # Contains a valid default config
    "general" => array(
      "version" => \ZendServerAPI\Version::ZS56,
      "apiName" => "api",
      "fullApiKey" => "bee698dde6a95de71932d65cb655c31fc4ea04c1fabaf6f0a1b852617eac32ab",
      "readApiKey" => "",
      "host" => "10.0.1.100",
      "port" => "10081"
    )
  ),
  "settings" => array (
    'loglevel' => \Zend\Log\Logger::DEBUG        
  )
);
```

<b>Please note:</b> you can manage multiple servers within this configfile:
```php
<?php

return array(
  "servers" => array (
    # Contains a valid default config
    "general" => array(
      "version" => \ZendServerAPI\Version::ZS56,
      "apiName" => "api",
      "fullApiKey" => "bee698dde6a95de71932d65cb655c31fc4ea04c1fabaf6f0a1b852617eac32ab",
      "readApiKey" => "",
      "host" => "10.0.1.100",
      "port" => "10081"
    ),
    "production" => array(
      "version" => \ZendServerAPI\Version::ZSCM56,
      "apiName" => "admin",
      "fullApiKey" => "f49c7cd904b631ed1de43727a7c9ccca7324688482b19140a778d9b5020ca369",
      "readApiKey" => "",
      "host" => "10.20.30.1",
      "port" => "10081"
    ),
    "stage" => array(
      "version" => \ZendServerAPI\Version::ZSCM56,
      "apiName" => "stageenvironment",
      "fullApiKey" => "71ce992da55734b0ad408264e721ca8cabfef4dba158ebeca3653eb290a49c00",
      "readApiKey" => "",
      "host" => "10.30.10.100",
      "port" => "10081"
    )
  ),
  "settings" => array (
    'loglevel' => \Zend\Log\Logger::DEBUG        
  )
);
```
The attribute <code>server</code> is available on every provided phing task from the zendserverapi. If you keep it empty the general section will be used.

## Make phing tasks available
It's quite easy to make the phing tasks available - just 1 line of code in your build file (below the project section):
```xml
<import file="vendor/zendserverapi/zendserverapi-phing/definition.xml"/>
```
And you can start using the provided tasks. 
