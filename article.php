<?php
// Include the database configuration
include('config.php');

// Check if 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Query to retrieve the article by ID, including uploadtime
    $sql = "SELECT id, title, article, author, uploadtime FROM news WHERE id = $articleId";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $author = $row['author'];
        $uploadtime = $row['uploadtime'];

        $url = $row['article'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
    } else {
        $title = "Article not found";
        $content = "The requested article was not found.";
        $author = "";
    }
} else {
    $title = "Invalid request";
    $content = "No article ID provided.";
    $author = "";
}

// Function to format MySQL datetime to a user-friendly format
function formatDatetime($datetime) {
    $timestamp = strtotime($datetime);
    return date('F j, Y, g:i a', $timestamp);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>EggNews: <?php echo $title; ?></title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .preformatted-text {
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="https://eggboyscooter.xyz">EggNews</a>
            <ul class="navbar-nav ml-auto">
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
        <div class="col-md-8">
            <h2><?php echo $title; ?></h2>
            <p>by <?php echo $author; ?> - Published on <?php echo formatDatetime($uploadtime); ?></p>
            <!-- Add a gap between "by Author" and the content -->
            &nbsp;
            <div class="outlined-box preformatted-text">
                <?php echo nl2br($response); // Display the content retrieved from the URL as preformatted text ?>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
