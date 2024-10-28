<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal</title>
    <link rel="stylesheet" href="views/home.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="views/pending_application.css"> <!-- Link to the external CSS file -->
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

        <div class="container">
    <h1>Pending Applications</h1>

    <?php if (isset($_SESSION['Flash'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['Flash']); ?>
            <?php unset($_SESSION['Flash']); // Clear the message after displaying ?>
        </div>
    <?php endif; ?>

    <?php if (count($pending_applications) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Applicant</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pending_applications as $application): ?>
                    <tr>
                        <td><?= htmlspecialchars($application['job_title']) ?></td>
                        <td><?= htmlspecialchars($application['applicant_username']) ?></td>
                        <td><a href="/<?= htmlspecialchars($application['resume_path']) ?>" target="_blank">View Resume</a></td>
                        <td><?= htmlspecialchars($application['status']) ?></td>
                        <td>
                            <form method="POST" action="/pending_application">
                                <input type="hidden" name="application_id" value="<?= $application['application_id'] ?>">
                                <button type="submit" name="action" value="accept">Accept</button>
                                <button type="submit" name="action" value="reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No pending applications found.</p>
    <?php endif; ?>
</div>

 </div>
       
</body>
</html>