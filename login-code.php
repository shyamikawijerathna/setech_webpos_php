<?php 
require "config/function.php"; 

if(isset($_POST['loginBtn']))
{
    $email = Validate($_POST['email']);
    $password = Validate($_POST['password']);

    if($email != '' && $password != '')
    {
        // JOIN admins with stores to get the store_code
        $query = "SELECT a.*, s.store_code, s.store_name 
                  FROM admins a 
                  LEFT JOIN stores s ON s.id = a.store_id 
                  WHERE a.email=? LIMIT 1";
        
        $stmt = mysqli_prepare($conn, $query);

        if($stmt){
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                if(!password_verify($password, $hashedPassword)){
                    redirect('login.php','Invalid Password');
                    exit();
                }

                if($row['is_ban'] == 1) {
                    redirect('login.php','Your account has been banned.');
                    exit();
                }

                // Set Session Data including Store Details
                $_SESSION['loggedIn'] = true;
                $_SESSION['loggedInUser'] = [
                    'user_id' => $row['id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'role_level' => $row['role_level'],
                    'store_id' => $row['store_id'],    // Saved for DB inserts
                    'store_code' => $row['store_code'] // Saved for Invoice prefix
                ];

                redirect('admin/index.php','Logged In Successfully!');

            } else {
                redirect('login.php','Invalid Email Address!');
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        redirect('login.php','All fields are mandatory!');
    }
}
?>