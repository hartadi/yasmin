<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('_date')) {
    function _date($date, $format = 'Y-m-d')
    {
        try {
            if ($date == null) return $date;
            return date($format, strtotime($date));
        } catch (\Exception $ex) {
            Log::error("Gagal format tanggal: " . $ex->getMessage());
        }
        return $date;
    }
}

if (!function_exists('__date')) {
    /**
     * Format Indonesia / Setting Regional
     */
    function __date($date, $format = 'DD MMMM YYYY')
    {
        try {
            if ($date == null) return $date;
            return \Carbon\Carbon::parse($date)->locale('id')->isoFormat($format);
        } catch (\Exception $ex) {
            Log::error("Gagal format tanggal: " . $ex->getMessage());
        }
        return $date;
    }
}

if (!function_exists('_date_diff')) {
    function _date_diff($tanggal_awal, $tanggal_akhir)
    {
        try {
            $tanggal_awal  = new DateTime($tanggal_awal);
            $tanggal_akhir = new DateTime($tanggal_akhir);
            $interval      = $tanggal_akhir->diff($tanggal_awal);
            return abs($interval->format('%a'));
        } catch (\Exception $ex) {
            Log::error("Gagal hitung _date_diff: " . $ex->getMessage());
        }
        return 0;
    }
}


if (!function_exists('format')) {
    function format($format /*, ... */): array|string|null
    {
        $args = func_get_args();

        return preg_replace_callback(
            '/\{(\\d)\}/',
            function ($m) use ($args) {
                // might want to add more error handling here...
                return $args[$m[1] + 1];
            },
            $format
        );
    }
}

if (!function_exists('number')) {
    function number($number, $decimal = 0, $zeroPlaceholder = null, $separatorDecimal = ",", $separatorRibuan = ".")
    {
        if (!is_numeric($number)) return $zeroPlaceholder;
        // $str = (string) number_format($number, $decimal, ",", ".");
        // $dec = ",";
        $str = (string)number_format($number, $decimal, $separatorDecimal, $separatorRibuan);
        $dec = $separatorDecimal;
        for ($i = 0; $i < $decimal; $i++)
            $dec .= "0";

        $str = str_replace($dec, "", $str);
        if ($str == "0" && $zeroPlaceholder !== null) $str = $zeroPlaceholder;
        return $str;
    }
}
