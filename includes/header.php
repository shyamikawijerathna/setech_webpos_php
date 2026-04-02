
<?php 
require 'config/function.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    
    
</head>
<body>

<style>

/* 1. Parent Wrapper to center the button on the page */
.center-container {
    display: flex;
    justify-content: center; /* Horizontal center */
    align-items: center;     /* Vertical center */
    min-height: 50vh;        /* Adjust this height to control vertical placement */
    width: 100%;
}

/* 2. The Button Styling */
.login-btn {
    display: inline-block;
    background: #5cee99 ;
    color: #ffffff;
    text-decoration: none;    /* Removes the underline */
    padding: 12px 40px;
    font-size: 1rem;
    font-weight: 600;
    border-radius: 12px;      /* Pill shape */
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
    cursor: pointer;
    width: 200px;
    height: 50px;
    text-align: center;
}

/* 3. Hover Effect */
.login-btn:hover {
    transform: translateY(-3px); /* Lift effect */
    box-shadow: 0 8px 20px rgba(30, 58, 138, 0.4);
    background:  #057050;
    color: #ffffff;
}

.login-btn:active {
    transform: translateY(-1px);
}

.display-4{
     color: #ffffff;
     font-size: 36px;
     letter-spacing: 1.0px;
     text-align:center;
     padding: 20px;
}



/* 1. Reset everything to zero */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* 2. Fix the body so it doesn't have white space */
html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    /* This stops the page from shifting left/right */
    overflow-x: hidden; 
}

/* 3. Ensure the login wrapper actually fills the whole screen */
.login-wrapper {
    min-height: 100vh;
    width: 100vw;
    margin: 0;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    /* This makes sure the gradient starts exactly at the edge */
    background-attachment: fixed; 
}
/* Login Page Wrapper */
.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: radial-gradient(circle at top left, #0e425a, #08587e, #0792bd);
    padding: 15px;
}

/* Container Spacing */
.mb-4 {
    margin-bottom: 1.8rem !important; /* Increases gap between Email and Password blocks */

}



/* Placeholder Color */
.custom-input::placeholder {
    color: rgba(255, 255, 255, 0.25) !important;
}

/* Glassmorphism Box */
.login-box {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    padding: 45px 35px;
    border-radius: 30px;
    width: 100%;
    max-width: 420px;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
}


.main-title {
    color: #ffffff;
    font-size: 36px;
    letter-spacing: 1.0px;
    text-align:center;
}

.uppercase-label {
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 1.0rem !important;
}



.custom-input {
    background: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
    border-radius: 12px 12px 12px 12px !important;
    padding: 12px !important;
    transition: all 0.3s ease;
    width:300px
}

.custom-input:focus {
    background: rgba(255, 255, 255, 0.1) !important;
    border-color: rgba(255, 255, 255, 0.4) !important;
    box-shadow: 0 0 15px rgba(255, 255, 255, 0.05);
    outline: none;
}

.custom-input::placeholder {
    color: rgba(255, 255, 255, 0.3);
}

/* Sign In Button */
.btn-login {
    background: #f9fc3f;
    color: #0f172a;
    border: none;
    padding: 14px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    margin-top: 10px;
    margin: 10px 40px 50px 100px;s
    
}

.btn-login:hover {
    background: #42e933;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    color: #000;
}

.btn-login:active {
    transform: translateY(0);
}


.login-footer {
    width: 100%;
    display: flex;          /* Use flexbox for alignment */
    justify-content: center; /* Horizontally centers the content */
    align-items: center;     /* Vertically centers if needed */
    clear: both;
    padding: 0px 0;        /* Only vertical padding, no side offsets */
}

.login-footer small {
    display: inline-block;
    letter-spacing: 1px;
    text-transform: uppercase;
    font-size: 0.7rem;
    color: rgba(2, 0, 0, 0.5); /* Semi-transparent for professional look */
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
    text-align: center;      /* Ensures text inside the small tag is centered */
}

</style>
        <?php require_once("navbar.php"); ?>
