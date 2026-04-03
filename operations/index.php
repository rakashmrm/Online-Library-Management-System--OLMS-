<?php
// core/dashboard.php
// User dashboard showing borrowed books and account info

include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's active transactions
$borrowed_sql = "SELECT t.*, b.title, b.author, b.cover_image
                 FROM transactions t
                 JOIN books b ON t.book_id = b.id
                 WHERE t.user_id = $user_id AND t.status = 'active'
                 ORDER BY t.due_date ASC";
$borrowed_result = $conn->query($borrowed_sql);

// Fetch user's returned transactions (recent)
$returned_sql = "SELECT t.*, b.title, b.author
                 FROM transactions t
                 JOIN books b ON t.book_id = b.id
                 WHERE t.user_id = $user_id AND t.status = 'returned'
                 ORDER BY t.returned_date DESC LIMIT 5";
$returned_result = $conn->query($returned_sql);
?>

<div class="container my-4">
    <h1 class="display-4 fw-bold mb-4">📚 My Dashboard</h1>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Currently Borrowed Books -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📖 Currently Borrowed Books</h5>
        </div>
        <div class="card-body">
            <?php if ($borrowed_result->num_rows > 0): ?>
                <div class="row">
                    <?php while ($transaction = $borrowed_result->fetch_assoc()): ?>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex mb-3">
                                        <img src="../assets/images/<?php echo htmlspecialchars($transaction['cover_image']); ?>"
                                             class="me-3 rounded"
                                             alt="Cover"
                                             style="width: 60px; height: 80px; object-fit: cover;"
                                             onerror="this.src='../assets/images/default-cover.jpg'">
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1"><?php echo htmlspecialchars($transaction['title']); ?></h6>
                                            <p class="card-text small text-muted mb-1">by <?php echo htmlspecialchars($transaction['author']); ?></p>
                                            <p class="card-text small mb-0">
                                                <strong>Due:</strong> <?php echo date('M d, Y', strtotime($transaction['due_date'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <form action="../operations/return_action.php" method="POST" class="mt-auto">
                                        <input type="hidden" name="transaction_id" value="<?php echo $transaction['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-sm w-100"
                                                onclick="return confirm('Are you sure you want to return this book?')">
                                            🔄 Return Book
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <p class="text-muted mb-0">You haven't borrowed any books yet.</p>
                    <a href="../catalog/books.php" class="btn btn-primary mt-3">Browse Books</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Recently Returned Books -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">✅ Recently Returned Books</h5>
        </div>
        <div class="card-body">
            <?php if ($returned_result->num_rows > 0): ?>
                <div class="list-group list-group-flush">
                    <?php while ($transaction = $returned_result->fetch_assoc()): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?php echo htmlspecialchars($transaction['title']); ?></h6>
                                <p class="mb-0 small text-muted">
                                    Returned on <?php echo date('M d, Y', strtotime($transaction['returned_date'])); ?>
                                </p>
                            </div>
                            <span class="badge bg-success">Returned</span>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-muted mb-0">No returned books yet.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>