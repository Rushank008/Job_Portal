<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Login</title>
    <link rel="stylesheet" href="views/sign_up.css"> <!-- Link to the same CSS file used for signup -->
</head>
<body>
    <div class="signup-container"> <!-- Use the same class for consistent styling -->
        <h2>Company Login</h2>

        <!-- Display Error Messages -->
        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Display Flash Messages -->
        <?php if (isset($_SESSION['Flash'])): ?>
            <div class="flash-message">
                <?php echo htmlspecialchars($_SESSION['Flash']); ?>
                <?php unset($_SESSION['Flash']); // Unset the flash message after displaying it ?>
            </div>
        <?php endif; ?>

        <form action="#" method="POST">
            <label for="company-name">Company Name</label>
            <input autocomplete="off" type="text" id="companyName" name="companyName" placeholder="Enter your company name" value="<?= isset($_POST['companyName']) ? $_POST['companyName'] : ''; ?>" required>

            <label for="email">Email</label>
            <input autocomplete="off" type="email" id="email" name="email" placeholder="Enter your email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>

            <button type="submit">Login</button>
        </form>

        <div class="links">
            <p>Don't have an account? <br> <a href="/login">Login as an Employee</a> | <a href="/">Sign Up</a></p>
        </div>
    </div>
</body>
</html>

