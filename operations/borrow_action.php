<?php
// operations/borrow_action.php
// Handle book borrowing logic

include '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'])) {
    $book_id = (int)$_POST['book_id'];
    $user_id = $_SESSION['user_id'];

    // Check if book exists and is available
    $book_sql = "SELECT * FROM books WHERE id = $book_id AND available_qty > 0";
    $book_result = $conn->query($book_sql);

    if ($book_result->num_rows > 0) {
        $book = $book_result->fetch_assoc();

        // Calculate due date (14 days from now)
        $due_date = date('Y-m-d H:i:s', strtotime('+14 days'));

        // Insert transaction
        $insert_sql = "INSERT INTO transactions (user_id, book_id, borrow_date, due_date, status)
                       VALUES ($user_id, $book_id, NOW(), '$due_date', 'active')";

        if ($conn->query($insert_sql) === TRUE) {
            // Update book availability
            $update_sql = "UPDATE books SET available_qty = available_qty - 1 WHERE id = $book_id";
            $conn->query($update_sql);

            $_SESSION['success'] = "Book borrowed successfully! Due date: " . date('M d, Y', strtotime($due_date));
        } else {
            $_SESSION['error'] = "Error borrowing book: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Book is not available for borrowing.";
    }

    // Redirect back to book details
    header("Location: ../catalog/book_details.php?id=$book_id");
    exit();
} else {
    // Invalid request
    header("Location: ../index.php");
    exit();
}
?>
