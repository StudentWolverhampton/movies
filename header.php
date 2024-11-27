<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Navbar styles */
        .navbar {
            background-color: #1a1a1a; /* Dark background for navbar */
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* Logo styling */
        .navbar .logo {
            color: #00bcd4; /* Highlighted logo */
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
        }
        .navbar .logo:hover {
            color: #0097a7; /* Hover effect for logo */
        }

        /* Navigation links */
        .navbar ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
        }

        .navbar ul li {
            margin-left: 15px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            padding: 8px 12px;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .navbar a:hover {
            color: #00bcd4;
            background-color: rgba(0, 188, 212, 0.1); /* Subtle hover background */
            border-radius: 5px;
        }

        /* Logout button styling */
        .logout-btn {
            color: white;
            background-color: #d9534f; /* Red logout button */
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .logout-btn:hover {
            background-color: #c9302c; /* Darker red on hover */
            transform: scale(1.05); /* Slight zoom on hover */
            color: white;
        }

        /* Responsive navbar */
        @media (max-width: 768px) {
            .navbar ul {
                flex-direction: column;
                align-items: flex-start;
            }
            .navbar ul li {
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <!-- Logo -->
        <a href="index.php" class="logo">Movies Review</a>
        
        <!-- Navigation Links -->
        <ul>
            <li><a href="index.php">Home</a></li>
            <!-- Conditional rendering for authentication links -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <a href="logout.php" class="logout-btn">Logout</a>
                </li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
