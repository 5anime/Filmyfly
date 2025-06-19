<?php
require_once '../config.php';

// Validate and sanitize the movie ID from the URL
$movie_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($movie_id <= 0) {
    echo "<p>Invalid movie ID.</p>";
    exit;
}

// Fetch the movie from the database
$stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>Movie not found.</p>";
    exit;
}

$movie = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9f9f9;
            line-height: 1.6;
            padding: 0;
        }

        .movie-container {
            max-width: unset;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
        }

        .center {
            text-align: center;
        }

        .cat {
            background: #fcfcfc;
            border-bottom: 1px #a29deb solid;
            padding: 12px 7px;
            font-size: 18px;
            font-weight: bold;
            color: #006699;
        }

        h2 {
            color: #ffffff;
            background: #006699;
            border: 1px solid rgb(170, 187, 204);
            font-size: 110%;
            padding: 5px;
            border-radius: 8px;
        }

        .cat:hover {
            background: #97aa99;
        }

        h3 {
            color: #fff;
            background: #006699;
            padding: 5px;
            border-radius: 8px;
        }

        .responsive-img {
            max-width: 100%;
            height: 320px;
            border-radius: 25px;
        }
        .responsive-baner {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .fname {
            border-bottom: 1px #ccc solid;
            padding: 7px;
            font-weight: bold;
            font-size: 14px;
        }

        .colora { color: red; }
        .colorb { color: #ff6600; }
        .colorc { color: #009900; }
        .colord { color: #0033cc; }
        .colore { color: #333300; }
        .colorf { color: #993333; }
        .colorg { color: #9933ff; }
        .colorh { color: #666666; }
        .colori { color: #ffffff; }
        .colorj {
            color: #1900ff;
            position: relative;
        }

        .dlbtn {
            text-align: center;
            border-radius: 20px;
            width: max-content;
            margin: 20px auto;
            background-color: #ff2323;
            padding: 7px;
        }

        .dlbtn a {
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            font-weight: 700;
            color: #fff;
            max-width: 100%;
            text-decoration: none;
            box-sizing: border-box;
        }

        .responsive-iframe {
            position: relative;
            width: 50%;
            padding-bottom: 28.125%;
            height: 0;
            margin: 0 auto;
            overflow: hidden;
            border-radius: 15px;
        }

        .responsive-iframe iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: 15px;
        }

        @media (max-width: 992px) {
            .responsive-iframe {
                width: 70%;
                padding-bottom: 40%;
            }
        }

        @media (max-width: 576px) {
            .responsive-iframe {
                width: 100%;
                padding-bottom: 56.25%;
            }
        }

        .image-left,
        .image-right {
            margin: 1em 0;
        }

        @media (min-width: 20em) {
            .image-left,
            .image-right {
                display: flex;
                align-items: center;
                padding: 12px;
                background: #ffffff;
            }

            .image-left:hover {
                background: #e0e0e0;
            }

            .image-left img {
                margin-right: 1em;
                float: left;
            }

            .image-right img {
                order: 1;
                margin-left: 1em;
                float: right;
                padding: 12px;
            }

            .image-left::after,
            .image-right::after {
                content: "";
                display: block;
                clear: both;
            }
        }

        @media (min-width: 50em) {
            .image-left img,
            .image-right img {
                flex-shrink: 0;
                width: 150px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
<?php include('./theme/header.php'); ?>

<div class="movie-container">
    <h2 class="center"><?php echo htmlspecialchars($movie['title']); ?></h2>

    <div class="center">
        <div class="movie-thumb">
            <img src="<?php echo htmlspecialchars($movie['main_image']); ?>" class="responsive-img" alt="<?php echo htmlspecialchars($movie['title']); ?>" />

            <h2><div class="colori">👉File Info👈</div></h2>

            <div class="fname">Name: <span class="colora"><?php echo htmlspecialchars($movie['title']); ?></span></div>
            <div class="fname">Genre: <span class="colorb"><?php echo htmlspecialchars($movie['genre']); ?></span></div>
            <div class="fname">Duration: <span class="colorc"><?php echo htmlspecialchars($movie['duration']); ?></span></div>
            <div class="fname">Release Date: <span class="colord"><?php echo htmlspecialchars($movie['release_date']); ?></span></div>
            <div class="fname">Language: <span class="colore"><?php echo htmlspecialchars($movie['language']); ?></span></div>
            <div class="fname">Starcast: <span class="colorf"><?php echo htmlspecialchars($movie['starcast']); ?></span></div>
            <div class="fname">Size: <span class="colorg"><?php echo htmlspecialchars($movie['size']); ?></span></div>
            <div class="fname">Description: <span class="colorh"><?php echo nl2br(htmlspecialchars($movie['description'])); ?></span></div>
        </div>
    </div>

    <h3 class="header4 center">Watch/Play</h3>
    <br>
    <div class="responsive-iframe">
        <iframe src="<?php echo htmlspecialchars($movie['embed_url']); ?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <br>
    <h3 class="header4 center">DOWNLOAD THIS MOVIE</h3>
    <div class="dlbtn">
        <a href="<?php echo htmlspecialchars($movie['download_link']); ?>" rel="nofollow" target="_blank">Download 480p 720p 1080p 2160p(4k) [HD]</a>
    </div>

    <h3 class="header4 center">SCREENSHOT</h3>
    <br>
    <div class="article center">
        <div class="ss">
            <img src="<?php echo htmlspecialchars($movie['screenshots']); ?>" class="responsive-baner" alt="<?php echo htmlspecialchars($movie['title']); ?>" />
        </div>
    </div>
</div>

</body>
</html>
