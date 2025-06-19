<?php
require_once 'config.php';

// Step 1: Get and sanitize the genre from the URL
$genre = isset($_GET['genre']) ? trim($_GET['genre']) : '';

if (empty($genre)) {
    echo "<p>Genre not specified.</p>";
    exit;
}

// Step 2: Prepare query to fetch movies by genre (using LIKE for flexibility)
$stmt = $conn->prepare("SELECT id, title, main_image FROM movies WHERE genre LIKE ?");
$search = '%' . $genre . '%';
$stmt->bind_param("s", $search);
$stmt->execute();
$result = $stmt->get_result();

// Step 3: Check if any movies are found
if ($result->num_rows === 0) {
    echo "<p>No movies found in the '" . htmlspecialchars($genre) . "' category.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($genre); ?> Movies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #006699;
            margin-bottom: 30px;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }

        .movie-item {
            background: #fff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .movie-item:hover {
            transform: scale(1.05);
        }

        .movie-item img {
            max-width: 100%;
            height: 270px;
            object-fit: cover;
            border-radius: 8px;
        }

        .movie-item h4 {
            margin: 10px 0 0;
            font-size: 16px;
            color: #333;
        }

        .movie-item a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>

<?php include('./theme/header.php'); ?>

<div class="container">
    <h2><?php echo htmlspecialchars($genre); ?> Movies</h2>

    <div class="movie-grid">
        <?php while ($movie = $result->fetch_assoc()): ?>
            <div class="movie-item">
                <a href="movie.php?id=<?php echo $movie['id']; ?>">
                    <img src="<?php echo htmlspecialchars($movie['main_image']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                    <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
