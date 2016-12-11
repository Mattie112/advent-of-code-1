<?php

require_once("../common.php");

getAssignment(__DIR__, 4);
$data = file_get_contents("day4.txt");

$lines = explode("\n", trim($data));
$sector_sum = 0;
$hidden_sector = 0;

foreach ($lines as $line) {
    if (preg_match("/^(.*)-([0-9]+)\\[(.*)\\]$/", $line, $match)) {
        list(, $name, $sector, $checksum) = $match;

        $chars = [];
        $count = [];

        $data = count_chars(str_replace("-", "", $name), 1);
        $keys = array_keys($data);
        array_multisort(array_values($data), SORT_DESC, array_keys($data), SORT_ASC, $data, $keys);
        $data = array_combine($keys, $data);

        $check = join("", array_map("chr", array_slice(array_keys($data), 0, 5)));

        $decrypted_name = "";
        if ($checksum == $check) {
            $sector_sum += $sector;
            for($x = 0; $x < strlen($name); $x++) {
                $decrypted_name .= $name[$x] != "-" ? chr(((ord($name[$x]) - 97 + $sector) % 26) + 97) : "-";
            }
            if($decrypted_name == "northpole-object-storage") {
                $hidden_sector = $sector;
            }
        }

//        echo join(", ", [$name, $decrypted_name, $sector, $checksum, $check]) . PHP_EOL;
    }
}

echo $sector_sum . PHP_EOL;
echo $hidden_sector .PHP_EOL;