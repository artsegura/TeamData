<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

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
  $Member = FindMemberById($_GET["id"]);

  if (!$Member) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    RedirectTo("manage_member_training.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  // validations
  //$required_fields = array("Date", "NumberOfHours");
  //ValidatePresences($required_fields);

  if (empty($errors)) {
    // Perform Update
    $MemberId = $Member["MemberId"];
    $TrainingCourseId = $_POST["TrainingCourseSelect"];
    // Convert a date string into a Unix date.
    $ModifiedDate = strtotime($_POST["DateTaken"]);
    // Convert a Unix date into a MySQL format date.
    $DateTaken = date('Y-m-d H:i:s', $ModifiedDate);
    
    $query  = "INSERT INTO TrainingTaken (";    
    $query .= "  MemberId, TrainingCourseId, DateTaken";    
    $query .= ") VALUES (";    
    $query .= "  {$MemberId}, {$TrainingCourseId}, '{$DateTaken}'";    
    $query .= ")";    
    $result = mysqli_query($connection, $query);    
    if ($result) {      
        // Success      
        $_SESSION["message"] = "Member Training created.";      
        RedirectTo("view_member_training.php?id=" . urlencode($Member["MemberId"]));    
    } else {      
        // Failure      
        $_SESSION["message"] = "Member Training creation failed.";    
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
    <h2>Add Member Training: <?php echo htmlentities($Member["FirstName"]) . " " . htmlentities($Member["LastName"]); ?></h2>
    <form action="new_member_training.php?id=<?php echo urlencode($Member["MemberId"]); ?>" method="post">
      <p>Date Taken:
        <input type="text" name="DateTaken" value="" />Enter Date in mm/dd/yyyy format
      </p>
        <p>Course:
            <?php $TrainingCoursesSet = FindAllTrainingCourses(); ?>
            <select name="TrainingCourseSelect">
                <option value="">Select...</option>
            <?php while($TrainingCourses = mysqli_fetch_assoc($TrainingCoursesSet)) { ?>                    
                <option value="<?php echo $TrainingCourses["TrainingCourseId"]; ?>"><?php echo $TrainingCourses["CourseName"]; ?></option>
            <?php } ?>
            </select>
        </p>
      <input type="submit" name="submit" value="Save" />
    </form>
    <br />
    <a href="view_member_training.php?id=<?php echo urlencode($Member["MemberId"]); ?>">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>