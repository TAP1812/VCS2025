<h2>Create Challenge</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<form action="index.php?page=create_challenge" method="post" enctype="multipart/form-data">
    <label for="challenge_file">Challenge File (TXT):</label><br>
    <input type="file" id="challenge_file" name="challenge_file" accept=".txt" required><br><br>

    <label for="hint">Hint:</label><br>
    <textarea id="hint" name="hint"></textarea><br><br>

    <button type="submit">Create Challenge</button>
</form>