<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector;
use Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector;
use Rector\CodingStyle\Rector\Use_\SeparateMultiUseImportsRector;
use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodParameterRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\Php55\Rector\String_\StringClassNameToClassConstantRector;
use Rector\Php70\Rector\FuncCall\RandomFunctionRector;
use Rector\Php74\Rector\Assign\NullCoalescingOperatorRector;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Php81\Rector\ClassMethod\NewInInitializerRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\Php81\Rector\Property\ReadOnlyPropertyRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\Privatization\Rector\MethodCall\PrivatizeLocalGetterToPropertyRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnNeverTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->parallel();
    $rectorConfig->cacheClass(FileCacheStorage::class);
    $rectorConfig->cacheDirectory(__DIR__ . '/var/rector');
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

//    $rectorConfig->rules([
//        # CodingStyle
//        MakeInheritedMethodVisibilitySameAsParentRector::class,
//        NewlineBeforeNewAssignSetRector::class,
//        NullableCompareToNullRector::class,
//        SeparateMultiUseImportsRector::class,
//        StaticArrowFunctionRector::class,
//        StaticClosureRector::class,
//        TernaryConditionVariableAssignmentRector::class,
//        # CodeQuality
//        SwitchNegatedTernaryRector::class,
//        # DeadCode
//        RemoveUnusedConstructorParamRector::class,
//        RemoveUnusedPrivateMethodParameterRector::class,
//        RemoveUselessParamTagRector::class,
//        RemoveUselessReturnTagRector::class,
//        RemoveUselessVarTagRector::class,
//    ]);

    $rectorConfig->sets([
        SetList::CODING_STYLE,
        SetList::CODE_QUALITY,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        LevelSetList::UP_TO_PHP_83,
    ]);

    $rectorConfig->skip([
        # CodeQuality
        RemoveFinalFromConstRector::class,
        CombineIfRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        InlineConstructorDefaultToPropertyRector::class => [
            __DIR__ . '/src/Domain',
        ],
        IssetOnPropertyObjectToPropertyExistsRector::class,
        SimplifyBoolIdenticalTrueRector::class,
        # TypeDeclaration
        ReturnNeverTypeRector::class,
        # UpToPhp
        ClassPropertyAssignToConstructorPromotionRector::class,
        NewInInitializerRector::class => [
            __DIR__ . '/src/Domain',
        ],
        NullCoalescingOperatorRector::class,
        NullToStrictStringFuncCallArgRector::class,
        RandomFunctionRector::class,
        ReadOnlyPropertyRector::class,
        RestoreDefaultNullToNullableTypePropertyRector::class => [
            __DIR__ . '/src/Domain',
        ],
        StringableForToStringRector::class,
        AddOverrideAttributeToOverriddenMethodsRector::class,
        # Strict
        DisallowedEmptyRuleFixerRector::class,
        StringClassNameToClassConstantRector::class => [
            __DIR__ . '/src/Port/Console/Fixtures/GenerateApplicationsConsole.php',
        ],
        PrivatizeLocalGetterToPropertyRector::class => [
            __DIR__ . '/src/Infrastructure/Security/Voters/PermissionAccess/BasePermissionAccessVoter.php',
        ]
    ]);
};
