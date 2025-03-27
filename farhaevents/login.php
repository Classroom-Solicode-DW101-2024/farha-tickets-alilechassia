<?php
require 'connect.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $mailUser = $_POST['email'];
    $motPasse = $_POST['password'];

    $sql = "SELECT * FROM utilisateur WHERE mailUser = '$mailUser'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        if($motPasse == $user['motPasse']){
            echo "login successful";
       } else {
                echo "incorrect password!";
            }
        } else {
            echo "No user found with that email!";
            header('Location: register.php');
        }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<style>
body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #D3BBCB;
    }

    header {
        background-color: #A6AAA8;
        padding: 10px 0;
    }

    nav ul {
        list-style-type: none;
        text-align: center;
        margin: 0;
        padding: 0;
    }

    nav ul li {
        display: inline-block;
        margin-right: 20px;
    }

    nav ul li a {
        color: white;
        font-size: 18px;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    nav ul li a:hover {
        background-color: #D3BBCB;
        color: white;
    }

    .container {
        width: 400px;
        background: #E7D8E2;
        padding: 25px;
        margin: 50px auto;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
    }

    h2 {
        color: #34495E;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        text-align: left;
        font-weight: bold;
        margin-top: 10px;
        color: #333;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button {
        background-color: #A6AAA8;
        color: white;
        padding: 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 15px;
        transition: 0.3s;
    }

    button:hover {
        background-color: #D3BBCB;
    }

    .error {
        color: red;
        text-align: center;
        margin-top: 10px;
    }

    .success {
        color: green;
        text-align: center;
        margin-top: 10px;
    }
    </style>
<body>
    <form action="login.php" method="post">
    <label for="email">Email:</label>
    <br>
    <input type="email" id="email" name="email" required>
    <br><br>
    <label for="password">Password:</label>
    <br>
    <input type="password" id="password" name="password">
    <br><br>
    <input type="submit" value="login">
</form>
</body>
</html>