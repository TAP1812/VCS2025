<h2>Student List</h2>

<?php if (empty($students)): ?>
    <p>No students found.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo (int)$student['student_id']; ?></td>
                    <td><?php echo escape_html_attr($student['username']); ?></td>
                    <td><?php echo escape_html_attr($student['first_name']); ?></td>
                    <td><?php echo escape_html_attr($student['last_name']); ?></td>
                    <td><?php echo escape_html_attr($student['email']); ?></td>
                    <td><?php echo escape_html_attr($student['role']); ?></td>
                    <td>
                        <a href="index.php?page=student_details&id=<?php echo (int)$student['student_id']; ?>">View</a>
                        <a href="index.php?page=student_edit&id=<?php echo (int)$student['student_id']; ?>">Edit</a>
                        <a href="index.php?page=student_delete&id=<?php echo (int)$student['student_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>