<?php  
include '../config.php';  // Adjust path if needed

// Fetch all movies
$movies = [];
$result = $conn->query("SELECT id, title, main_image, genre, release_date, size, category, embed_url FROM movies ORDER BY id DESC");
if ($result) {
    $movies = $result->fetch_all(MYSQLI_ASSOC);
}

// Category color function
function getCategoryColor($category) {
    $colors = [
        'Hollywood Movies' => '#E53E3E',     // Red
        'Bollywood Movies' => '#D69E2E',     // Yellow
        'Tamil Dubbed' => '#3182CE',      // Blue
        'Horror' => '#9B2C2C',     // Dark Red
        'Romance' => '#ED64A6',    // Pink
        'Sci-Fi' => '#38B2AC',     // Teal
        'Animation' => '#805AD5',  // Purple
        'Thriller' => '#DD6B20',   // Orange
    ];
    return $colors[$category] ?? '#48BB78'; // default green
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Root API READY</title>
  <link rel="stylesheet" href="style.css" />
  <style>
:root {
  --primary-color: #5A67D8;
  --secondary-color: #48BB78;
  --background-color: #F7FAFC;
  --text-color: #2D3748;
  --header-bg: #FFFFFF;
  --footer-bg: #E2E8F0;
  --font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  --border-radius: 10px;
  --padding: 8px;
  --max-width: 1200px;
}
@media (prefers-color-scheme: dark) {
  :root {
    --primary-color: #434190;
    --secondary-color: #38A169;
    --background-color: #1A202C;
    --text-color: #EDF2F7;
    --header-bg: #2D3748;
    --footer-bg: #2C5282;
  }
}
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: var(--font-family);
  background-color: var(--background-color);
  color: var(--text-color);
  line-height: 1.6;
}
.container {
  max-width: var(--max-width);
  margin: 0 auto;
  padding: var(--padding);
}
main {
  padding: var(--padding);
  background: var(--header-bg);
  margin-top: 20px;
  border-radius: var(--border-radius);
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
footer {
  background-color: var(--footer-bg);
  text-align: center;
  padding: var(--padding);
  margin-top: 40px;
  font-size: 0.9rem;
  color: var(--text-color);
}
@media (min-width: 768px) {
  .flex {
    display: flex;
    gap: 20px;
  }
  main {
    flex: 3;
  }
  aside {
    flex: 1;
  }
}
.movie-card {
  display: flex;
  align-items: flex-start;
  background-color: var(--background-color);
  padding: 10px;
  border-radius: var(--border-radius);
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  gap: 15px;
  margin-bottom: 15px;
  max-width: none;
}
.movie-thumb {
  width: 60px;
  height: 65px;
  object-fit: cover;
  border-radius: 5px;
}
.movie-info {
  flex: 1;
}
.movie-title {
  font-size: 15px;
  font-weight: 900;
  color: var(--text-color);
  text-decoration: none;
  display: block;
  margin-bottom: 6px;
  transition: color 0.3s ease;
}
.movie-title:hover {
  text-decoration: underline;
  color: var(--primary-color);
}
.movie-tag {
  display: inline-block;
  color: white;
  font-size: 10px;
  font-weight: bold;
  padding: 2px 8px;
  border-radius: 12px;
  margin-right: 5px;
  margin-top: 5px;
}
</style>
</head>
<body>

  <?php include('./theme/header.php'); ?>

  <div class="container flex">
    <main> 
      <?php if (!empty($movies)): ?>
        <?php foreach ($movies as $movie): ?>
          <div class="movie-card">
            <a href="movie.php?id=<?= urlencode($movie['id']) ?>" 
               title="<?= htmlspecialchars($movie['title'] ?: 'Movie Page') ?>">
              <img 
                src="<?= htmlspecialchars($movie['main_image'] ?: 'default.jpg') ?>" 
                alt="<?= htmlspecialchars($movie['title'] ?: 'Movie thumbnail') ?>" 
                class="movie-thumb">
            </a>

            <div class="movie-info">
              <a href="movie.php?id=<?= urlencode($movie['id']) ?>" 
                 class="movie-title" 
                 title="<?= htmlspecialchars($movie['title'] ?: 'Movie Title') ?>">
                <?= htmlspecialchars($movie['title']) ?>
              </a>

              <?php if (!empty($movie['category'])): ?>
                <?php
                  $categories = explode(',', $movie['category']);
                  foreach ($categories as $cat):
                    $cat = trim($cat);
                ?>
                  <div class="movie-tag" style="background-color: <?= getCategoryColor($cat) ?>;">
                    <?= htmlspecialchars($cat) ?>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <div class="movie-tag" style="background-color: gray;">Genre: Unknown</div>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No movies found.</p>
      <?php endif; ?>
    </main>
  </div>

  <footer>
    <p>&copy; 2025 My Website</p>
  </footer>
</body>
</html>
