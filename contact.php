<?php
include "includes_web/header.php";
include "includes_web/navbar.php";
include "config/dbcon.php";
include "config/function.php";

$success = "";
$error = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($name === '' || $email === '' || $message === '') {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $message);

        if (mysqli_stmt_execute($stmt)) {
            $success = "Thank you! Your message has been sent successfully. We will contact you soon.";
            $name = $email = $message = "";
        } else {
            $error = "Unable to send your message right now, please try again.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<section class="container py-5">
    <div class="row gy-4">
        <div class="col-12 text-center mb-4">
            <h2>Contact Us</h2>
            <p class="text-muted">Send us a message or visit our office at the address below.</p>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm p-4">
                <h4 class="mb-3">Get in touch</h4>

                <?php if ($success): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Your Name</label>
                        <input type="text" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Your Message</label>
                        <textarea name="message" rows="5" class="form-control" required><?= isset($message) ? htmlspecialchars($message) : '' ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Send Message</button>
                </form>
            </div>

            <div class="card mt-4 shadow-sm p-4">
                <h4 class="mb-3">Our Office</h4>
                <p class="mb-2"><strong>Address:</strong><br>457/5 Deepahan Building,<br>Station Road, Batuwatta</p>
                <p class="mb-0"><strong>Phone:</strong> +94 765 789 022</p>
                <p class="mb-0"><strong>Email:</strong> info@setech.lk</p>
            </div>
        </div>

        <div class="col-lg-7">
           <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d285.92237500736917!2d79.9369776742455!3d7.053826244912006!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slk!4v1775129550699!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
