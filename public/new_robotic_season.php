<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 
    // use the function ConfirmLoggedIn to see if the current user    
    // is allowed to view this page
    ConfirmLoggedIn();
?>

<?php
    $User = FindMemberById($_SESSION["MemberId"]);
    
    // Check to see if the current user can edit members.
    // If not, then the user cannot have access to this page.
    if($User["EditMembers"] == 0) {
        RedirectTo("index.php");
    }
?>

<?php
    if (isset($_POST['submit'])) {  
        // Process the form  
        // validations  
        $required_fields = array("RoboticSeasonName");  
        ValidatePresences($required_fields);  
        $fields_with_max_lengths = array("RoboticSeasonName" => 20);  
        ValidateMaxLengths($fields_with_max_lengths);  
        if (empty($errors)) {    
            // Perform Create    
            $RoboticSeasonName = MysqlPrep($_POST["RoboticSeasonName"]);
            $query  = "INSERT INTO RoboticSeasons (";    
            $query .= " RoboticSeasonName";    
            $query .= ") VALUES (";    
            $query .= "  '{$RoboticSeasonName}'";    
            $query .= ")";    
            $result = mysqli_query($connection, $query);    
            if ($result) {      
                // Success      
                $_SESSION["message"] = "Robotic Season created.";      
                RedirectTo("manage_robotic_seasons.php");    
            } else {      
                // Failure      
                $_SESSION["message"] = "Robotic Season creation failed.";    
            }  
        }
    } else {  
        // This is probably a GET request
    }   // end: if (isset($_POST['submit']))
    ?>
        
    <?php $layout_context = "admin"; ?>
    <?php include("../includes/layouts/header.php"); ?>
    <div id="main">  
        <div id="navigation">    
            &nbsp;  
        </div>  
        <div id="page">    
            <?php echo message(); ?>    
            <?php echo FormErrors($errors); ?>    
            <h2>New Robotic Season</h2>    
            <form action="new_robotic_season.php" method="post">      
                <p>Robotic Season Name:        
                    <input type="text" name="RoboticSeasonName" value="" />      
                </p>      
                <input type="submit" name="submit" value="Save Robotic Season" />    
            </form>    
            <br />    
            <a href="manage_robotic_seasons.php">Cancel</a>  
        </div>
    </div>
        
    <?php include("../includes/layouts/footer.php"); ?>