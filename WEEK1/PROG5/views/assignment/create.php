<h2>Create Assignment</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<form action="index.php?page=create_assignment" method="post" enctype="multipart/form-data">
    <label for="title">Title:</label><br>
    <input type="text" id="title" name="title" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description"></textarea><br><br>

    <label for="upload_file">Upload File:</label><br>
    <input type="file" id="upload_file" name="upload_file" required><br><br>

    <button type="submit">Create Assignment</button>
</form>