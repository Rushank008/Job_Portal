<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs at company </title>
    <link rel="stylesheet" href="views/jobs_by_company.css"> <!-- Link to CSS -->
    <link rel="stylesheet" href="views/home.css">
</head>
<body>
    <div class="container">
        <header>
        <h1>Job Portal</h1>
            <nav>
                <ul>
                <li><a href="/home">Job Listings</a></li>
                    
                    <?php if ($_SESSION['user_type'] === 'employee'): ?>
                        <li><a href="#">My applications</a></li>
                    <?php elseif ($_SESSION['user_type'] === 'company'): ?>
                        <li><a href="/add_job">Add Jobs</a></li>
                        <li><a href="#">Pending Applications</a></li>
                    <?php endif; ?>

                    <li><a href="/logout" class="btn">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>

                                <!-- Display Flash Messages -->
        <?php if (isset($_SESSION['Flash'])): ?>
            <div class="flash-message">
                <?php echo htmlspecialchars($_SESSION['Flash']); ?>
                <?php unset($_SESSION['Flash']); // Unset the flash message after displaying it ?>
            </div>
        <?php endif; ?>


            <div class="job-listings">
                <?php if (empty($jobs)): ?>
                    <p>No jobs available for this company at the moment.</p>
                <?php else: ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-card">
                            <h3><?= htmlspecialchars($job['title']) ?></h3>
                            <p><strong>Category:</strong> <?= htmlspecialchars($job['category']) ?></p>
                            <p><strong>Description:</strong> <?= htmlspecialchars($job['description']) ?></p>
                            <p><strong>Location:</strong> <?=htmlspecialchars($job['location']) ?></p>

                            <?php if($_SESSION['user_type'] == 'company' && $job['company_id'] == $_SESSION['company_id']) : ?>
    <a href="/delete_job?id=<?= $job['id'] ?>" class="delete-icon" onclick="return confirm('Are you sure you want to delete this Job?');">🗑️</a>
<?php endif; ?>


                            <?php if($_SESSION['user_type'] == 'employee') : ?>
                            <form method="POST" action="/apply">
                                <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                                <button type="submit">Apply</button>
                            </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
