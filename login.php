<?php 
require_once("includes/header.php"); 

if(isset($_SESSION['loggedIn'])){
    ?>
    <script>window.location.href = 'index.php';</script>
    <?php
    exit();
}
?>

<link rel="stylesheet" href="assets/css/login.css">

<div class="login-wrapper">
    <div class="login-container">
        <?php alertMessage(); ?>
        <div class="login-box">
            <div class="text-center mb-4">
                
                <div class="logo" style="width: 100px; height: 100px; margin: 0 auto;">
                    <img src="assets/uploads/products/logo.jpeg " style="width: 100px; height: 100px;" alt="Logo" class="icon-header">
                </div>
                <h4 class="main-title mt-3 fw-bold">Welcome Back</h4>
    
            </div>

            <form action="login-code.php" method="POST">
                <div class="mb-4">
                    <label class="text" style="font-size: 1.0rem;">Email Address</label>
                    <div class="input-group" align="center">
                        <span class="input-group">
                            
                        </span>
                        <input type="email" name="email" class="form-control custom-input shadow-none" placeholder="Enter Email ID" required />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="text" style="font-size: 1.0rem;">Password</label>
                    <div class="input-group" align="center">
                        <span class="input-group">
                            
                        </span>
                        <input type="password" name="password" class="form-control custom-input shadow-none" placeholder="Enter Password" required />
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button type="submit" name="loginBtn" class="btn btn-login px-5 fw-bold">SIGN IN</button>
                </div>
            </form>
            
            <div class="login-footer mt-5">
                <small class="text-white-50 opacity-50">&copy; 2026 MDM Restaurant</small>
            </div>
        </div>
    </div>
</div>




<?php require_once("includes/footer.php"); ?>