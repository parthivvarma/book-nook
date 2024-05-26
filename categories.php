<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: burlywood;
            margin: 0;
            padding: 20px;
        }
        .categories-container {
            display: flex;
            flex-wrap: wrap;
        }
        .category-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(25% - 20px);
            margin-right: 20px;
            margin-bottom: 20px;
            padding: 20px;
            cursor: pointer;
        }
        .category-item:last-child {
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="categories-container">
        <?php
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

        // Get all categories
        $sql = "SELECT * FROM categories";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='category-item' onclick=\"window.location.href='show_books.php?category_id=" . $row["category_id"] . "'\">";
                echo "<h3>" . $row["category_name"] . "</h3>";
                echo "</div>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
