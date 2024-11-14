
<?php

session_start();

$login = $_SESSION['login'] ?? '';


include_once "./connect.php";
include_once "./helpers.php";

$sql = new connect();

$query = "SELECT login from usuarios WHERE login = '{$login}' ";

$loginDb = $sql->select($query);

if ($login !== $loginDb['login']) {

    Helpers::alertaErro("Usuario não existe!", "./index.php");
}

?>
