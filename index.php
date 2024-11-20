<?php
session_start();
require_once('db.php');

// Fetch books
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

// Handle Create, Update, Delete operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $year = $_POST['year'];
        $genre = $_POST['genre'];

        $sql = "INSERT INTO books (title, author, year, genre) VALUES ('$title', '$author', '$year', '$genre')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        }
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM books WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bookstore</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1>Bookstore</h1>

<!-- Add new book form -->
<form method="POST">
    <input type="text" name="title" placeholder="Title" required>
    <input type="text" name="author" placeholder="Author" required>
    <input type="number" name="year" placeholder="Year" required>
    <input type="text" name="genre" placeholder="Genre" required>
    <button type="submit" name="create">Add Book</button>
</form>

<!-- Display books -->
<h2>Books List</h2>
<table>
    <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Actions</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['author']; ?></td>
        <td><?php echo $row['year']; ?></td>
        <td><?php echo $row['genre']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="index.php?delete=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
