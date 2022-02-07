<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title>Login Admin</title>
<link rel="stylesheet" href="LogStyle.css">
</head>

<?php
session_start();
?>

<body>
<div class="login-box">
<fieldset>
<h6><?php echo $_SESSION['msg']; ?></h6>   
<h1>Login Admin</h1>
<form method="post" action="Log.php" id = "logs">
<div class="textbox">
<i class="fas fa-user"></i>
<input type="text" placeholder="Username" name="username" required>
</div>

<div class="textbox">
<i class="fas fa-lock"></i>
<input type="password" placeholder="Password" name="pass" required>
</div>

<button type="submit" id="submit" class="btn">Sign In</button>
</fieldset>

</form>
</div>
</body>
</html>
