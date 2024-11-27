<?php
session_start();
require 'db.php';

$movie_id = $_GET['id'];

// Fetch movie details
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$movie = $stmt->get_result()->fetch_assoc();

// Handle adding, editing, and deleting reviews
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if (isset($_POST['add_review'])) {
        // Add a new review
        $review_text = $_POST['review_text'];
        $rating = $_POST['rating'];

        $sql = "INSERT INTO reviews (user_id, movie_id, review_text, rating) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $user_id, $movie_id, $review_text, $rating);
        $stmt->execute();
    } elseif (isset($_POST['edit_review'])) {
        // Edit an existing review
        $review_id = $_POST['review_id'];
        $review_text = $_POST['review_text'];
        $rating = $_POST['rating'];

        $sql = "UPDATE reviews SET review_text = ?, rating = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("siii", $review_text, $rating, $review_id, $user_id);
        $stmt->execute();
    } elseif (isset($_POST['delete_review'])) {
        // Delete an existing review
        $review_id = $_POST['review_id'];

        $sql = "DELETE FROM reviews WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $review_id, $user_id);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $movie['title']; ?> - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Dark theme styling */
        body {
            background-color: #121212;
            color: white;
        }
        header {
            background-color: #1a1a1a;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .container {
            margin-top: 20px;
        }
        .movie-details, .add-review, .reviews {
            background-color: #1e1e1e;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .movie-details p {
            color: #aaa;
        }
        .review {
            background-color: #333;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }
        .form-control, .form-select {
            background-color: #2c2c2c;
            border: 1px solid #444;
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            background-color: #3a3a3a;
        }
        .navbar {
            background-color: #1a1a1a;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }
        .navbar a:hover {
            color: #00bcd4;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }
        .navbar ul li {
            margin-left: 15px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <a href="index.php" class="logo">Movies Review</a>
    <ul>
        <li><a href="index.php">Home</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>

<header>
    <h1><?php echo $movie['title']; ?></h1>
</header>

<div class="container">
    <div class="movie-details">
        <h2><?php echo $movie['title']; ?></h2>
        <p><?php echo $movie['description']; ?></p>
        <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
        <p><strong>Release Year:</strong> <?php echo $movie['release_year']; ?></p>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="add-review">
            <h3>Add a Review</h3>
            <form action="movie_details.php?id=<?php echo $movie_id; ?>" method="POST">
                <div class="mb-3">
                    <textarea name="review_text" class="form-control" placeholder="Write a review..." required></textarea>
                </div>
                <div class="mb-3">
                    <select name="rating" class="form-select" required>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <button type="submit" name="add_review">Submit Review</button>
            </form>
        </div>
    <?php else: ?>
        <p class="text-center mt-4">Please <a href="login.php" class="text-primary">login</a> to add a review.</p>
    <?php endif; ?>

    <div class="reviews">
        <h3>Reviews</h3>
        <?php
        $sql = "SELECT r.id as review_id, r.review_text, r.rating, u.username, r.user_id FROM reviews r JOIN users u ON r.user_id = u.id WHERE r.movie_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        $reviews = $stmt->get_result();
        while ($review = $reviews->fetch_assoc()):
        ?>
            <div class="review">
                <p>
                    <strong><?php echo $review['username']; ?>:</strong>
                    <?php echo $review['review_text']; ?> (<?php echo $review['rating']; ?> Stars)
                </p>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
                    <form action="movie_details.php?id=<?php echo $movie_id; ?>" method="POST" class="d-inline">
                        <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                        <textarea name="review_text" class="form-control d-inline w-50" required><?php echo $review['review_text']; ?></textarea>
                        <select name="rating" class="form-select d-inline w-25" required>
                            <option value="1" <?php if ($review['rating'] == 1) echo 'selected'; ?>>1 Star</option>
                            <option value="2" <?php if ($review['rating'] == 2) echo 'selected'; ?>>2 Stars</option>
                            <option value="3" <?php if ($review['rating'] == 3) echo 'selected'; ?>>3 Stars</option>
                            <option value="4" <?php if ($review['rating'] == 4) echo 'selected'; ?>>4 Stars</option>
                            <option value="5" <?php if ($review['rating'] == 5) echo 'selected'; ?>>5 Stars</option>
                        </select>
                        <button type="submit" name="edit_review" class="btn btn-primary">Save</button>
                    </form>
                    <form action="movie_details.php?id=<?php echo $movie_id; ?>" method="POST" class="d-inline">
                        <input type="hidden" name="review_id" value="<?php echo $review['review_id']; ?>">
                        <button type="submit" name="delete_review" class="btn btn-danger">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
