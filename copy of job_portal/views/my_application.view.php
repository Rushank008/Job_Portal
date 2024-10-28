<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="views/home.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="views/my_application.css"> <!-- Link to the external CSS file -->
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
                        <li><a href="#">Pending Applications</a></li>
                    <?php endif; ?>

                    <li><a href="/logout" class="btn">Logout</a></li>
                </ul>
            </nav>
        </header>

        <div class="container">
        <h1>My Applications</h1>

        <?php if (count($applications) > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Job Title</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Resume</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $application): ?>
                        <tr>
                            <td><?= htmlspecialchars($application['job_title']) ?></td>
                            <td><?= htmlspecialchars($application['company_name']) ?></td>
                            <td><?= htmlspecialchars($application['status']) ?></td>
                            <td>
                                <a href="/<?= htmlspecialchars($application['resume_path']) ?>" target="_blank">View Resume</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You haven't applied for any jobs yet.</p>
        <?php endif; ?>
    </div>


   
</body>
</html>