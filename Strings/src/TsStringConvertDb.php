<?php
declare(strict_types=1);

namespace TallAndSassy\Strings;

use Illuminate\Support\Facades\DB;

class TsStringConvertDb {
    public static function array2sqlCsv($arr, $delimiter = "'"): string {
        $arrSqlReady = [];
        foreach ($arr as $item) {
            $arrSqlReady[] = static::pure2sql($item);
        }
        if (count($arr) == 0) {
            $csv = '';
        } else {
            $csv = $delimiter . implode("{$delimiter},{$delimiter}", $arrSqlReady) . $delimiter;
        }
        return $csv;

    }

    public static function pure2sql($pure, $maxLength = false) : string
    {
        #global $wpdb;
        #$strSql = mysqli_real_escape_string( $wpdb->dbh, $pure );
        $strSql = DB::connection()->getPdo()->quote($pure); //https://stackoverflow.com/a/20969571/93933
        return $strSql;
    }
}
