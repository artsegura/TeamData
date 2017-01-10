<?php require_once("../includes/session.php"); ?><?php require_once("../includes/db_connection.php"); ?><?php require_once("../includes/functions.php"); ?><?php     // use the function ConfirmLoggedIn to see if the current user        // is allowed to view this page    ConfirmLoggedIn();?><?php    $User = FindMemberById($_SESSION["MemberId"]);        // Check to see if the current user can edit members.    // If not, then the user cannot have access to this page.    if($User["EditMembers"] == 0) {        RedirectTo("index.php");    }?><?php $layout_context = "admin"; ?><?php include("../includes/layouts/header.php"); ?><div id="main">      <div id="navigation">            &nbsp;      </div>      <div id="page">            <h2>Report Menu</h2>            <p>Welcome to the Report Menu, <?php echo htmlentities($User["FirstName"]) . " " . htmlentities($User["LastName"]); ?></p>            <ul>                  <li><a href="http://www.team5427.org/TeamData/reportico-4.6/run.php?execute_mode=PREPARE&project=Team5427&xmlin=AllMembers.xml">All Members</a></li>                  <li><a href="http://www.team5427.org/TeamData/reportico-4.6/run.php?execute_mode=PREPARE&project=Team5427&xmlin=RoleSelection.xml">Member Role Selection</a></li>                  <li><a href="http://www.team5427.org/TeamData/reportico-4.6/run.php?execute_mode=PREPARE&project=Team5427&xmlin=RoleSelectionParents.xml">Member Role Selection With Parents</a></li>                  <li><a href="http://www.team5427.org/TeamData/reportico-4.6/run.php?execute_mode=PREPARE&project=Team5427&xmlin=MembersNoRoles.xml">Members with no Member Roles assigned</a></li>                  <li><a href="http://www.team5427.org/TeamData/reportico-4.6/run.php?execute_mode=PREPARE&project=Team5427&xmlin=EmergencyContacts.xml">Emergency Contacts</a></li>                  <li><a href="http://www.team5427.org/TeamData/reportico-4.6/run.php?execute_mode=PREPARE&project=Team5427&xmlin=ShirtSizes.xml">Shirt Sizes</a></li>                  <li><a href="logout.php">Logout</a></li>            </ul>        <br/>        <br/>        <a href="index.php">Main Menu</a>    </div></div><?php include("../includes/layouts/footer.php"); ?>