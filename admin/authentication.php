<?php 

if(isset($_SESSION['loggedIn']))
{
    $email = Validate($_SESSION['loggedInUser']['email']);

    $query = "SELECT * FROM admins WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    // If no admin is found with that email, log them out
    if(mysqli_num_rows($result) == 0)
    {
        logoutSession();
        redirect('../login.php', 'Access Denied!');
    }
    
}
else
{
    redirect('../login.php', 'Login to Continue...!');
}

?>