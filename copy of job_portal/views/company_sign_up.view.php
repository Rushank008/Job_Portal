<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Sign Up</title>
    <link rel="stylesheet" href="views/sign_up.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="signup-container">
        <h2>Company Sign Up</h2>

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
            <label for="companyName">Company Name</label>
            <input autocomplete ="off" type="text" id="companyName" name="companyName" placeholder="Enter your company name" value="<?= isset($_POST['companyName']) ? $_POST['companyName'] : ''; ?>" required>

            <label for="email">Email</label>
            <input autocomplete ="off" type="email" id="email" name="email" placeholder="Enter your email" value="<?= isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" value="<?= isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>


            <label for="description">Company Description</label>
            <textarea id="description" name="description" placeholder="Describe your company" required><?= isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>

            <button type="submit">Sign Up</button>
        </form>

        <div class="options">
            <p>Or</p>
            <div class="links">
                <a href="/">Sign up as a Employee</a>
                <span>|</span>
                <a href="/login">Login</a>
    </div>
</body>
</html>
