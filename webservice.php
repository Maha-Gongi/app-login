<?php

function UserLogin($email, $password)
{
  global $conn;
  global $rows;
  $query = "SELECT S_EMAIL, S_PASSWORD FROM tbl_user where `S_EMAIL`='" . $email . "'and `S_PASSWORD`='" . $password . "'";
  //$result = mysqli_query($conn, $query);
  $rows = mysqli_fetch_row(mysqli_query($conn, $query));
  $json = json_encode($rows, JSON_PRETTY_PRINT);

  if ($rows) {

    echo 'login successfully :<br>' . PHP_EOL;
    print($json);
  } else {

    echo 'invalid login :<br>' . PHP_EOL;
    print($json);
  }
}

function UserAdd($email, $password,  $date_naiss)
{
  global $conn;

  $date_ajout = date('y-m-d');
  $query = "SELECT S_EMAIL FROM tbl_user where `S_EMAIL`='" . $email . "'";
  //$result = mysqli_query($conn, $query);
  $rows = mysqli_fetch_row(mysqli_query($conn, $query));
  if (!$rows) {


    $sql = "INSERT INTO tbl_user (S_EMAIL,S_PASSWORD,D_DATE_ADD,B_ACTIF, D_DATE_NAISSANCE)
VALUES ('$email', '$password', '$date_ajout','FALSE', '$date_naiss')";

    if (mysqli_query($conn, $sql)) {
      echo "New record created successfully !";
    } else {
      echo "Error: " . $sql . "
" . mysqli_error($conn);
    }
  } else {
    echo ("email already exist");
  }
}
function UserPasswordReset($email)
{
  global $conn;
  ini_set('SMTP', 'smtp.gmail.com');
  ini_set('smtp_port', 25);
  $query = "SELECT S_EMAIL, S_PASSWORD FROM tbl_user where `S_EMAIL`='" . $email  . "'";

  $to = $_POST['email'];
  $subject = 'REINITISALISER MOT DE PASSE';

  $rows = mysqli_fetch_row(mysqli_query($conn, $query));
  if ($rows) {

    $message = '$rows[1]';
  }
  mail($to, $subject, $message);
}
// Connexion à la base de données MySQL 

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'login');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if ($conn === false) {
  die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/html; charset=utf-8');
ini_set("display_errors", 1);


if (isset($_POST['fct1'])) {
  $email = $_POST['username'];
  $password = $_POST['password'];
  UserLogin($email, $password);
  mysqli_close($conn);
}

if (isset($_POST['fct2'])) {
  $email = $_POST['username'];
  $password = $_POST['password'];
  $date_naiss = $_POST['date_naissance'];
  UserAdd($email, $password, $date_naiss);
  mysqli_close($conn);
}

if (isset($_POST['fct3'])) {
  $email = $_POST['email'];
  UserPasswordReset($email);
  mysqli_close($conn);
}

/*if ($_REQUEST['fct1'] == "UserLogin") {
  // tester si la correspondance email / pass est bonne + renvoyer un json avec le résultat 
  
  }
  if ($_REQUEST['fct2'] == "UserAdd") {
    // Ajouter l'utilisateur a la db, controle des champs + sécurité des requetes
  }

  if ($_REQUEST['fct'] == "UserPasswordReset") {
  }
}*/
