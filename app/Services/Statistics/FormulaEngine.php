<?php

namespace App\Services\Statistics;

use InvalidArgumentException;

class FormulaEngine
{
    /**
     * Supported functions.
     */
    protected array $functions = [
        'ROUND',
        'MIN',
        'MAX',
        'ABS',
        'CEIL',
        'FLOOR',
    ];

    /**
     * Evaluate a formula.
     *
     * @param string $formula
     * @param array $variables
     * @return mixed
     */
    public function evaluate(string $formula, array $variables = [])
    {
        $formula = trim($formula);

        if ($formula === '') {
            throw new InvalidArgumentException('Formula cannot be empty.');
        }

        $this->validate($formula);

        $formula = $this->replaceVariables($formula, $variables);

        $tokens = $this->tokenize($formula);

        $postfix = $this->infixToPostfix($tokens);

        return $this->evaluatePostfix($postfix);
    }

    /**
     * Validate the expression.
     */
    protected function validate(string $formula): void
    {
        /*
        |--------------------------------------------------------------------------
        | Parenthesis validation
        |--------------------------------------------------------------------------
        */

        $balance = 0;

        foreach (str_split($formula) as $char) {

            if ($char === '(') {
                $balance++;
            }

            if ($char === ')') {
                $balance--;
            }

            if ($balance < 0) {
                throw new InvalidArgumentException(
                    'Invalid parenthesis in formula.'
                );
            }

        }

        if ($balance !== 0) {
            throw new InvalidArgumentException(
                'Unbalanced parenthesis.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Allowed characters
        |--------------------------------------------------------------------------
        */

        if (! preg_match('/^[A-Za-z0-9_\+\-\*\/%\(\)\.,\s]+$/', $formula)) {

            throw new InvalidArgumentException(
                'Formula contains invalid characters.'
            );

        }
    }

    /**
     * Replace variables with values.
     */
    protected function replaceVariables(
        string $formula,
        array $variables
    ): string {

        /*
        |--------------------------------------------------------------------------
        | Longest variable names first.
        |--------------------------------------------------------------------------
        */

        uksort($variables, function ($a, $b) {
            return strlen($b) <=> strlen($a);
        });

        foreach ($variables as $name => $value) {

            if (! is_numeric($value)) {

                throw new InvalidArgumentException(
                    "Variable [$name] must be numeric."
                );

            }

            $formula = preg_replace(
                '/\b' . preg_quote($name, '/') . '\b/',
                (string) $value,
                $formula
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Detect unreplaced variables.
        |--------------------------------------------------------------------------
        */

        preg_match_all('/[A-Za-z_][A-Za-z0-9_]*/', $formula, $matches);

        foreach ($matches[0] as $identifier) {

            if (in_array(strtoupper($identifier), $this->functions)) {
                continue;
            }

            throw new InvalidArgumentException(
                "Unknown variable [$identifier]"
            );

        }

        return $formula;
    }

    /**
     * Split expression into tokens.
     *
     * Implemented in Part 2.
     */
    protected function tokenize(string $formula): array
    {
        return [];
    }

    /**
     * Convert infix to postfix.
     *
     * Implemented in Part 2.
     */
    protected function infixToPostfix(array $tokens): array
    {
        return [];
    }

    /**
     * Evaluate postfix expression.
     *
     * Implemented in Part 3.
     */
    protected function evaluatePostfix(array $postfix)
    {
        return null;
    }
}