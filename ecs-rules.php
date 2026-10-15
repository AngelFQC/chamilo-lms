<?php

/* For licensing terms, see /license.txt */

declare(strict_types=1);

// Explicit expansion of PHP-CS-Fixer's @Symfony, @PhpCsFixer and @Symfony:risky sets,
// which ECS no longer loads. Rules that ecs.php configures itself are left out.
// DeclareStrictTypesFixer is left out too: the set removes strict_types, we enforce it.

use PhpCsFixer\Fixer\Alias\ArrayPushFixer;
use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\Alias\EregToPregFixer;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoAliasLanguageConstructCallFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\Alias\PowToExponentiationFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoMultilineWhitespaceAroundDoubleArrowFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceInEmptyArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\AttributeNotation\AttributeBlockNoSpacesFixer;
use PhpCsFixer\Fixer\Basic\BracesPositionFixer;
use PhpCsFixer\Fixer\Basic\EncodingFixer;
use PhpCsFixer\Fixer\Basic\NoMultipleStatementsPerLineFixer;
use PhpCsFixer\Fixer\Basic\NoTrailingCommaInSinglelineFixer;
use PhpCsFixer\Fixer\Basic\NonPrintableCharacterFixer;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\Basic\SingleLineEmptyBodyFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\ConstantCaseFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer;
use PhpCsFixer\Fixer\Casing\LowercaseStaticReferenceFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ModernizeTypesCastingFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\CastNotation\NoUnsetCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer;
use PhpCsFixer\Fixer\ClassNotation\ModernSerializationMethodsFixer;
use PhpCsFixer\Fixer\ClassNotation\ModifierKeywordsFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\NoNullPropertyInitializationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoPhp4ConstructorFixer;
use PhpCsFixer\Fixer\ClassNotation\NoUnneededFinalMethodFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedTraitsFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedTypesFixer;
use PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfStaticAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\Comment\MultilineCommentOpeningClosingFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentStyleFixer;
use PhpCsFixer\Fixer\ConstantNotation\NativeConstantInvocationFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\ControlStructureContinuationPositionFixer;
use PhpCsFixer\Fixer\ControlStructure\ElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopBodyFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopConditionFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\NoAlternativeSyntaxFixer;
use PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoSuperfluousElseifFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededBracesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\StaticLambdaFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveIssetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\CombineConsecutiveUnsetsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DirConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ErrorSuppressionFixer;
use PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer;
use PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAroundConstructFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLinesBeforeNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Naming\NoHomoglyphNamesFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use PhpCsFixer\Fixer\Operator\LogicalOperatorsFixer;
use PhpCsFixer\Fixer\Operator\LongToShorthandOperatorFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Operator\NoSpaceAroundDoubleColonFixer;
use PhpCsFixer\Fixer\Operator\NoUselessConcatOperatorFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\OperatorLinebreakFixer;
use PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\EchoTagSyntaxFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDataProviderMethodOrderFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitInternalClassFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestClassRequiresCoversFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocTagRenameFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAnnotationWithoutDotFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocInlineTagNormalizerFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAliasTagFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoDuplicateTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoUselessInheritdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderByValueFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSummaryFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTagTypeFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarAnnotationCorrectOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\ReturnNotation\ReturnAssignmentFixer;
use PhpCsFixer\Fixer\Semicolon\MultilineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SemicolonAfterInstructionFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\HeredocToNowdocFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\StringNotation\StringImplicitBackslashesFixer;
use PhpCsFixer\Fixer\StringNotation\StringLengthToEmptyFixer;
use PhpCsFixer\Fixer\StringNotation\StringLineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBetweenImportGroupsFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer;
use PhpCsFixer\Fixer\Whitespace\LineEndingFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer;
use PhpCsFixer\Fixer\Whitespace\SpacesInsideParenthesesFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\TypeDeclarationSpacesFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;

