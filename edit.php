<?php
require_once "pdo.php";
if (isset($_POST['cancel'])) {
  header( 'Location: index.php' ) ;
  return;
}
session_start();
if ( isset($_POST['first_name']) || isset($_POST['last_name']) || isset($_POST['email']) || isset($_POST['summary']) || isset($_POST['headline']) ) {
  if ( (!isset($_POST['first_name']) || trim($_POST['first_name']) == '') || (!isset($_POST['last_name']) || trim($_POST['last_name']) == '')||
   (!isset($_POST['email']) || trim($_POST['email']) == '') ||
  (!isset($_POST['summary']) || trim($_POST['summary']) == '')|| (!isset($_POST['headline']) || trim($_POST['headline']) == '') ) {
    $_SESSION["error"] = "All fields are required";
    header("Location: edit.php?profile_id=".$_POST['profile_id']);
    return;
  } else if (strpos($_POST['email'],'@') === false ) {
    $_SESSION["error"] = "Email address must contain @";
    header("Location: edit.php?profile_id=".$_POST['profile_id']);
    return;
  } else {
    $sql= "UPDATE profile SET user_id = :uid,
            first_name = :fn, last_name = :ln, email = :em,
            headline = :he, summary = :su"
            WHERE ;
    $stmt = $pdo->prepare($sql);
$stmt->execute(array(
':uid' => $_SESSION['user_id'],
':fn' => $_POST['first_name'].' ',
':ln' => $_POST['last_name'],
':em' => $_POST['email'],
':he' => $_POST['headline'],
':su' => $_POST['summary'])
);
      $_SESSION['success'] = 'Profile updated';
      header( 'Location: index.php' ) ;
      return;
  }
}
// Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}
// Flash pattern
$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$he = htmlentities($row['headline']);
$su = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>3b5baa42</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body><p>
  <div class="container">
    <h1>Editing Profile for <?php
    if ( isset($_SESSION['name']) ) {
        echo htmlentities($_SESSION['name']);
    }
    ?></p></h1>
  <?php if ( isset($_SESSION['error']) ) {
      echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
  } ?>
  <form method="post" action="edit.php">
  <p>First Name:
  <input type="text" name="first_name" size="60"
  value="<?= $fn ?>"
  /></p>
  <p>Last Name:
  <input type="text" name="last_name" size="60"
  value="<?= $ln ?>"
  /></p>
  <p>Email:
  <input type="text" name="email" size="30"
  value="<?= $em ?>"
  /></p>
  <p>Headline:<br/>
  <input type="text" name="headline" size="80"
  value="<?= $he ?>"
  /></p>
  <p>Summary:<br/>
  <textarea name="summary" rows="8" cols="80"><?=$fn?></textarea>
  <p>
  <input type="hidden" name="profile_id"
  value="<?= $profile_id ?>"
  />
  <input type="submit" value="Save">
  <input type="submit" name="cancel" value="Cancel">
  </p>
  </form>
</body>
</html>
