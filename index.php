<?php
require_once "pdo.php";
session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
<title>c7196610</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>
<body>
  <div class="container">
  <h1>Mohammed Abdul Muhaymin's Resume Registry</h1>
  <?php
  $stmt = $pdo->query("SELECT first_name, last_name, headline, profile_id FROM profile");
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if  (isset($_SESSION["user_id"])) {
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success']) ) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
    echo('<p><a href="logout.php">Logout</a></p>');
    echo('<table border="1">'."\n");
    echo('<thead><tr>
  <th>Name</th>
  <th>Headline</th>
  <th>Action</th>
  </tr></thead>');
    foreach ( $rows as $row ) {
        echo "<tr><td>";
        echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$row['first_name'].$row["last_name"]. '</a>');
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td><td>");
        echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> ');
        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
        echo("</td></tr>\n");
    }
    echo('</table>');
    echo('<p><a href="add.php">Add New Entry</a></p>');
    }
    else {
      echo('<p>
    <a href="login.php">Please log in</a>
    </p>');
    echo('<table border="1">'."\n");
    echo('<thead><tr>
  <th>Name</th>
  <th>Headline</th>
  </tr></thead>');
    foreach ( $rows as $row ) {
        echo "<tr><td>";
        echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$row['first_name'].$row["last_name"]. '</a>');
        echo("</td><td>");
        echo(htmlentities($row['headline']));
        echo("</td></tr>\n");
    }
    echo('</table>');
  }
  echo('<p>
  <b>Note:</b> Your implementation should retain data across multiple
  logout/login sessions.  This sample implementation clears all its
  data on logout - which you should not do in your implementation.
  </p>');
  ?>
  </div>
</body>
</html>
