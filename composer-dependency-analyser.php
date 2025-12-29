<?php

declare(strict_types=1);

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

return (new Configuration())
    ->disableComposerAutoloadPathScan()
    ->setFileExtensions(['php'])
    ->addPathToScan(__DIR__ . '/src', isDev: false)
    ->addPathToScan(__DIR__ . '/tests', isDev: true)
    ->ignoreErrorsOnExtension('ext-curl', [ErrorType::DEV_DEPENDENCY_IN_PROD])
    ->ignoreErrorsOnPackage('psr/log', [ErrorType::DEV_DEPENDENCY_IN_PROD]);
