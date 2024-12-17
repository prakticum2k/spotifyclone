<?php
include("includes/config.php");
include("includes/classes/Account.php");
include("includes/classes/Constants.php");

$account = new Account($con);  // Ensure $con is properly initialized in config.php

include("includes/handlers/register-handler.php");
include("includes/handlers/login-handler.php");

// Function to retain input values after form submission
function getInputValue($name)
{
   if (isset($_POST[$name])) {
      return htmlspecialchars($_POST[$name]);  // Protect against XSS
   }
   return '';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Spotify Clone</title>

   <link rel="stylesheet" type="text/css" href="assets/css/register.css">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="assets/js/register.js"></script>

</head>

<body>



   <?php
   // Use PHP to determine which form to show based on POST data
   if (isset($_POST['registerButton'])) {
      echo '<script>
            $(document).ready(function() {
                $("#loginForm").hide();
                $("#registerForm").show();
            });
          </script>';
   } else {
      echo '<script>
            $(document).ready(function() {
                $("#loginForm").show();
                $("#registerForm").hide();
            });
          </script>';
   }
   ?>

   <div id="background">
      <div id="inputContainer">

         <!-- Login Form -->
         <form id="loginForm" action="register.php" method="POST">
            <h2>Log in to your account</h2>

            <p>
               <?php echo $account->getError(Constants::$loginFailed); ?>
               <label for="loginUsername">Username</label>
               <input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson" value="<?php echo getInputValue('loginUsername'); ?>" required>
            </p>

            <p>
               <label for="loginPassword">Password</label>
               <input id="loginPassword" name="loginPassword" type="password" required>
            </p>

            <button type="submit" name="loginButton">LOG IN</button>

            <div class="hasAccountText">
               <span id="hideLogin">Don't have an account yet? Sign up here.</span>
            </div>
         </form>

         <!-- Registration Form -->
         <form id="registerForm" action="register.php" method="POST">
            <h2>Create your free account</h2>

            <p>
               <?php echo $account->getError(Constants::$usernameCharacters); ?>
               <?php echo $account->getError(Constants::$usernameTaken); ?>
               <label for="username">Username</label>
               <input id="username" name="username" type="text" placeholder="e.g. bartSimpson" value="<?php echo getInputValue('username'); ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$firstNameCharacters); ?>
               <label for="firstName">First Name</label>
               <input id="firstName" name="firstName" type="text" placeholder="e.g. Bart" value="<?php echo getInputValue('firstName'); ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$lastNameCharacters); ?>
               <label for="lastName">Last Name</label>
               <input id="lastName" name="lastName" type="text" placeholder="e.g. Simpson" value="<?php echo getInputValue('lastName'); ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$emailInvalid); ?>
               <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
               <?php echo $account->getError(Constants::$emailTaken); ?>
               <label for="email">Email</label>
               <input id="email" name="email" type="email" placeholder="e.g. bart@example.com" value="<?php echo getInputValue('email'); ?>" required>
            </p>

            <p>
               <label for="email2">Confirm Email</label>
               <input id="email2" name="email2" type="email" placeholder="e.g. bart@example.com" value="<?php echo getInputValue('email2'); ?>" required>
            </p>

            <p>
               <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
               <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
               <?php echo $account->getError(Constants::$passwordCharacters); ?>
               <label for="password">Password</label>
               <input id="password" name="password" type="password" placeholder="Your password" required>
            </p>

            <p>
               <label for="password2">Confirm Password</label>
               <input id="password2" name="password2" type="password" placeholder="Confirm your password" required>
            </p>



            <div class="hasAccountText">
               <span id="hideRegister">Already have an account? Log in here.</span>
               <button type="submit" name="registerButton">SIGN UP</button>

            </div>

         </form>

         <div id="loginText">
            <h1>Get great music, right now</h1>
            <h2>Listen to great songs for free</h2>
            <ul>
               <li>Discover music you'll fall in love with</li>
               <li>Create your own playlists</li>
               <li>Follow artists to keep up to date</li>
            </ul>

         </div>


      </div>
   </div>


</body>

</html>