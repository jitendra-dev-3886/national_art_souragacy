<?php

namespace App\Services;

use Carbon\Carbon;

class EstablishmentDateParser
{
    /*
    |--------------------------------------------------------------------------
    | Status Codes
    |--------------------------------------------------------------------------
    */

    private const STATUS_DIRECT = 1;
    private const STATUS_AMBIGUOUS_OLD = 2;
    private const STATUS_TEXT_MONTH = 3;
    private const STATUS_NUMERIC_STRING = 4;
    private const STATUS_FAILED = 5;
    private const STATUS_AMBIGUOUS_NEW = 6;
    private const STATUS_AFTER_APPLICATION = 7;

    /*
    |--------------------------------------------------------------------------
    | Parse Date
    |--------------------------------------------------------------------------
    */

    public function parse(?string $value, ?string $applicationDate): array
    {
        $value = $this->normalize($value);

        if ($this->rejectImmediately($value)) {
            return $this->failed();
        }

        foreach ([
            [$this, 'parseNumericString'],
            [$this, 'parseIsoDate'],
            [$this, 'parseNumericDate'],
            [$this, 'parseTextDate'],
        ] as $parser) {

            $result = call_user_func($parser, $value);

            if ($result !== false) {
                return $this->applyBusinessRules($result, $applicationDate);
            }
        }

        return $this->failed();
    }

    /*
    |--------------------------------------------------------------------------
    | Normalize Input
    |--------------------------------------------------------------------------
    */

    private function normalize(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        $value = trim($value);

        // Remove ordinal suffixes
        $value = preg_replace('/(\d+)(st|nd|rd|th)/i', '$1', $value);

        // Remove commas
        $value = str_replace(',', '', $value);

        // Remove spaces around separators
        $value = preg_replace('/\s*([\/\-.])\s*/', '$1', $value);

        // Collapse multiple spaces
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }

    /*
    |--------------------------------------------------------------------------
    | Reject Obviously Invalid Values
    |--------------------------------------------------------------------------
    */

