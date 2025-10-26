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
    $confirmPassword = test_input($_POST['confirmPassword']);
    if ($password != $confirmPassword){
        exit('Password and confirm password do not match!');
    }
    $name = test_input($_POST['name']);
    $phone = test_input($_POST['phone']);
    $affiliation = test_input($_POST['affiliation']);
    $role = 'user';
    $query = "SELECT * FROM public.user_info WHERE email = $1";
    $result = pg_query_params($conn, $query, array($email));
    $row = pg_fetch_row($result);
    if ($row){
        exit('Email already exists!');
    }
    $query = "INSERT INTO public.user_info (email, password, name, phone_number, affiliation, role) VALUES ($1, $2, $3, $4, $5, $6)";
    $result = pg_query_params($conn, $query, array($email, $password, $name, $phone, $affiliation, $role));
    if ($result){
        echo 'success';
    }else{
        exit('Sign up failed!');
    }
}
pg_close($conn);

?>