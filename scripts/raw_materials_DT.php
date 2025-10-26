<?php
session_start();
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

require 'db-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $step = test_input($_POST['step']);
    switch ($step) {
        case 1:
            $microbe = test_input($_POST['microSpecies']);
            $damage = test_input($_POST['damage']);
            $_SESSION['step'] = [
                'microbe' => $microbe,
            ];
            if ($microbe == 'Other' && $damage == 1) {
                $response = [
                    'continue' => false,
                    'message' => 'objectionable',
                    'microbe' => $microbe,
                ];
            } elseif ($microbe == 'Other' && $damage == 0) {
                $response = [
                    'continue' => false,
                    'message' => 'acceptable',
                    'microbe' => $microbe,
                ];
            } elseif ($microbe != 'Other' && $damage == 1) {
                $response = [
                    'continue' => false,
                    'message' => 'objectionable',
                    'microbe' => $microbe,
                ];
            } elseif ($microbe != 'Other' && $damage == 0) {
                $response = [
                    'continue' => true,
                    'message' => 'next',
                ];
            }
            break;
        case 2:
            $quantity = test_input($_POST['quantity']);
            $threshold = test_input($_POST['threshold']);
            $microbe = $_SESSION['step']['microbe'];
            // $query = "SELECT pathogenic_contamination_level FROM public.micro_list WHERE micro_name = $1";
            // $result = pg_query_params($conn, $query, array($microbe));
            // $row = pg_fetch_row($result);
            // $threshold = $row[0];
            if ($quantity > $threshold) {
                $response = [
                    'continue' => false,
                    'message' => 'objectionable',
                    'microbe' => $microbe,
                ];
            } else {
                $response = [
                    'continue' => true,
                    'message' => 'next',
                ];
            }
            break;
        case 3:
            $flag3 = test_input($_POST['flag3']);
            $microbe = $_SESSION['step']['microbe'];
            if ($flag3 == 0) {
                $response = [
                    'continue' => false,
                    'message' => 'acceptable',
                    'microbe' => $microbe,
                ];
            } else {
                $response = [
                    'continue' => true,
                    'message' => 'next',
                ];
            }
            break;
        case 4:
            $flag4 = test_input($_POST['flag4']);
            $microbe = $_SESSION['step']['microbe'];
            if ($flag4 == 0) {
                $response = [
                    'continue' => false,
                    'message' => 'objectionable',
                    'microbe' => $microbe,
                ];
            } else {
                $response = [
                    'continue' => false,
                    'message' => 'acceptable',
                    'microbe' => $microbe,
                ];
            }
    }

    echo json_encode($response);
    exit;
}
?>