return [
    'rules' => [
        ArrayPushFixer::class,
        BacktickToShellExecFixer::class,
        EregToPregFixer::class,
        ModernizeStrposFixer::class,
        NoAliasFunctionsFixer::class,
        NoAliasLanguageConstructCallFixer::class,
        NoMixedEchoPrintFixer::class,
        PowToExponentiationFixer::class,
        SetTypeToCastFixer::class,
        ArraySyntaxFixer::class,
        NoMultilineWhitespaceAroundDoubleArrowFixer::class,
        NoWhitespaceInEmptyArrayFixer::class,
        NormalizeIndexBraceFixer::class,
        TrimArraySpacesFixer::class,
        AttributeBlockNoSpacesFixer::class,
        EncodingFixer::class,
        NoMultipleStatementsPerLineFixer::class,
        NoTrailingCommaInSinglelineFixer::class,
        NonPrintableCharacterFixer::class,
        PsrAutoloadingFixer::class,
        SingleLineEmptyBodyFixer::class,
        ClassReferenceNameCasingFixer::class,
        ConstantCaseFixer::class,
        IntegerLiteralCaseFixer::class,
        LowercaseKeywordsFixer::class,
        LowercaseStaticReferenceFixer::class,
        MagicConstantCasingFixer::class,
        MagicMethodCasingFixer::class,
        NativeFunctionCasingFixer::class,
        NativeTypeDeclarationCasingFixer::class,
        CastSpacesFixer::class,
        LowercaseCastFixer::class,
        ModernizeTypesCastingFixer::class,
        NoShortBoolCastFixer::class,
        NoUnsetCastFixer::class,
        ShortScalarCastFixer::class,
        ModernSerializationMethodsFixer::class,
        ModifierKeywordsFixer::class,
        NoBlankLinesAfterClassOpeningFixer::class,
        NoNullPropertyInitializationFixer::class,
        NoPhp4ConstructorFixer::class,
        NoUnneededFinalMethodFixer::class,
        OrderedClassElementsFixer::class,
        OrderedTraitsFixer::class,
        ProtectedToPrivateFixer::class,
        SelfAccessorFixer::class,
        SelfStaticAccessorFixer::class,
        SingleClassElementPerStatementFixer::class,
        SingleTraitInsertPerStatementFixer::class,
        MultilineCommentOpeningClosingFixer::class,
        NoEmptyCommentFixer::class,
        NoTrailingWhitespaceInCommentFixer::class,
        SingleLineCommentSpacingFixer::class,
        SingleLineCommentStyleFixer::class,
        ControlStructureBracesFixer::class,
        ControlStructureContinuationPositionFixer::class,
        ElseifFixer::class,
        EmptyLoopBodyFixer::class,
        EmptyLoopConditionFixer::class,
        IncludeFixer::class,
        NoAlternativeSyntaxFixer::class,
        NoBreakCommentFixer::class,
        NoSuperfluousElseifFixer::class,
        NoUselessElseFixer::class,
        SwitchCaseSemicolonToColonFixer::class,
        SwitchCaseSpaceFixer::class,
        SwitchContinueToBreakFixer::class,
        CombineNestedDirnameFixer::class,
        FopenFlagOrderFixer::class,
        ImplodeCallFixer::class,
        LambdaNotUsedImportFixer::class,
        NoSpacesAfterFunctionNameFixer::class,
        NoUnreachableDefaultArgumentValueFixer::class,
        NoUselessSprintfFixer::class,
        NullableTypeDeclarationForDefaultNullValueFixer::class,
        ReturnTypeDeclarationFixer::class,
        StaticLambdaFixer::class,
        NoLeadingImportSlashFixer::class,
        NoUnneededImportAliasFixer::class,
        NoUnusedImportsFixer::class,
        SingleImportPerStatementFixer::class,
        SingleLineAfterImportsFixer::class,
        CombineConsecutiveIssetsFixer::class,
        CombineConsecutiveUnsetsFixer::class,
        DeclareEqualNormalizeFixer::class,
        DeclareParenthesesFixer::class,
        DirConstantFixer::class,
        ErrorSuppressionFixer::class,
        ExplicitIndirectVariableFixer::class,
        FunctionToConstantFixer::class,
        GetClassToClassKeywordFixer::class,
        IsNullFixer::class,
        NullableTypeDeclarationFixer::class,
        SingleSpaceAroundConstructFixer::class,
        BlankLineAfterNamespaceFixer::class,
        BlankLinesBeforeNamespaceFixer::class,
        CleanNamespaceFixer::class,
        NoLeadingNamespaceWhitespaceFixer::class,
        NoHomoglyphNamesFixer::class,
        BinaryOperatorSpacesFixer::class,
        IncrementStyleFixer::class,
        LogicalOperatorsFixer::class,
        LongToShorthandOperatorFixer::class,
        NoSpaceAroundDoubleColonFixer::class,
        NoUselessConcatOperatorFixer::class,
        NoUselessNullsafeOperatorFixer::class,
        ObjectOperatorWithoutWhitespaceFixer::class,
        OperatorLinebreakFixer::class,
        StandardizeIncrementFixer::class,
        StandardizeNotEqualsFixer::class,
        TernaryOperatorSpacesFixer::class,
        TernaryToElvisOperatorFixer::class,
        UnaryOperatorSpacesFixer::class,
        BlankLineAfterOpeningTagFixer::class,
        EchoTagSyntaxFixer::class,
        FullOpeningTagFixer::class,
        LinebreakAfterOpeningTagFixer::class,
        NoClosingTagFixer::class,
        PhpUnitConstructFixer::class,
        PhpUnitDataProviderMethodOrderFixer::class,
        PhpUnitFqcnAnnotationFixer::class,
        PhpUnitInternalClassFixer::class,
        PhpUnitMethodCasingFixer::class,
        PhpUnitMockShortWillReturnFixer::class,
        PhpUnitSetUpTearDownVisibilityFixer::class,
        PhpUnitTestAnnotationFixer::class,
        PhpUnitTestClassRequiresCoversFixer::class,
        AlignMultilineCommentFixer::class,
        NoBlankLinesAfterPhpdocFixer::class,
        NoEmptyPhpdocFixer::class,
        PhpdocAddMissingParamAnnotationFixer::class,
        PhpdocAlignFixer::class,
        PhpdocAnnotationWithoutDotFixer::class,
        PhpdocIndentFixer::class,
        PhpdocInlineTagNormalizerFixer::class,
        PhpdocNoAccessFixer::class,
        PhpdocNoDuplicateTypesFixer::class,
        PhpdocNoEmptyReturnFixer::class,
        PhpdocNoPackageFixer::class,
        PhpdocNoUselessInheritdocFixer::class,
        PhpdocOrderByValueFixer::class,
        PhpdocReturnSelfReferenceFixer::class,
        PhpdocSingleLineVarSpacingFixer::class,
        PhpdocSummaryFixer::class,
        PhpdocTrimConsecutiveBlankLineSeparationFixer::class,
        PhpdocTrimFixer::class,
        PhpdocTypesFixer::class,
        PhpdocTypesOrderFixer::class,
        PhpdocVarAnnotationCorrectOrderFixer::class,
        PhpdocVarWithoutNameFixer::class,
        NoUselessReturnFixer::class,
        ReturnAssignmentFixer::class,
        NoEmptyStatementFixer::class,
        NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
        SemicolonAfterInstructionFixer::class,
        ExplicitStringVariableFixer::class,
        HeredocToNowdocFixer::class,
        NoBinaryStringFixer::class,
        SimpleToComplexStringVariableFixer::class,
        SingleQuoteFixer::class,
        StringImplicitBackslashesFixer::class,
        StringLengthToEmptyFixer::class,
        StringLineEndingFixer::class,
        ArrayIndentationFixer::class,
        BlankLineBetweenImportGroupsFixer::class,
        CompactNullableTypeDeclarationFixer::class,
        IndentationTypeFixer::class,
        LineEndingFixer::class,
        MethodChainingIndentationFixer::class,
        NoSpacesAroundOffsetFixer::class,
        NoTrailingWhitespaceFixer::class,
        NoWhitespaceInBlankLineFixer::class,
        SingleBlankLineAtEofFixer::class,
        SpacesInsideParenthesesFixer::class,
        TypesSpacesFixer::class,
    ],
    'configured' => [
        NoWhitespaceBeforeCommaInArrayFixer::class => [
            'after_heredoc' => true,
        ],
        WhitespaceAfterCommaInArrayFixer::class => [
            'ensure_single_space' => true,
        ],
        BracesPositionFixer::class => [
            'allow_single_line_anonymous_functions' => true,
            'allow_single_line_empty_anonymous_classes' => true,
        ],
        ClassAttributesSeparationFixer::class => [
            'elements' => [
                'method' => 'one',
            ],
        ],
        ClassDefinitionFixer::class => [
            'single_line' => true,
        ],
        OrderedTypesFixer::class => [
            'null_adjustment' => 'always_last',
        ],
        NativeConstantInvocationFixer::class => [
            'strict' => false,
        ],
        NoUnneededBracesFixer::class => [
            'namespaces' => true,
        ],
        NoUnneededControlParenthesesFixer::class => [
            'statements' => [
                'break',
                'clone',
                'continue',
                'echo_print',
                'negative_instanceof',
                'others',
                'return',
                'switch_case',
                'yield',
                'yield_from',
            ],
        ],
        TrailingCommaInMultilineFixer::class => [
            'after_heredoc' => true,
            'elements' => [
                'array_destructuring',
                'arrays',
            ],
        ],
        FopenFlagsFixer::class => [
            'b_mode' => false,
        ],
        FunctionDeclarationFixer::class => [
            'closure_fn_spacing' => 'one',
        ],
        MethodArgumentSpaceFixer::class => [
            'after_heredoc' => true,
            'on_multiline' => 'ensure_fully_multiline',
        ],
        NativeFunctionInvocationFixer::class => [
            'include' => [
                '@compiler_optimized',
            ],
            'scope' => 'namespaced',
            'strict' => true,
        ],
        VoidReturnFixer::class => [
            'fix_lambda' => false,
        ],
        FullyQualifiedStrictTypesFixer::class => [
            'import_symbols' => true,
        ],
        OrderedImportsFixer::class => [
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
            'sort_algorithm' => 'alpha',
        ],
        NewWithParenthesesFixer::class => [
            'anonymous_class' => false,
        ],
        GeneralPhpdocTagRenameFixer::class => [
            'replacements' => [
                'inheritDocs' => 'inheritDoc',
            ],
        ],
        NoSuperfluousPhpdocTagsFixer::class => [
            'allow_hidden_params' => true,
            'allow_mixed' => true,
            'remove_inheritdoc' => true,
        ],
        PhpdocNoAliasTagFixer::class => [
            'replacements' => [
                'const' => 'var',
                'link' => 'see',
                'property-read' => 'property',
                'property-write' => 'property',
                'type' => 'var',
            ],
        ],
        PhpdocOrderFixer::class => [
            'order' => [
                'param',
                'return',
                'throws',
            ],
        ],
        PhpdocScalarFixer::class => [
            'types' => [
                'boolean',
                'callback',
                'double',
                'integer',
                'never-return',
                'never-returns',
                'no-return',
                'real',
                'str',
            ],
        ],
        PhpdocSeparationFixer::class => [
            'groups' => [
                [
                    'Annotation',
                    'NamedArgumentConstructor',
                    'Target',
                ],
                [
                    'author',
                    'copyright',
                    'license',
                ],
                [
                    'category',
                    'package',
                    'subpackage',
                ],
                [
                    'property',
                    'property-read',
                    'property-write',
                ],
                [
                    'deprecated',
                    'link',
                    'see',
                    'since',
                ],
            ],
            'skip_unlisted_annotations' => false,
        ],
        PhpdocTagTypeFixer::class => [
            'tags' => [
                'inheritDoc' => 'inline',
            ],
        ],
        PhpdocToCommentFixer::class => [
            'allow_before_return_statement' => false,
        ],
        MultilineWhitespaceBeforeSemicolonsFixer::class => [
            'strategy' => 'new_line_for_chained_calls',
        ],
        SpaceAfterSemicolonFixer::class => [
            'remove_in_empty_for_expressions' => true,
        ],
        BlankLineBeforeStatementFixer::class => [
            'statements' => [
                'break',
                'case',
                'continue',
                'declare',
                'default',
                'exit',
                'goto',
                'include',
                'include_once',
                'phpdoc',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
                'yield',
                'yield_from',
            ],
        ],
        NoExtraBlankLinesFixer::class => [
            'tokens' => [
                'attribute',
                'break',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
            ],
        ],
        StatementIndentationFixer::class => [
            'stick_comment_to_next_continuous_control_statement' => true,
        ],
        TypeDeclarationSpacesFixer::class => [
            'elements' => [
                'function',
                'property',
            ],
        ],
    ],
];
