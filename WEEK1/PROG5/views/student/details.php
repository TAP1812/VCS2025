<h2>Student Details</h2>

<?php if (isset($student)): ?>
    <p><strong>ID:</strong> <?php echo (int)$student['student_id']; ?></p>
    <p><strong>Username:</strong> <?php echo escape_html_attr($student['username']); ?></p>
    <p><strong>First Name:</strong> <?php echo escape_html_attr($student['first_name']); ?></p>
    <p><strong>Last Name:</strong> <?php echo escape_html_attr($student['last_name']); ?></p>
    <p><strong>Email:</strong> <?php echo escape_html_attr($student['email']); ?></p>
    <p><strong>Phone:</strong> <?php echo escape_html_attr($student['phone']); ?></p>
    <p><strong>Role:</strong> <?php echo escape_html_attr($student['role']); ?></p>

    <a href="index.php?page=student_edit&id=<?php echo (int)$student['student_id']; ?>">Edit</a>
<?php else: ?>
    <p>Student not found.</p>
<?php endif; ?>