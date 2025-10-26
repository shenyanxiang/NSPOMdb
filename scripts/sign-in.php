<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

require 'db-connect.php';

session_start();
if (isset($_POST['email']) && isset($_POST['password'])){
    $email = test_input($_POST['email']);
    $password = test_input($_POST['password']);
    $query = "SELECT * FROM public.user_info WHERE email = $1 AND password = $2";
    $result = pg_query_params($conn, $query, array($email, $password));
    $row = pg_fetch_row($result);
    if ($row){
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $row[7];
        echo 'success';
    }else{
        exit('fail');
    }
}
pg_close($conn);

?>