<?php

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $drink = htmlspecialchars($_POST['drink']);
    $pickup = htmlspecialchars($_POST['pickup']);
    $quantity = htmlspecialchars($_POST['quantity']);

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "coffee_cafe";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders (name, email, drink, pickup, quantity)
    VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssi", $name, $email, $drink, $pickup, $quantity);

    // Execute query
    if ($stmt->execute()) {

        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Order Success</title>

            <style>

                body{
                    font-family: Arial, sans-serif;
                    background:#f5eee6;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    height:100vh;
                }

                .success-box{
                    background:white;
                    padding:40px;
                    border-radius:15px;
                    text-align:center;
                    box-shadow:0 5px 15px rgba(0,0,0,0.2);
                }

                h1{
                    color:#4e342e;
                }

                p{
                    color:#6d4c41;
                    font-size:18px;
                }

                a{
                    display:inline-block;
                    margin-top:20px;
                    padding:12px 20px;
                    background:#4e342e;
                    color:white;
                    text-decoration:none;
                    border-radius:8px;
                }

                a:hover{
                    background:#6d4c41;
                }

            </style>

        </head>

        <body>

            <div class='success-box'>

                <h1>Order Placed Successfully!</h1>

                <p>Thank you, $name.</p>

                <p>Your order for <strong>$quantity $drink</strong> has been received.</p>

                <p>Order Type: <strong>$pickup</strong></p>

                <a href='order.html'>Place Another Order</a>

            </div>

        </body>
        </html>
        ";

    } else {

        echo "Error: " . $stmt->error;

    }

    // Close connection
    $stmt->close();
    $conn->close();
}

?>