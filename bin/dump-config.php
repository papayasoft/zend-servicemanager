#!/usr/bin/env php
<?php
/**
 * @link      http://github.com/zendframework/zend-servicemanager for the canonical source repository
 * @copyright Copyright (c) 2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Zend\ServiceManager;

// Setup/verify autoloading
if (file_exists($a = __DIR__ . '/../../../autoload.php')) {
    require $a;
} elseif (file_exists($a = __DIR__ . '/../vendor/autoload.php')) {
    require $a;
} else {
    fwrite(STDERR, 'Cannot locate autoloader; please run "composer install"' . PHP_EOL);
    exit(1);
}

$configPath = isset($argv[1]) ? $argv[1] : '';
$className = isset($argv[2]) ? $argv[2] : '';

// Retrieve configuration
if (! file_exists($configPath)) {
    fwrite(STDERR, sprintf('Cannot find configuration file at path "%s"%s', $configPath, PHP_EOL));
    exit(1);
}

$appConfig = require $configPath;
if (! is_array($appConfig)) {
    fwrite(STDERR, sprintf('Configuration file at path "%s" does not return an array%s', $configPath, PHP_EOL));
    exit(1);
}

if (! class_exists($className)) {
    fwrite(STDERR, sprintf('Class "%s" does not exist%s', $className, PHP_EOL));
    exit(1);
}

Tool\CliTool::createDependencyConfig($appConfig, $className);
