<?php
function loginForm()
{
echo "<form action='index.php' method='post'>";
echo "<p><input type='email' name='user_email' placeholder='Email' size='40' /></p>";
echo "<p><input type='password' name='password' placeholder='Password' size='40' /></p>";
echo "<p><input type='password' name='password2' placeholder='Re-type password to join (new user)' size='40' /></p>";
echo "<p><input type='submit' name='login' value='Log in / Sign up' /></p>";
echo "</form>";
}
 ?>
