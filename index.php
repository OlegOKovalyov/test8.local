<?php

// include database and object files
include_once 'classes/database.php';
include_once 'classes/user.php';
include_once 'initial.php';

// for pagination purposes
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$from_record_num = ($records_per_page * $page) - $records_per_page; // calculate for the query limit clause

// instantiate database and user object
$user = new User($db);
$total_rows = $user->countAll();
$total_pages = ceil($total_rows / $records_per_page);;

// include header file
$page_title = "User list";
include_once "header.php";

// show page header
echo "<div class='page-header d-flex justify-content-between'>";
echo "<h2>{$page_title}</h2>";

// create user button
echo "<div class='right-button-margin'>";
echo "<a href='create.php' class='btn btn-warning bg-gradient-warning text-white'>";
echo "<i class=\"fa fa-plus-circle\" aria-hidden=\"true\"></i> Add User";
echo "</a>";
echo "</div></div><!-- .page-header -->";
echo '<hr class="mt-0" style="border-width:3px;">';

// table info bar
echo '<div class="filter mb-2">';
echo '<form action="" role="form" method="post">';
echo '<div>Page ' . ' <input type="number" name="cur_page_num" min="1" max="500" readonly value="' . $page . '">';
echo ' of ' . $total_pages . ' pages';
echo ' | View  <input type="number" name="paged" min ="1" max="99" readonly';
echo ' value="' . $records_per_page . '"> per page ';
echo ' per page ';
echo ' | Total ' . $total_rows . ' records found</div>';
echo '</form></div><!-- .filter -->';

// select all users
$prep_state = $user->getAllUsers($from_record_num, $records_per_page); //Name of the PHP variable to bind to the SQL statement parameter.
$num = $prep_state->rowCount();


// check if more than 0 record found
if($num>=0){

    echo "<table id='user-table' class='table table-hover table-responsive table-bordered' style='display: table;'>";
    echo "<thead class='thead-light'>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>E-Mail</th>";
    echo "<th>Create Date</th>";
    echo "<th>Update Date</th>";
    echo "<th>Actions</th>";
    echo "</tr>";

    while ($row = $prep_state->fetch(PDO::FETCH_ASSOC)){

        extract($row); //Import variables into the current symbol table from an array
        $createDate = strtotime($row['create_date']);
        $createDateScreen = date( 'j M Y g:i:s a', $createDate );
        $updateDate = strtotime($row['update_date']);
        $updateDateScreen = date( 'j M Y g:i:s a', $updateDate );

        echo "<tr>";

        echo "<td>$row[id]</td>";
        echo "<td>$row[first_name]</td>";
        echo "<td>$row[last_name]</td>";
        echo "<td>$row[email]</td>";
        echo "<td>$createDateScreen</td>";
        echo "<td>$updateDateScreen</td>";

        echo "<td>";
        // edit user button
        echo "<a href='edit.php?id=" . $id . "' class='btn btn-warning left-margin'>";
        echo "<i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></span> Edit";
        echo "</a>";

        // delete user button
        echo "<a href='delete.php?id=" . $id . "' class='btn btn-danger delete-object'>";
        echo "<i class=\"fa fa-trash\" aria-hidden=\"true\"></i></span> Delete";
        echo "</a>";

        echo "</td>";
        echo "</tr>";
    }

    echo "</thead>";
    echo "</table>";
    echo '<div id="information"></div>';

    // include pagination file
    include_once 'pagination.php';
}

// if there are no user
else{
    echo "<div> No User found. </div>";
    }

include_once "footer.php";
