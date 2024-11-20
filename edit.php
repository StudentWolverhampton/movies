<?php
session_start();
require_once('db.php');

// Get book ID
$id = $_GET['id'];
$sql = "SELECT * FROM books WHERE id = $id";
$result = $conn->query($sql);
$book = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];

    $sql = "UPDATE books SET title = '$title', author = '$author', year = '$year', genre = '$genre' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
</head>
<body>

<h1>Edit Book</h1>

<!-- Edit form -->
<form method="POST">
    <input type="text" name="title" value="<?php echo $book['title']; ?>" required>
    <input type="text" name="author" value="<?php echo $book['author']; ?>" required>
    <input type="number" name="year" value="<?php echo $book['year']; ?>" required>
    <input type="text" name="genre" value="<?php echo $book['genre']; ?>" required>
    <button type="submit">Update Book</button>
</form>

</body>
</html>
