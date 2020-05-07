<?php // Do not put any HTML above this line
require_once "pdo.php";
session_start();
$salt = 'XyZzy12*_';
// Check to see if e have some POST data, if we do process it
if ( isset($_POST['cancel'])) {
  header( 'Location: index.php' ) ;
  return;
}
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION["user_id"]);
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION["error"] = "User name and password are required";
        header( 'Location: login.php' ) ;
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users
        WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ( $row !== false ) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        header( 'Location: index.php' ) ;
        return;
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"]= "Email must have an at-sign (@)";
            header( 'Location: login.php' ) ;
            return;
          } else {
            $_SESSION["error"] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header( 'Location: login.php' ) ;
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>c7196610</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<form method="POST" action="login.php">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find an account and password hint
in the HTML comments.
<!-- Hint:
The account is umsi@umich.edu
The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>
<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>
</div>
</body>
