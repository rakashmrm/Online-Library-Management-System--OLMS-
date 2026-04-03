<?php 
include('../includes/db.php'); 
include('../includes/header.php');

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $title = $_POST['title'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $total_qty = $_POST['total_qty'];

    // Set available quantity = total initially
    $available_qty = $total_qty;

    $cover_image_path = "";

    // 🔥 1. FILE UPLOAD (PRIORITY)
    if(isset($_FILES['cover_file']) && $_FILES['cover_file']['name'] != ""){

        $file_name = time() . "_" . $_FILES['cover_file']['name']; // unique name
        $tmp_name = $_FILES['cover_file']['tmp_name'];
        $target_dir = "../assets/images/";
        $target_file = $target_dir . $file_name;

        if(move_uploaded_file($tmp_name, $target_file)){
            $cover_image_path = "assets/images/" . $file_name;
        }
    } 
    // 🔥 2. URL (fallback)
    else if(!empty($_POST['cover_image'])){
        $cover_image_path = $_POST['cover_image'];
    }

    // Insert into database
    $sql = "INSERT INTO books (title, author, category, cover_image, total_qty, available_qty)
            VALUES ('$title', '$author', '$category', '$cover_image_path', $total_qty, $available_qty)";

    if($conn->query($sql)){
        // Redirect to manage page so you can see it immediately
        header("Location: manage_books.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: ".$conn->error."</div>";
    }
}
?>

<style>
.input-hover {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.input-hover:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.input-hover:focus {
    border-color: #4e73df;
    box-shadow: 0 0 10px rgba(78, 115, 223, 0.5);
    transform: scale(1.02);
}
</style>

<div class="container mt-4">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Add New Book</h3>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label"><b>Book Title</b></label>
                <input type="text" name="title" class="form-control input-hover" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Author</b></label>
                <input type="text" name="author" class="form-control input-hover" required>
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Category</b></label>
                <input type="text" name="category" class="form-control input-hover">
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Cover Image</b></label>

                <!-- Upload File -->
                <input type="file" name="cover_file" class="form-control input-hover mb-2">

                <!-- OR URL -->
                <input type="text" name="cover_image" class="form-control input-hover" 
                       placeholder="Paste image URL here">

                <small class="text-muted">
                    Upload image (priority) or paste URL
                </small>
            </div>

            <div class="mb-3">
                <label class="form-label"><b>Total Quantity</b></label>
                <input type="number" name="total_qty" class="form-control input-hover" required>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Add Book
            </button>

        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>