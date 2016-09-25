<?php
namespace App;

use DB;
use Schema;

class JsonToDatabaseConverter
{

    public function convert($json, $connection)
    {
        $db = Schema::connection($connection);
        $file = json_decode($json, true);
        foreach ($file['spreadsheetInfo']['pages'] as $page) {
            $name = $page['pageName'];
            $rows = $file['content']['objects'][$name];

            $columnInfo = [];
            foreach ($page['columns'] as $column) {
                $columnInfo[$column] = [
                    'length' => 0,
                    'numeric' => true,
                ];
            }
            // Find out about columns and fix up multi-value fields.
            foreach ($rows as $key => $row) {
                foreach ($row as $column => $value) {
                    if (is_array($value)) {
                        $value = implode('&', $value);
                        $rows[$key][$column] = $value;
                    }
                    if (strlen($value) > $columnInfo[$column]['length']) {
                        $columnInfo[$column]['length'] = strlen($value);
                    }
                    $columnInfo[$column]['numeric'] &= is_numeric($value);
                }
            }

            // Create table.
            $db->dropIfExists($name);
            $db->create($name, function ($table) use ($columnInfo) {
                foreach ($columnInfo as $columnName => $info) {
                    if ($info['numeric']) {
                        $table->integer($columnName)->nullable();
                    } else {
                        $table->string($columnName, $info['length'])->nullable();
                    }
                }
            });

            // Insert data.
            foreach ($rows as $row) {
                DB::connection($connection)->table($name)->insert($row);
            }
        }

    }

}
