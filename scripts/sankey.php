<?php
header('Content-type: application/json; charset=utf8');

$cfg = parse_ini_file("/var/www/cgi-bin/OBMicro/config.ini");

$host = 'localhost';
$db = 'OBMicro';
$user = $cfg["username"];
$pass = $cfg["password"];

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass") or die('Could not connect: ' . pg_last_error());
$query = "
  SELECT
    TRIM(micro) AS micro,
    COALESCE(NULLIF(TRIM(dosage_form), ''), 'Unknown') AS dosage_form,
    product_category
  FROM recall_event
  WHERE TRIM(micro) <> '' AND micro IS NOT NULL
";
$result = pg_query($conn, $query);

$data = [];
while ($row = pg_fetch_assoc($result)) {
    $micros = array_map('trim', explode(',', $row['micro']));
    foreach ($micros as $micro) {
        if ($micro === '') continue; 
        $data[] = [
            'micro' => $micro,
            'dosage_form' => $row['dosage_form'],
            'product_category' => $row['product_category']
        ];
    }
}
echo json_encode($data);
pg_close($conn);
?>