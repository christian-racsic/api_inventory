<?php

use Carbon\Carbon;

if (! function_exists('format_eur')) {
        function format_eur($number): string
    {
        if ($number === null || $number === '') return '';

        try {
            if (class_exists(\NumberFormatter::class)) {
                $fmt = new \NumberFormatter('es_ES', \NumberFormatter::CURRENCY);
                return $fmt->formatCurrency((float) $number, 'EUR');
            }
        } catch (\Throwable $e) {
        }
        return number_format((float) $number, 2, ',', '.') . ' €';
    }
}

if (! function_exists('format_datetime_es')) {
        function format_datetime_es($date): string
    {
        if (!$date) return '';

        try {
            $c = $date instanceof Carbon ? $date : Carbon::parse($date);
            return $c->format('d/m/Y H:i');
        } catch (\Throwable $e) {
            return (string) $date;
        }
    }
}
