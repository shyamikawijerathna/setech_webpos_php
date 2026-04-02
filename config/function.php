<?php 
session_start();
require 'dbcon.php';

// Input validation
function validate($inputData) {
    global $conn;
    return trim(mysqli_real_escape_string($conn, $inputData));
}

// Redirect with status message
function redirect($url, $status) {
    $_SESSION['status'] = $status;
    header("Location: $url");
    exit();
}

// Display status alert message
function alertMessage() {
    if (isset($_SESSION['status'])) {
        // Check if a specific type is set, otherwise default to 'info'
        $type = $_SESSION['status_type'] ?? 'info'; 
        
        echo '
        <div class="alert alert-'.$type.' alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill me-2"></i> <h6 class="mb-0">' . $_SESSION['status'] . '</h6>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        
        unset($_SESSION['status']);
        unset($_SESSION['status_type']);
    }
}

function checkParamId($type) {
    if(isset($_GET[$type])) {
        if($_GET[$type] != '') {
            return $_GET[$type];
        } else {
            return 'No ID Found';
        }
    } else {
        return 'No ID Given';
    }
}


    // Insert record using this function
function insert($tableName, $data) {
    global $conn;

    $table = validate($tableName);

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumn = implode(',', $columns);
    $finaValue = "'".implode("','", $values)."'";

    $query = "INSERT INTO $table($finalColumn) VALUES ($finaValue)";
    $result = mysqli_query($conn, $query);

    return $result;

  

} 

// update data using this function
function update($tableName, $id,$data){

    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $updateDataString ="";

    foreach($data as $column => $value){
        $updateDataString .= $column. '='. "'$value',";

    }

    $finalUpdateData = substr(trim($updateDataString),0,-1);

    $query =" UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn,$query);
    return $result;

}

// get all data with Soft Delete support---
function getAll($tableName, $status = NULL) {
    global $conn;

    // Use ?? '' to prevent PHP 8.1+ deprecation errors if parameters are null
    $table = validate($tableName ?? '');
    $status = validate($status ?? '');

    // 1. Start the base query
    $query = "SELECT * FROM $table WHERE 1=1";

    // 2. Check if the 'deleted_at' column exists in this specific table
    // This allows the function to work for tables WITH and WITHOUT soft delete
    $columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE 'deleted_at'");
    
    if($columnCheck && mysqli_num_rows($columnCheck) > 0) {
        // If the column exists, only show records that are NOT deleted
        $query .= " AND deleted_at IS NULL";
    }

    // 3. Keep your original status logic
    if($status == 'status') {
        $query .= " AND status='0'";
    }

    return mysqli_query($conn, $query);
}


// RESTORE FUNCTION - This will set deleted_at back to NULL, making the record visible again
function restore($tableName, $id) {
    global $conn;

    $table = validate($tableName ?? '');
    $id = validate($id ?? '');

    // Setting deleted_at to NULL makes it visible to getAll() again
    $query = "UPDATE $table SET deleted_at = NULL WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

//get by id
function getById($tableName, $id) {
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result) {
        if(mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            return [
                'status' => 200, 
                'data' => $row,
                'message' => 'Record Found'
            ];
        } else {
            return ['status' => 404, 'message' => 'No Data Found'];
        }
    } else {
        return ['status' => 500, 'message' => 'Something Went Wrong'];
    }
}



// soft Delete data from database using id

function delete($tableName, $id) {
    global $conn;

    $table = validate($tableName);
    $id = validate($id);
    $datetime = date('Y-m-d H:i:s');

    // Change from DELETE to UPDATE
    $query = "UPDATE $table SET deleted_at='$datetime' WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

//for dashboard cards
function getCount($tableName)
{
    global $conn;

    $table = validate($tableName);

    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn,$query);
    if($query_run){

        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;

    }else{
        return 'Something Went Wrong !';
    }
}


// admin level control

function checkPermission($allowedLevels) {
    if(!isset($_SESSION['loggedInUser'])) {
        redirect('login.php', 'Please login to continue');
    }

    $userLevel = $_SESSION['loggedInUser']['role_level'];

    // Check if the user's level is in the allowed list
    if(!in_array($userLevel, $allowedLevels)) {
        echo '<div class="text-center mt-5">
                <h1 class="display-1 text-danger">403</h1>
                <h3>Access Denied!</h3>
                <p>You do not have permission to view this page.</p>
                <a href="index.php" class="btn btn-primary">Go to Dashboard</a>
              </div>';
        exit();
    }
}


?>