<?php require_once("includes/header.php"); ?>

<div class="mainPosBg d-flex align-items-center" style="background: url('admin/assets/img/log.jpg') no-repeat center center; background-size: cover; height: 100vh;"> 
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center text-white">

                <?php alertMessage(); ?>

                <h1 class="display-4 fw-bold">SE TECHNOLOGIES POS SYSTEM</h1>

                <?php if(!isset($_SESSION['loggedIn'])) : ?>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="login.php" class="btn btn-success btn-lg px-5">Login here</a>
                    </div>
                <?php else: ?>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="admin/index.php" class="btn btn-success btn-lg px-5">Go to Dashboard</a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>



 

<?php require_once("includes/footer.php"); ?>