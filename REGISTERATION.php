<?php
// Simple PHP backend for service registration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $contact = htmlspecialchars($_POST["contact"]);
    $address = htmlspecialchars($_POST["address"]);
    $service = htmlspecialchars($_POST["service"]);
    $experience = htmlspecialchars($_POST["experience"]);

    // Handle image upload
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = basename($_FILES["photo"]["name"]);
    $targetFile = $targetDir . time() . "_" . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile)) {
            // Save registration data (for demo, we’ll use a text file)
            $data = "Name: $name\nContact: $contact\nAddress: $address\nService: $service\nExperience: $experience\nPhoto: $targetFile\n----------------------\n";
            file_put_contents("registrations.txt", $data, FILE_APPEND);

            echo "<h2>Registration Successful ✅</h2>";
            echo "<p>Thank you, <strong>$name</strong>! Your service registration has been submitted.</p>";
            echo "<p><a href='register.html'>Go Back</a></p>";
        } else {
            echo "Error uploading photo.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, GIF allowed.";
    }
} else {
    echo "Invalid request.";
}
?>
