<?php
// operations/submit_review.php
// Handle review submission logic

include '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['book_id'], $_POST['rating'], $_POST['comment'])) {
    $book_id = (int)$_POST['book_id'];
    $user_id = $_SESSION['user_id'];
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, trim($_POST['comment']));

    // Validate rating (1-5)
    if ($rating < 1 || $rating > 5) {
        $_SESSION['error'] = "Invalid rating. Please select a rating between 1 and 5.";
        header("Location: ../catalog/book_details.php?id=$book_id");
        exit();
    }

    // Check if book exists
    $book_check = $conn->query("SELECT id FROM books WHERE id = $book_id");
    if ($book_check->num_rows == 0) {
        $_SESSION['error'] = "Book not found.";
        header("Location: ../catalog/books.php");
        exit();
    }

    // Check if user already reviewed this book (optional: allow only one review per user per book)
    $existing_review = $conn->query("SELECT id FROM reviews WHERE book_id = $book_id AND user_id = $user_id");
    if ($existing_review->num_rows > 0) {
        $_SESSION['error'] = "You have already reviewed this book.";
        header("Location: ../catalog/book_details.php?id=$book_id");
        exit();
    }

    // Insert review
    $insert_sql = "INSERT INTO reviews (book_id, user_id, rating, comment, created_at)
                   VALUES ($book_id, $user_id, $rating, '$comment', NOW())";

    if ($conn->query($insert_sql) === TRUE) {
        $_SESSION['success'] = "Review submitted successfully!";
    } else {
        $_SESSION['error'] = "Error submitting review: " . $conn->error;
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
