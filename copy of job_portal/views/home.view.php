<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="views/home.css"> <!-- Link to the external CSS file -->
</head>
<body>
    <div class="container">
        <header>
            <h1>Job Portal</h1>
            <nav>
                <ul>
                    <li><a href="#">Job Listings</a></li>
                    
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

                                                        <!-- Display Flash Messages -->
        <?php if (isset($_SESSION['Flash'])): ?>
            <div class="flash-message">
                <?php echo htmlspecialchars($_SESSION['Flash']); ?>
                <?php unset($_SESSION['Flash']); // Unset the flash message after displaying it ?>
            </div>
        <?php endif; ?>


            <section class="search-bar">
                <form method="GET" action="/home">
                    <input autocomplete= "off" type="text" name="search_query" placeholder="Search for companies" value = "<?= isset($_GET['search_query']) ? htmlspecialchars($_GET['search_query']) : '' ?>" >
                    <button type="submit">Search</button>
                </form>
            </section>

            <div class="job-listings">
                <?php if (empty($companies)): ?>
                    <p>No companies Found</p>
                <?php else: ?>
                    <div class="company-listings">
                        <?php foreach ($companies as $company): ?>
                            <div class="company-card">
                                <h3><?= htmlspecialchars($company['name']) ?></h3>
                                <p><?= htmlspecialchars($company['description']) ?></p>
                                <p><?= htmlspecialchars($company['email']) ?></p>
                                <a href="/jobs_by_company?company_id=<?= $company['id'] ?>" class="view-jobs-btn">View Jobs</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>