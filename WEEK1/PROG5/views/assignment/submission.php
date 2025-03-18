<h2>Submit Assignment</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<form action="index.php?page=submit_assignment&id=<?php echo (int)$assignment['assignment_id']; ?>" method="post" enctype="multipart/form-data">
    <label for="submission_file">Upload Submission:</label><br>
    <input type="file" id="submission_file" name="submission_file" required><br><br>

    <button type="submit">Submit</button>
</form>