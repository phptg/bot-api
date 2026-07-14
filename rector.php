<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Php82\Rector\Param\AddSensitiveParameterAttributeRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpSets(php82: true)
    ->withConfiguredRule(
        AddSensitiveParameterAttributeRector::class,
        [
            'sensitive_parameters' => ['token', 'providerToken', 'secretToken'],
        ]
    )
    ->withSkip([
        ClosureToArrowFunctionRector::class,
        NullToStrictStringFuncCallArgRector::class,
        ClassPropertyAssignToConstructorPromotionRector::class,
    ]);
