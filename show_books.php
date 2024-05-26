<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Books</title>
    <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: burlywood;
            margin: 0;
            padding: 20px;
        }
        .books-container {
            display: flex;
            flex-wrap: wrap;
        }
        .book-item {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: calc(25% - 20px);
            margin-right: 20px;
            margin-bottom: 20px;
            padding: 20px;
            cursor: pointer;
            position: relative;
        }
        .book-item:last-child {
            margin-right: 0;
        }
        .book-info {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        .book-info h3, .book-info p {
            margin: 0;
        }
        .book-info img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        /* New CSS styles */
        $dark: #131325;
        body {
            background-color: $dark;
        }
        .flex-row {
            display: flex;
            flex-flow: row;
            align-items: center;
        }
        .flex-column {
            display: flex;
            flex-flow: column;
        }
        .center {
            align-items: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .list {
            border-radius: 3px;
            overflow: hidden;
        }
        .card {
            cursor: pointer;
            min-width: 700px;
            margin-bottom: 10px;
            perspective: 600px;
            transition: all 0.1s;
            background-color: lighten($dark, 8%);
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            height: 90px;
        }
        .card.open {
            padding: 30px;
            height: auto;
        }
        .card.open .bottom {
            margin-top: 10px;
            height: 100%;
            overflow: visible;
        }
        .card .book {
            transition: all 0.5s;
            width: 120px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        .card .info {
            transition: all 0.2s;
            min-width: 200px;
            padding: 0px 30px;
            font-family: 'Montserrat';
            font-weight: bold;
        }
        .card .info .title {
            font-size: 1em;
            color: #fff;
            letter-spacing: 1px;
        }
        .card .info .author {
            font-size: 12px;
            font-weight: normal;
            color: #888;
        }
        .card .group {
            margin-left: auto;
        }
        .card .members {
            padding: 40px;
            font-family: 'Montserrat';
            color:black;
            background-color: lighten($dark, 5%);
        }
        .card .members .current {
            font-weight: bold;
            margin-right: 10px;
        }
        .card .members .max {
            opacity: 0.5;
            margin-left: 10px;
        }
        .card .bottom {
            height: 0px;
            overflow: hidden;
            width: 200px;
            font-size: 12px;
            color: #777;
            font-weight: normal;
        }
        .card.open .book {
            transform: rotateY(50deg);
            box-shadow: -10px 10px 10px 2px rgba(0, 0, 0, 0.2), -2px 0px 0px 0px #888;
        }
        .card.open .info {
            transform: translate(0, -10px);
        }
        .card.open .members {
            padding: 15px 20px;
            border-radius: 4px;
            align-self: flex-start;
        }
        .card.open button.simple {
            cursor: pointer;
            color: #ccc;
            border: none;
            outline: none;
            border-radius: 4px;
            background-color: #1ea94b;
            padding: 15px 20px;
            font-family: 'Montserrat';
            font-weight: bold;
            transition: all 0.1s;
        }
        .card.open button.simple:hover {
            box-shadow: 0px 15px 20px -5px rgba(0, 0, 0, .3);
            transform: translate(0, -2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="center list flex-column">
            <?php
            // Get the category ID from the URL
            if (isset($_GET['category_id'])) {
                $category_id = $_GET['category_id'];
            } else {
                echo "Category ID not provided.";
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

            // Get books of the selected category
            $sql = "SELECT b.book_id, b.book_name, b.book_author, b.coverpage_link, AVG(c.rating) AS avg_rating
                    FROM books b
                    JOIN book_categories bc ON b.book_id = bc.book_id
                    JOIN comments c ON b.book_id = c.book_id
                    WHERE bc.category_id = '$category_id'
                    GROUP BY b.book_id, b.book_name, b.book_author, b.coverpage_link
                    ORDER BY b.book_name";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card flex-row'>";
                    echo "<img src='" . $row["coverpage_link"] . "' alt='" . $row["book_name"] . "' class='book'>";
                    echo "<div class='flex-column info'>";
                    echo "<div class='title'>" . $row["book_name"] . "</div>";
                    echo "<div class='author'>" . $row["book_author"] . "</div>";
                    echo "<div class='bottom hidden'>";
                    echo "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quod ratione impedit temporibus maiores autem aperiam assumenda exercitationem, quisquam nobis esse.";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='flex-column group'>";
                    echo "<div class='members'>";
                    echo round($row["avg_rating"], 1) . " ⭐";
                    echo "</div>";
                    echo "<div class='bottom hidden'>";
                    echo "<a href='book_info.php?book_id=" . $row["book_id"] . "' class='simple'>Read</a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No books found for this category.";
            }

            $conn->close();
            ?>
        </div>
    </div>
    <script>
        // Show book info on click
        const cardItems = document.querySelectorAll('.card');
        let old = null;
        cardItems.forEach(item => {
            item.addEventListener('click', function() {
                if (old !== null && old.classList.contains('open')) {
                    old.classList.remove('open');
                }
                this.classList.toggle('open');
                old = this;
            });
        });
    </script>
</body>
</html>