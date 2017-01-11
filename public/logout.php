<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
    // Version 1
    // Set the user Session variables to null and redirect to the login page
    //$_SESSION["admin_id"] = null;
    //$_SESSION["username"] = null;
    //redirect_to("login.php");
    
?>

<?php
    // Version 2
    // This completely destroys the current Session
    session_start();
    $_SESSION = array();
    if(isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
    RedirectTo("login.php");
?>