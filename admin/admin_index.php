<?php include('../includes/header.php'); ?>

<style>
.card-hover {
    transition: all 0.3s ease;
    cursor: pointer;
}

.card-hover:hover {
    transform: translateY(-10px); /* move up */
    box-shadow: 0 10px 25px rgba(0,0,0,0.3); /* stronger shadow */
}
</style>

<div class="container mt-4">

    <div class="p-5 rounded shadow text-white" 
         style="background: linear-gradient(135deg, #4e73df, #224abe);">

        <h1 class="fw-bold">📊 Admin Dashboard</h1>

        <p class="mt-2">
            Manage your library system efficiently. Add, update, and monitor books easily.
        </p>

    </div>

    <div class="row g-4 mt-4">

        <!-- Add Book -->
        <div class="col-md-4">
            <div class="card card-hover shadow text-center p-4">
                <h4>➕ Add Book</h4>
                <p>Add new books to library</p>
                <a href="add_books.php" class="btn btn-success">Go</a>
            </div>
        </div>

        <!-- Manage Books -->
        <div class="col-md-4">
            <div class="card card-hover shadow text-center p-4">
                <h4>📚 Manage Books</h4>
                <p>Edit or delete books</p>
                <a href="manage_books.php" class="btn btn-primary">Go</a>
            </div>
        </div>

        <!-- Reports -->
        <div class="col-md-4">
            <div class="card shadow text-center p-4">
                <h4>📈 Reports</h4>
                <p>View library activity</p>
                <button class="btn btn-secondary">Coming Soon</button>
            </div>
        </div>

    </div>

</div>


<?php include('../includes/footer.php'); ?>