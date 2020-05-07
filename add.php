<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION["user_id"]) ) {
  die('ACCESS DENIED');
}
// If the user requested logout go back to index.php
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}
if ( isset($_POST['first_name']) || isset($_POST['last_name']) || isset($_POST['email']) || isset($_POST['summary']) || isset($_POST['headline']) ) {
  if ( (!isset($_POST['first_name']) || trim($_POST['first_name']) == '') || (!isset($_POST['last_name']) || trim($_POST['last_name']) == '')||
   (!isset($_POST['email']) || trim($_POST['email']) == '') ||
  (!isset($_POST['summary']) || trim($_POST['summary']) == '')|| (!isset($_POST['headline']) || trim($_POST['headline']) == '') ) {
    $_SESSION["error"] = "All fields are required";
    header("Location: add.php");
    return;
  } else if (strpos($_POST['email'],'@') === false ) {
    $_SESSION["error"] = "Email address must contain @";
    header("Location: add.php");
    return;
  } else {
    $stmt = $pdo->prepare('INSERT INTO Profile
(user_id, first_name, last_name, email, headline, summary)
VALUES ( :uid, :fn, :ln, :em, :he, :su)');

$stmt->execute(array(
':uid' => $_SESSION['user_id'],
':fn' => htmlentities($_POST['first_name'].' '),
':ln' => $_POST['last_name'],
':em' => $_POST['email'],
':he' => $_POST['headline'],
':su' => $_POST['summary'])
);
      $_SESSION['success'] = 'Record added';
      header( 'Location: index.php' ) ;
      return;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>c7196610</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body><p>
  <div class="container">
  <h1>Adding Profile for <?php
  if ( isset($_SESSION['name']) ) {
      echo htmlentities($_SESSION['name']);
  }
  ?></p></h1>
  <?php
  if ( isset($_SESSION['error']) ) {
      echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
  }
  ?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" size="60"/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"/></p>
<p>Email:
<input type="text" name="email" size="30"/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80"></textarea>
<p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
  </div>
</body>
</html>
