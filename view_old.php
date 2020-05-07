<?php
require_once "pdo.php";
session_start();
if ( ! isset($_SESSION["email"]) ) {
  die('Not logged in');
}
?>
<!DOCTYPE html>
<html>
<head>
<title>5a0ff452</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body><p>
  <div class="container">
  <h1>Tracking Autos for <?php
  if ( isset($_SESSION['email'] )) {
      echo htmlentities($_SESSION['email']);
  }
  ?></p></h1>
  <?php
  if ( isset($_SESSION['error']) ) {
      echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
  }
  if ( isset($_SESSION['success']) ) {
      echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
      unset($_SESSION['success']);
  }
  ?>
  <h2>Automobiles</h2>
  <ul>
    <?php
    $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ( $rows as $row ) {
        echo "<li><p>";
        echo($row['year'].' '.htmlentities($row['make']).' / '.$row['mileage'] );
        echo("</p></li>");
    }
    ?>
  </ul>
  <p>
  <a href="add.php">Add New</a> |
  <a href="logout.php">Logout</a>
  </p>
  </div>
</body>
</html>
