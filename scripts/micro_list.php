<?php
header('Content-type: application/json; charset=utf8');

$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());

$recall_stats = [];
$recall_query = "
    SELECT
        micro,
        SUM(CASE WHEN source = 'European Commission' THEN 1 ELSE 0 END) AS european_commission_count,
        SUM(CASE WHEN source = 'FDA' THEN 1 ELSE 0 END) AS fda_count,
        SUM(CASE WHEN source = 'MHRA' THEN 1 ELSE 0 END) AS mhra_count,
        SUM(CASE WHEN source = 'TGA' THEN 1 ELSE 0 END) AS tga_count
    FROM
        public.recall_event
    GROUP BY micro
";
$recall_result = pg_query($conn, $recall_query);
while ($stat = pg_fetch_assoc($recall_result)) {
    $recall_stats[$stat['micro']] = [
        'european_commission_count' => intval($stat['european_commission_count']),
        'fda_count' => intval($stat['fda_count']),
        'mhra_count' => intval($stat['mhra_count']),
        'tga_count' => intval($stat['tga_count'])
    ];
}

$micro_query = "SELECT * FROM public.micro_list";
$micro_result = pg_query($conn, $micro_query);

// 属的ID
$genus_ids = [1, 4, 7, 11, 21, 28, 29];
// 用于保存属和种
$genus = [];    // 属
$species = [];  // 属id => 种数组
$others = [];   // 其他微生物

while ($row = pg_fetch_assoc($micro_result)) {
    $micro_name = $row['micro_name'];
    $micro_name_array = explode(" ", $micro_name);
    $micro_name_array_length = count($micro_name_array);
    if ($micro_name_array[$micro_name_array_length-1] == 'complex' || $micro_name_array[$micro_name_array_length-1] == 'spp.') {
        $micro_name_key = $micro_name_array[0];
    } else {
        $micro_name_key = $micro_name;
    }

    $ec_count = 0;
    $fda_count = 0;
    $mhra_count = 0;
    $tga_count = 0;
    foreach ($recall_stats as $key => $counts) {
        if (stripos($key, $micro_name_key) !== false) {
            $ec_count += $counts['european_commission_count'];
            $fda_count += $counts['fda_count'];
            $mhra_count += $counts['mhra_count'];
            $tga_count += $counts['tga_count'];
        }
    }

    $row["european_commission_count"] = $ec_count;
    $row["fda_count"] = $fda_count;
    $row["mhra_count"] = $mhra_count;
    $row["tga_count"] = $tga_count;
    $row["total_count"] = $ec_count + $fda_count + $mhra_count + $tga_count;
    
    if (in_array($row['micro_id'], $genus_ids)) {
        $genus[$row['micro_id']] = $row;
        $genus[$row['micro_id']]['children'] = [];
    } else {
        $found = false;
        // 先处理两位属
        foreach ($genus_ids as $gid) {
            $gid_str = strval($gid);
            if (strlen($gid_str) == 2) {
                if (preg_match('/^' . $gid_str . '\d{3}$/', $row['micro_id'])) {
                    $species[$gid][] = $row;
                    $found = true;
                    break;
                }
            }
        }
        // 再处理一位属
        if (!$found) {
            foreach ($genus_ids as $gid) {
                $gid_str = strval($gid);
                if (strlen($gid_str) == 1) {
                    if (preg_match('/^' . $gid_str . '0\d{3}$/', $row['micro_id'])) {
                        $species[$gid][] = $row;
                        $found = true;
                        break;
                    }
                }
            }
        }
        if (!$found) {
            $others[] = $row;
        }
    }
}
// 把每个属的种加到 children 字段
foreach ($genus_ids as $gid) {
    if (isset($genus[$gid]) && isset($species[$gid])) {
        $genus[$gid]['children'] = $species[$gid];
    }
}

// 合并最终结果
$data = array_values($genus);
$data = array_merge($data, $others);

echo json_encode($data);
?>