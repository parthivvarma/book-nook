<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: burlywood;
            margin: 0;
            padding: 20px;
        }
        .container {
            perspective: 1000px;
            transform-style: preserve-3d;
        }
        .surface {
            display: flex;
            flex-wrap: wrap;
        }
        .block {
            position: relative;
            width: 150px;
            height: 200px;
            margin: 10px;
            transform-style: preserve-3d;
            transition: transform 0.6s;
        }
        .block-inner {
            position: absolute;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
        }
        .block .front, .block .back, .block .left, .block .right, .block .top, .block .bottom {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            backface-visibility: hidden;
        }
        .block .front {
            transform: rotateY(0deg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }
        .block .back {
            transform: rotateY(180deg);
        }
        .block .left {
            transform: rotateY(-90deg);
            width: 30px;
            left: -15px;
        }
        .block .right {
            transform: rotateY(90deg);
            width: 30px;
            right: -15px;
        }
        .block .top {
            transform: rotateX(90deg);
            height: 30px;
            top: -15px;
        }
        .block .bottom {
            transform: rotateX(-90deg);
            height: 30px;
            bottom: -15px;
        }

        /* Added CSS rule to limit the max width of images */
        .books-container img {
            max-width: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="surface">
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

            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='block' onclick=\"window.location.href='show_books.php?category_id=" . $row["category_id"] . "'\">";
                    echo "<div class='block-inner'>";
                    echo "<div class='front'>";
                    echo "<h3>" . $row["category_name"] . "</h3>";
                    echo "</div>";
                    echo "<div class='back'></div>";
                    echo "<div class='left'></div>";
                    echo "<div class='right'></div>";
                    echo "<div class='top'></div>";
                    echo "<div class='bottom'></div>";
                    echo "</div>";
                    echo "</div>";
                }
            }

            $conn->close();
            ?>
        </div>
    </div>

    <div class="books-container">
        <?php
        // Connect to database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get top 3 books by ratings
        $sql = "SELECT b.book_id, b.book_name, b.book_author, b.coverpage_link, AVG(c.rating) AS avg_rating
                FROM books b
                JOIN comments c ON b.book_id = c.book_id
                GROUP BY b.book_id, b.book_name, b.book_author, b.coverpage_link
                ORDER BY avg_rating DESC
                LIMIT 3";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='book-item' onclick=\"window.location.href='book_info.php?book_id=" . $row["book_id"] . "'\">";
                echo "<h3>" . $row["book_name"] . "</h3>";
                echo "<p><strong>Author:</strong> " . $row["book_author"] . "</p>";
                echo "<p><strong>Avg. Rating:</strong> " . round($row["avg_rating"], 1) . "</p>";
                echo "<img " src='" . $row["coverpage_link"] . "' alt='" . $row["book_name"] . "'>";
                echo "</div>";
            }
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
