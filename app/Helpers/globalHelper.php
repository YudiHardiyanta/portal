<?php
if (!function_exists('csv_to_array')) {
    function csv_to_array($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return [];
        }

        $header = null;
        $data   = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            // baca line pertama untuk deteksi delimiter
            $firstLine = fgets($handle);
            rewind($handle);

            $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                if (count(array_filter($row)) === 0) {
                    continue;
                }

                if ($header === null) {
                    $row[0] = preg_replace('/^\xEF\xBB\xBF/', '', $row[0]);
                    $header = array_map('trim', $row);
                    continue;
                }

                if (count($row) < count($header)) {
                    $row = array_pad($row, count($header), null);
                } elseif (count($row) > count($header)) {
                    $row = array_slice($row, 0, count($header));
                }

                $row = array_map('trim', $row);
                $data[] = array_combine($header, $row);
            }

            fclose($handle);
        }

        return $data;
    }
}
