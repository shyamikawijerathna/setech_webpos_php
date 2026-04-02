<?php
include "includes/header.php";
include "includes/db.php";

$success = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO contacts (name,email,message) VALUES (?,?,?)");
    if($stmt->execute([$name,$email,$message])) {
        $success = "Thank you! Your message has been sent.";
    }
}
?>

<section class="section">
<h2>Contact Us</h2>

<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="POST" style="max-width:600px;">
    <input type="text" name="name" placeholder="Your Name" required style="width:100%;padding:10px;margin:10px 0;"><br>
    <input type="email" name="email" placeholder="Your Email" required style="width:100%;padding:10px;margin:10px 0;"><br>
    <textarea name="message" placeholder="Your Message" required style="width:100%;padding:10px;margin:10px 0;"></textarea><br>
    <button type="submit" class="btn">Send Message</button>
</form>
</section>

<?php include "includes/footer.php"; ?>
