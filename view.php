<?php 
include 'config.php';

// Search value
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Pagination setup
$limit = 5; // entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total records for pagination
$count_sql = "SELECT COUNT(*) as total FROM entries WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$count_result = $conn->query($count_sql);
$total_entries = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_entries / $limit);

// Fetch actual data with limit and offset
$sql = "SELECT * FROM entries 
        WHERE name LIKE '%$search%' OR email LIKE '%$search%' 
        ORDER BY id DESC 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?> 

<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="UTF-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>View Entries - Your Project Title</title> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
</head> 

<body> 
<div class="container mt-5"> 
    <h2>All Entries</h2> 

    <!-- Search Form -->
    <form method="GET" class="mb-3"> 
        <input type="text" name="search" class="form-control" placeholder="Search by Name or Email" value="<?= htmlspecialchars($search); ?>"> 
    </form>

    <!-- Entries Table -->
    <table class="table table-bordered table-striped table-hover"> 
        <thead class="table-dark"> 
            <tr> 
                <th>ID</th> 
                <th>Name</th> 
                <th>Email</th> 
                <th>Phone</th> 
                <th>Created At</th> 
            </tr> 
        </thead> 
        <tbody> 
            <?php 
            if ($result->num_rows > 0) { 
                while($row = $result->fetch_assoc()) { 
                    echo "<tr> 
                        <td>{$row['id']}</td> 
                        <td>".htmlspecialchars($row['name'])."</td> 
                        <td>".htmlspecialchars($row['email'])."</td> 
                        <td>".htmlspecialchars($row['phone'])."</td> 
                        <td>{$row['created_at']}</td> 
                    </tr>"; 
                } 
            } else { 
                echo "<tr><td colspan='5'>No entries found</td></tr>"; 
            } 
            ?> 
        </tbody> 
    </table> 

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <nav>
        <ul class="pagination">
            <!-- Previous Button -->
            <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?search=<?= urlencode($search); ?>&page=<?= $page - 1; ?>">Previous</a>
            </li>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?search=<?= urlencode($search); ?>&page=<?= $i; ?>"><?= $i; ?></a>
            </li>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?search=<?= urlencode($search); ?>&page=<?= $page + 1; ?>">Next</a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php endif; ?>

</div> 
</body> 
</html>
