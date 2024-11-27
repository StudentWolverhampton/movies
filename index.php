<?php
session_start();
require 'db.php';
include __DIR__ . '/header.php'; // Include the header with navbar and logout button

// Get the search query from the URL parameters
$query = isset($_GET['query']) ? $_GET['query'] : '';  

// Prepare and execute the SQL query to fetch movies
$sql = "SELECT * FROM movies WHERE title LIKE ? OR genre LIKE ? OR release_year LIKE ?";
$stmt = $conn->prepare($sql);
$search = "%$query%";
$stmt->bind_param("sss", $search, $search, $search);
$stmt->execute();
$result = $stmt->get_result();
?>

<!-- Full-page background fix -->
<style>
    /* Reset margin and padding for html and body */
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    /* Make the main container cover full height */
    .full-page {
        background-color: #121212;
        color: #fff;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Make the footer stay at the bottom */
    footer {
        margin-top: auto;
        padding: 10px 0;
        background-color: #1e1e1e;
        color: #fff;
        text-align: center;
    }
</style>

<div class="full-page">
    <div class="container mt-4" style="background-color: #121212; color: #fff; padding: 20px; border-radius: 10px;">
        <!-- Search Bar -->
        <form action="index.php" method="GET" class="mb-4">
            <div class="input-group">
                <input 
                    type="text" 
                    name="query" 
                    class="form-control" 
                    placeholder="Search movies..." 
                    value="<?php echo htmlspecialchars($query); ?>" 
                    style="background-color: #1e1e1e; color: #fff; border: 1px solid #444;"
                >
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Movies Grid -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($movie = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card" style="background-color: #1e1e1e; color: #fff; border: 1px solid #444;">
                            <!-- Dynamically display movie image -->
                            <img 
                                src="<?php echo !empty($movie['image_url']) ? $movie['image_url'] : 'assets/images/default-image.jpg'; ?>" 
                                class="card-img-top" 
                                alt="<?php echo $movie['title']; ?>" 
                                style="height: 250px; object-fit: cover;"
                            >
                            <div class="card-body">
                                <h5 class="card-title" style="color: #00bcd4;"><?php echo $movie['title']; ?></h5>
                                <p class="card-text">
                                    <?php echo substr($movie['description'], 0, 100); ?>...
                                </p>
                                <a href="movie_details.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center" style="color: #aaa;">No movies found for "<?php echo htmlspecialchars($query); ?>"</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/footer.php'; // Include footer ?>
</div>