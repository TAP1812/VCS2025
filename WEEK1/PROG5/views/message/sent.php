<h2>Sent Messages</h2>

<?php if (empty($messages)): ?>
    <p>No sent messages.</p>
<?php else: ?>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li>
                <strong>To:</strong> <?php echo escape_html_attr($message['receiver_name']); ?>
                <br>
                <?php echo escape_html_attr($message['message']); ?>
                <br>
                <a href="index.php?page=view_message&id=<?php echo (int)$message['message_id']; ?>">View</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="index.php?page=create_message">Create New Message</a>