<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Include the database configuration
include('config.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>EggNews</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .outlined-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="https://eggboyscooter.xyz">EggNews</a>
            <ul class="navbar-nav ml-auto">
                     <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">Signup</a>
                </li>


            </ul>
        </nav>
    </header>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <!-- Display the latest news article from the database -->
                <h2>Latest News</h2>
                <?php
                // Modify the SQL query to fetch the highest ID news article
                $sql = "SELECT id, title, author, article, uploadtime FROM news ORDER BY id DESC LIMIT 1";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo '<div class="outlined-box">';
                    echo '<h3>' . $row['title'] . '</h3>';
                    echo '<p>Published on ' . date('F j, Y, g:i a', strtotime($row['uploadtime'])) . ' by ' . $row['author'] . '</p>';
                    echo '<div class="content">';
                    if (filter_var($row['article'], FILTER_VALIDATE_URL)) {
                        // Send a GET request to fetch the data from the URL
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $row['article']);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $response = curl_exec($ch);
                        curl_close($ch);
                        // Display only the first 50 characters
                        echo substr($response, 0, 50);
                        if (strlen($response) > 50) {
                            echo '... <a href="article.php?id=' . $row['id'] . '">Read more</a>';
                        }
                    } else {
                        // If content is not a valid URL, just display it
                        // Display only the first 50 characters
                        echo substr($row['article'], 0, 50);
                        if (strlen($row['article']) > 50) {
                            echo '... <a href="article.php?id=' . $row['id'] . '">Read more</a>';
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                } else {
                    echo "No news articles found.";
                }
                ?>
            </div>

<div class="col-md-4">
    <!-- Recent News Feed -->
    <h3>Recent News</h3>
    <ul class="list-group">
        <?php
        // Modify the SQL query to fetch the top 5 highest IDs
        $sql = "SELECT title, author, uploadtime FROM news ORDER BY id DESC LIMIT 5";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $formattedTime = date('F jS', strtotime($row['uploadtime']));
                echo '<li class="list-group-item">' . $row['title'] . '<br><small>Written by ' . $row['author'] . ' - Published on ' . $formattedTime . '</small></li>';
            }
        } else {
            echo "No recent news found.";
        }
        ?>
    </ul>
</div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
