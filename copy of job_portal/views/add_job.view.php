<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job</title>
    <link rel="stylesheet" href="views/home.css"> <!-- Your CSS -->
    <link rel="stylesheet" href="views/add_job.css"> <!--hYour CSS -->
</head>
<body>
    <header>
    <h1>Job Portal</h1>
        <nav>
            <ul>
                <li><a href="/home">Job Listings</a></li>
                <li><a href="/add_job" >Add Job</a></li>
                <li><a href="/pending_application">Pending Job Requests</a></li>
                <li><a href="/logout" class="logout-btn">Logout</a></li>

            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="job-form-container">
            <h2>Add Job Listing</h2>

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


            <!-- Flash Message -->
            <?php if (isset($_SESSION['Flash'])): ?>
                <div class="flash-message">
                    <?= htmlspecialchars($_SESSION['Flash']) ?>
                    <?php unset($_SESSION['Flash']); ?>
                </div>
            <?php endif; ?>

            <form action="#" method="POST">
    <label for="job_title">Job Title</label>
    <input autocomplete="off" type="text" id="job_title" name="job_title" placeholder="Enter job title" required>

    <label for="job_description">Job Description</label>
    <textarea autocomplete="off" id="job_description" name="job_description" placeholder="Enter job description" required></textarea>

    <label for="job_category">Job Category</label>
    <input autocomplete="off" type="text" id="job_category" name="job_category" placeholder="Enter job category" required>

    <label for="job_location">Job Location</label>
    <input autocomplete="off" type="text" id="job_location" name="job_location" placeholder="Enter job location" required>

    <button type="submit">Add Job</button>
</form>

        </div>
    </main>


</body>
</html>
