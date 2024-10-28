<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Resume</title>
    <link rel="stylesheet" href="views/home.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="views/apply.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Job Portal</h1>
            <nav>
                <ul>
                    <li><a href="/home">Job Listings</a></li>
                    
                    <?php if ($_SESSION['user_type'] === 'employee'): ?>
                        <li><a href="/my_application">My applications</a></li>
                    <?php elseif ($_SESSION['user_type'] === 'company'): ?>
                        <li><a href="/add_job">Add Jobs</a></li>
                        <li><a href="/pending_application">Pending Applications</a></li>
                    <?php endif; ?>

                    <li><a href="/logout" class="btn">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="upload-form">
                <h2>Upload Your Resume</h2>

                <!-- Flash Message -->
                <?php if (isset($_SESSION['Flash'])): ?>
                    <div class="flash-message">
                        <?= htmlspecialchars($_SESSION['Flash']) ?>
                        <?php unset($_SESSION['Flash']); ?>
                    </div>
                <?php endif; ?>

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


        <form method="POST" action="/apply" enctype="multipart/form-data">
    <input type="file" name="cv" required>
    <button type="submit" name="upload">Upload</button>
</form>
            </section>
        </main>
    </div>
</body>
</html>
