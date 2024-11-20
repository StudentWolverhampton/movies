<?php
// Database connection
$servername = "mi-linux.wlv.ac.uk";  // or the appropriate host, like "mi-linux.wlv.ac.uk"
$username = "2332829";      // Your MySQL username
$password = "ogbudatop1hvhboy1337$";  // Your MySQL password
$dbname = "movies";         // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch movie data
$sql = "SELECT Movie_name, Genre, Price, Date_of_release FROM movies";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie List</title>
</head>
<body>
    <h1>Movie List</h1>

    <?php
    // Check if there are results
    if ($result->num_rows > 0) {
        // Start of the table
        echo "<table border='1'>
                <tr>
                    <th>Movie Name</th>
                    <th>Genre</th>
                    <th>Price</th>
                    <th>Date of Release</th>
                </tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["Movie_name"] . "</td>
                    <td>" . $row["Genre"] . "</td>
                    <td>£" . number_format($row["Price"], 2) . "</td>  <!-- Format the price -->
                    <td>" . $row["Date_of_release"] . "</td>
                  </tr>";
        }

        // End of the table
        echo "</table>";
    } else {
        echo "No movies found.";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