    private function rejectImmediately(string $value): bool
    {
        if ($value === '') {
            return true;
        }

        $invalid = [

            'null',
            'na',
            'n/a',
            '--',
            '-',

            '00/00/0000',
            '00-00-0000',
            '00.00.0000',

            '0000/00/00',
            '0000-00-00',
            '0000.00.00',

            '00000000'

        ];

        if (in_array(strtolower($value), $invalid, true)) {
            return true;
        }

        /*
        |--------------------------------------------------------------
        | Only Year
        | Example:
        | 2018
        |--------------------------------------------------------------
        */

        if (preg_match('/^\d{4}$/', $value)) {
            return true;
        }

        /*
        |--------------------------------------------------------------
        | Month Year
        | Example:
        | July 2016
        | 2016 July
        |--------------------------------------------------------------
        */

        if (
            preg_match('/^[A-Za-z]+\s+\d{4}$/', $value) ||
            preg_match('/^\d{4}\s+[A-Za-z]+$/', $value)
        ) {
            return true;
        }

        /*
        |--------------------------------------------------------------
        | Month/Year
        | Example:
        | 03/2018
        | 2018/03
        |--------------------------------------------------------------
        */

        if (
            preg_match('/^\d{1,2}[\/\-.]\d{4}$/', $value) ||
            preg_match('/^\d{4}[\/\-.]\d{1,2}$/', $value)
        ) {
            return true;
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Success Result
    |--------------------------------------------------------------------------
    */

    private function result(int $status, Carbon $date): array
    {
        return [

            'status' => $status,

            'date' => $date->format('Y-m-d')

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Failed Result
    |--------------------------------------------------------------------------
    */

    private function failed(): array
    {
        return [

            'status' => self::STATUS_FAILED,

            'date' => null

        ];
    }
    /*
    |--------------------------------------------------------------------------
    | Apply Business Rules
    |--------------------------------------------------------------------------
    */

    private function applyBusinessRules(array $result, ?string $applicationDate): array
    {
        if (
            $result['status'] == self::STATUS_FAILED ||
            empty($result['date']) ||
            empty($applicationDate)
        ) {
            return $result;
        }

        $submissionDate = substr($applicationDate, 0, 10);

        if ($result['date'] > $submissionDate) {
            $result['status'] = self::STATUS_AFTER_APPLICATION;
        }

        return $result;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Year
    |--------------------------------------------------------------------------
    */

    private function validateYear(Carbon $date): bool
    {
        $year = (int) $date->format('Y');

        return $year >= 1970 &&
            $year <= (int) date('Y');
    }

    /*
    |--------------------------------------------------------------------------
    | Safe Carbon Parser
    |--------------------------------------------------------------------------
    */

    private function makeCarbon(string $format, string $value)
    {
        try {

            $date = Carbon::createFromFormat($format, $value)->startOfDay();

            $errors = Carbon::getLastErrors();

            if (
                $errors['warning_count'] > 0 ||
                $errors['error_count'] > 0
            ) {
                return false;
            }

            if ($date->format($format) !== $value) {
                return false;
            }

            if (!$this->validateYear($date)) {
                return false;
            }

            return $date;

        } catch (\Exception $e) {

            return false;

        }
    }

    /*
    |--------------------------------------------------------------------------
    | Parse Numeric String
    |--------------------------------------------------------------------------
    |
    | Examples:
    | 1102025  -> 01-10-2025
    | 01102025 -> 01-10-2025
    |--------------------------------------------------------------------------
    */
    

    private function parseNumericString(string $value)
    {
        if (!preg_match('/^\d{7,8}$/', $value)) {
            return false;
        }

        if (strlen($value) == 7) {
            $value = '0' . $value;
        }

        $formatted = substr($value, 0, 2) . '-'
                . substr($value, 2, 2) . '-'
                . substr($value, 4, 4);

        $date = $this->makeCarbon('d-m-Y', $formatted);

        if (!$date) {
            return false;
        }

        return $this->result(
            self::STATUS_NUMERIC_STRING,
            $date
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Parse ISO Dates
    |--------------------------------------------------------------------------
    |
    | Supported:
    | 2022-05-04
    | 2022/05/04
    | 2022.05.04
    |
    */

    private function parseIsoDate(string $value)
    {
        foreach ([
            'Y-m-d',
            'Y/m/d',
            'Y.m.d'
        ] as $format) {

            $date = $this->makeCarbon($format, $value);

            if ($date !== false) {
                return $this->result(
                    self::STATUS_DIRECT,
                    $date
                );
            }
        }

        return false;
    }
    /*
    |--------------------------------------------------------------------------
    | Parse Numeric Dates
    |--------------------------------------------------------------------------
    |
    | Status 1
    | 20/4/2016
    | 28-3-2010
    | 13/05/2016
    | 11/11/2016
    |
    | Status 2
    | 05/06/2018
    |
    | Status 6
    | 05/06/2025
    |
    */

    private function parseNumericDate(string $value)
    {
        if (!preg_match(
            '/^(\d{1,2})([\/\-.])(\d{1,2})\2(\d{2}|\d{4})$/',
            $value,
            $match
        )) {
            return false;
        }

        $left = (int) $match[1];

        $separator = $match[2];

        $right = (int) $match[3];

        $year = (int) $match[4];

        /*
        |--------------------------------------------------------------------------
        | Convert 2 digit year
        |--------------------------------------------------------------------------
        */

        if ($year < 100) {
            $year += ($year >= 70) ? 1900 : 2000;
        }

        if (
            $year < 1970 ||
            $year > (int) date('Y')
        ) {
            return false;
        }

        $dateString = sprintf(
            '%02d%s%02d%s%04d',
            $left,
            $separator,
            $right,
            $separator,
            $year
        );

        /*
        |--------------------------------------------------------------------------
        | Case 1
        | Obvious DD/MM
        |--------------------------------------------------------------------------
        */

        if ($left > 12) {

            $date = $this->makeCarbon(
                'd'.$separator.'m'.$separator.'Y',
                $dateString
            );

            return $date
                ? $this->result(self::STATUS_DIRECT, $date)
                : false;
        }

        /*
        |--------------------------------------------------------------------------
        | Case 2
        | Obvious MM/DD
        |--------------------------------------------------------------------------
        */

        if ($right > 12) {

            $date = $this->makeCarbon(
                'm'.$separator.'d'.$separator.'Y',
                $dateString
            );

            return $date
                ? $this->result(self::STATUS_DIRECT, $date)
                : false;
        }

        /*
        |--------------------------------------------------------------------------
        | Case 3
        | Day == Month
        |--------------------------------------------------------------------------
        */

        if ($left == $right) {

            $date = $this->makeCarbon(
                'd'.$separator.'m'.$separator.'Y',
                $dateString
            );

            return $date
                ? $this->result(self::STATUS_DIRECT, $date)
                : false;
        }

        /*
        |--------------------------------------------------------------------------
        | Case 4
        | Truly Ambiguous
        |--------------------------------------------------------------------------
        */

        $date = $this->makeCarbon(
            'd'.$separator.'m'.$separator.'Y',
            $dateString
        );

        if (!$date) {
            return false;
        }

        return $this->result(
            $year >= 2022
                ? self::STATUS_AMBIGUOUS_NEW
                : self::STATUS_AMBIGUOUS_OLD,
            $date
        );
    }
    /*
    |--------------------------------------------------------------------------
    | Parse Text Month Dates
    |--------------------------------------------------------------------------
    |
    | Supported
    |
    | 20 August 1985
    | 20 Aug 1985
    | August 20 1985
    | Aug 20 1985
    | 04-Jul-2022
    | 04/Jul/2022
    | 04.Jul.2022
    | Jul-04-2022
    | Jul/04/2022
    | Jul.04.2022
    |
    */

    private function parseTextDate(string $value)
    {
        /*
        |--------------------------------------------------------------------------
        | Normalize separators
        |--------------------------------------------------------------------------
        */

        $normalized = str_replace(
            ['-', '/', '.'],
            ' ',
            $value
        );

        $normalized = preg_replace('/\s+/', ' ', trim($normalized));

        foreach ($this->buildTextFormats() as $format) {

            $date = $this->makeCarbon($format, $normalized);

            if ($date !== false) {

                return $this->result(
                    self::STATUS_TEXT_MONTH,
                    $date
                );

            }

        }

        return false;
    }
    /*
    |--------------------------------------------------------------------------
    | Supported Text Formats
    |--------------------------------------------------------------------------
    */

    private function buildTextFormats(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Day Month Year
            |--------------------------------------------------------------------------
            */

            'd F Y',
            'j F Y',

            'd M Y',
            'j M Y',

            /*
            |--------------------------------------------------------------------------
            | Month Day Year
            |--------------------------------------------------------------------------
            */

            'F d Y',
            'F j Y',

            'M d Y',
            'M j Y',

        ];
    }
}