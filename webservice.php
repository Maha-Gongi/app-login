<?php


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
if ($_REQUEST['fct'] == "UserLogin") {
  // tester si la correspondance email / pass est bonne + renvoyer un json avec le résultat 
  function UserLogin($email, $password)
  {
    if (isset($_GET[`username`]) && $_GET[`username`] != '' && isset($_GET['password']) && $_GET['password'] != '') {
      $email = $_GET[`username`];
      $password = $_GET['password'];

      $getData = "SELECT `PK_USER`,`S_EMAIL`,`S_PASSWORD` FROM `tbl_user` WHERE `S_EMAIL`='" . $email .
        "'and `S_PASSWORD`='" . $password .
        "'";
      $result = mysqli_query($conn, $getData);
      $userId = "";
      while ($r = mysqli_fetch_row($result)) {
        $userId = $r[0];
      }
      if ($result->num_rows > 0) {
        $resp["status"] = "1";
        $resp["userid"] = $userId;
        $resp["message"] = "Login successfully";
      } else {
        $resp["status"] = "-2";
        $resp["message"] = "Enter correct username or password";
      }
    }
  }
  if ($_REQUEST['fct'] == "UserAdd") {
    // Ajouter l'utilisateur a la db, controle des champs + sécurité des requetes
  }

  if ($_REQUEST['fct'] == "UserPasswordReset") {
  }
}
