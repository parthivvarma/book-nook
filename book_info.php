<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: burlywood;
            margin: 0;
            padding: 20px;
        }
        .book-info-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto 20px;
        }
        .book-info-container img {
            max-width: 100%;
            margin-bottom: 20px;
        }
        .comments-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .comment {
            margin-bottom: 20px;
        }
        .comment p {
            margin: 0;
        }
    </style>
</head>
<body>
    <?php
    // Get the book ID from the URL
    if (isset($_GET['book_id'])) {
        $book_id = $_GET['book_id'];
    } else {
        echo "Book ID not provided.";
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "book nook";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query the database to get book details
    $sql_book = "SELECT * FROM books WHERE book_id = $book_id";
    $result_book = $conn->query($sql_book);

    if ($result_book->num_rows > 0) {
        $row_book = $result_book->fetch_assoc();
        echo "<div class='book-info-container'>";
        echo "<img src='" . $row_book["coverpage_link"] . "' alt='" . $row_book["book_name"] . "'>";
        echo "<h2>" . $row_book["book_name"] . "</h2>";
        echo "<p><strong>Author:</strong> " . $row_book["book_author"] . "</p>";
        echo "<p><strong>Description:</strong> " . $row_book["book_description"] . "</p>";
        echo "<p><strong>Year Published:</strong> " . $row_book["year_published"] . "</p>";
        echo "</div>";
    } else {
        echo "Book not found.";
        exit();
    }

    // Query the database to get comments for the book
    $sql_comments = "SELECT * FROM comments WHERE book_id = $book_id";
    $result_comments = $conn->query($sql_comments);

    if ($result_comments->num_rows > 0) {
        echo "<div class='comments-container'>";
        echo "<h2>Comments</h2>";
        while ($row_comment = $result_comments->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p><strong>User:</strong> " . $row_comment["user_id"] . "</p>";
            echo "<p><strong>Comment:</strong> " . $row_comment["comment"] . "</p>";
            echo "<p><strong>Rating:</strong> " . $row_comment["rating"] . "</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<div class='comments-container'>";
        echo "<h2>No comments yet.</h2>";
        echo "</div>";
    }

    $conn->close();
    ?>
</body>
</html>
