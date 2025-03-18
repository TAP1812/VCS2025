<h2>Inbox</h2>

<?php if (empty($messages)): ?>
    <p>No messages in your inbox.</p>
<?php else: ?>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li>
                <strong>From:</strong> <?php echo escape_html_attr($message['sender_name']); ?>
                <br>
                <?php echo escape_html_attr($message['message']); ?>
                <br>
                <a href="index.php?page=view_message&id=<?php echo (int)$message['message_id']; ?>">View</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="index.php?page=create_message">Create New Message</a>