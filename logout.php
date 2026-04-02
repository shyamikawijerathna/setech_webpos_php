<?php
require 'config/function.php';

if(isset($_SESSION['loggedIn'])){
    
    // Completely remove session variables
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
    
    // Optional: Completely destroy the session
    // session_destroy(); 

    redirect('login.php', 'Logged out successfully.');
} else {
    redirect('login.php', 'You are not logged in.');
}
?>