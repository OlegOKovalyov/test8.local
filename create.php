<?php

// set page headers
$page_title = "Create User";
include_once "header.php";

// get database connection
include_once 'classes/database.php';
include_once 'initial.php';

// show page header
echo "<div class='page-header d-flex justify-content-between'>";
echo "<h2>{$page_title}</h2>";

// read user form and buttons
echo '<form action="create.php" role="form" method="post">';
echo "<div class='form'>";
    echo "<a href='index.php' class='btn btn-light left-margin'>";
        echo "<i class=\"fa fa-arrow-circle-left\" aria-hidden=\"true\"></i></span> Back ";
    echo "</a>";

    echo '<button type="submit" class="btn btn-warning bg-gradient-warning text-white">';
        echo '<i class="fa fa-check-circle" aria-hidden="true"></i></span> Save';
    echo '</button>';

    echo "</div></div><!-- .page-header -->";
    echo '<hr class="mt-0" style="border-width:3px;">';

    // check if the form is submitted
    if ($_POST){

        // instantiate user object
        include_once 'classes/user.php';
        $user = new User($db);

        // set user property values
        $user->first_name = htmlentities(trim($_POST['first_name']));
        $user->last_name = htmlentities(trim($_POST['last_name']));
        $user->email = htmlentities(trim($_POST['email']));

        $timestamp = date('Y-m-d H:i:s');
        $user->create_date = $timestamp;
        $user->update_date = $timestamp;

        // if the user able to create
        if($user->create()){
            echo "<div class=\"alert alert-success alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Success! User is created.";
            echo "</div>";
        }

        // if the user unable to create
        else{
            echo "<div class=\"alert alert-danger alert-dismissable\">";
            echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">
                        &times;
                  </button>";
            echo "Error! Unable to create user.";
            echo "</div>";
        }
    }
    ?>
    <div class="alert alert-info mb-0" role="alert">User information</div>
    <table class='table table-hover table-responsive table-bordered' style='display: table;'>
        <tr>
            <td>First Name</td>
            <td><input type='text' name='first_name'  class='form-control' placeholder="Enter First Name" required></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='last_name' class='form-control' placeholder="Enter Last Name" required></td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td><input type='email' name='email' class='form-control' placeholder="Enter Email Address " required></td>
        </tr>
    </table>
</form>

<?php
include_once "footer.php";
?>

