<?php
    header('Content-Type: application/json'); // Set the response content type to JSON
    $host = "localhost";
    $port = "5432";
    $dbname = "OBMicro";
    $user = "postgres";
    $password = "super@mml123";

    $criteria = $_GET['criteria']; // Get the selected criteria from the request

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conn) {
        echo json_encode(['error' => 'Connection failed: ' . pg_last_error()]);
        exit;
    }

    // Map the criteria to the corresponding column in the database
    $columnMap = [
        'TRBA 466, German' => 'trba_466_german',
        'The Approved List of biological agents 3rd Edition, UK' => 'approved_list_uk',
        'DIRECTIVE 2000/54/EC, European Union' => 'directive_2000_54_ec',
        'BMBL 6th Edition, NIH' => 'bmbl_6th_edition_nih'
    ];

    if (!isset($columnMap[$criteria])) {
        echo json_encode(['error' => 'Invalid criteria selected']);
        exit;
    }

    $column = $columnMap[$criteria];

    // Query the database based on the selected criteria
    $query = "SELECT $column as biosafety_level, COUNT(*) as count 
              FROM micro_biosafety_wide 
              GROUP BY $column";
    $result = pg_query($conn, $query);
    if (!$result) {
        echo json_encode(['error' => 'Query failed: ' . pg_last_error()]);
        pg_close($conn);
        exit;
    }

    $data = [];
    while ($row = pg_fetch_assoc($result)) {
        $biosafetyLevel = $row['biosafety_level'];
        if (empty($biosafetyLevel)) {
            $biosafetyLevel = 'Undefined'; // Replace empty values with 'undefined'
        }
        $data[] = [
            'name' => $biosafetyLevel,
            'value' => (int)$row['count']
        ];
    }

    pg_close($conn);
    echo json_encode($data); // Return the data as JSON
?>