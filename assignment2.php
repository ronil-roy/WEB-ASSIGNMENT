<?php

$dataFile = 'users.json';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (file_exists($dataFile)) {
        $jsonData = file_get_contents($dataFile);
        $users = json_decode($jsonData, true);
    } else {
        $users = [];
    }

    $users[] = ['name' => $name, 'email' => $email];

    file_put_contents($dataFile, json_encode($users));
}

$usersData = '';
if (file_exists($dataFile)) {
    $jsonData = file_get_contents($dataFile);
    $users = json_decode($jsonData, true);

    $usersData .= "<h3>Users List:</h3><div class='users-list'>";
    foreach ($users as $user) {
        $usersData .= "<div class='user'><strong>Name:</strong> " . htmlspecialchars($user['name']) . "<br>";
        $usersData .= "<strong>Email:</strong> " . htmlspecialchars($user['email']) . "<br><br></div>";
    }
    $usersData .= "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP User Submission Form</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container input[type="text"],
        .form-container input[type="email"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
        }
        .users-list {
            margin-top: 20px;
            background-color: #e9ecef;
            padding: 10px;
            border-radius: 5px;
        }
        .user {
            padding: 8px;
            border-bottom: 1px solid #ccc;
        }
        #userData {
            display: none;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <input type="submit" value="Submit">
    </form>
    
    <button id="toggleButton">Display Data</button>

    <div id="userData">
        <?php echo $usersData; ?>
    </div>
</div>

<script>
    document.getElementById("toggleButton").addEventListener("click", function() {
        var userDataDiv = document.getElementById("userData");
        if (userDataDiv.style.display === "none" || userDataDiv.style.display === "") {
            userDataDiv.style.display = "block";  
            this.textContent = "Hide Data";  
        } else {
            userDataDiv.style.display = "none";  
            this.textContent = "Display Data";  
        }
    });
</script>

</body>
</html>
