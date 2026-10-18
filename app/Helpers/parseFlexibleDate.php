<?php

namespace App\Helpers;
use Carbon\Carbon;
      function parseFlexibleDate($date)
{
    $formats = [
        'm/d/Y', 'd/m/Y', 'Y-m-d', 'd-m-Y', 'Y/m/d', 'Y.m.d', 'd.m.Y', 'm-d-Y'
    ];

    foreach ($formats as $format) {
        try {
            return Carbon::createFromFormat($format, $date)->format('Y-m-d');
        } catch (\Exception $e) {
            continue;
        }
    }

    // As a fallback, try Carbon's parser (less strict, but can misinterpret ambiguous formats)
    try {
        return Carbon::parse($date)->format('Y-m-d');
    } catch (\Exception $e) {
        return null; // or throw error, or log
    }
}