<h2>Challenge</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<?php if (isset($challenge)): ?>
    <p><strong>Hint:</strong> <?php echo escape_html_attr($challenge['hint']); ?></p>

    <form action="index.php?page=view_challenge&id=<?php echo (int)$challenge['challenge_id']; ?>" method="post">
        <label for="answer">Answer (Filename):</label><br>
        <input type="text" id="answer" name="answer" required><br><br>

        <button type="submit">Submit Answer</button>
    </form>

    <?php if (isset($result_message)): ?>
        <div class="<?php echo (isset($is_correct) && $is_correct) ? 'success' : 'error'; ?>">
            <?php echo sanitize_input($result_message); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($poem)): ?>
        <h3>Poem:</h3>
        <pre><?php echo escape_html_attr($poem); ?></pre>
    <?php endif; ?>
<?php else: ?>
    <p>Challenge not found.</p>
<?php endif; ?>