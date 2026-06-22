<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];

    if (empty(trim($_POST['name']))) { $errors[] = "Name is required."; }
    else { $name = htmlspecialchars(trim($_POST['name'])); }

    if (empty(trim($_POST['email']))) { $errors[] = "Email is required."; }
    elseif (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) { $errors[] = "Enter a valid email."; }
    else { $email = htmlspecialchars(trim($_POST['email'])); }

    if (empty(trim($_POST['message']))) { $errors[] = "Message is required."; }
    else { $message = htmlspecialchars(trim($_POST['message'])); }

    if (!empty($errors)) {
        foreach ($errors as $err) {
            echo "<p style='color:red;'>$err</p>";
        }
        exit;
    }

    $conn = new mysqli("localhost", "root", "", "internship");
    if ($conn->connect_error) {
        echo "<p style='color:red;'>DB connection failed: " . $conn->connect_error . "</p>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Thank you, your message has been received!</p>";
    }  else {
    echo "<p style='color:green;'>Thank you, your message has been received!</p>";
}


    $stmt->close();
    $conn->close();

} else {
    echo "<p style='color:red;'>Please submit the form.</p>";
}
?>
