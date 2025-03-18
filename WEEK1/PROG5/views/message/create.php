<h2>Create Message</h2>

<?php if (isset($error_message)): ?>
    <div class="error"><?php echo sanitize_input($error_message); ?></div>
<?php endif; ?>

<form action="index.php?page=create_message" method="post">
    <label for="receiver_id">To (Student ID):</label><br>
    <input type="number" id="receiver_id" name="receiver_id" required><br><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" required></textarea><br><br>

    <button type="submit">Send Message</button>
</form>