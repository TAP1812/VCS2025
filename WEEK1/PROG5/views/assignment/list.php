<h2>Assignments</h2>

<?php if (empty($assignments)): ?>
    <p>No assignments found.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Uploaded By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $assignment): ?>
                <tr>
                    <td><?php echo (int)$assignment['assignment_id']; ?></td>
                    <td><?php echo escape_html_attr($assignment['title']); ?></td>
                    <td><?php echo escape_html_attr($assignment['description']); ?></td>
                    <td><?php echo escape_html_attr($assignment['teacher_name']); ?></td> <!-- Assuming you fetch the teacher's name -->
                    <td>
                        <a href="index.php?page=view_assignment&id=<?php echo (int)$assignment['assignment_id']; ?>">View</a>
                        <?php if($_SESSION['role'] == 'student'): ?>
                            <a href="index.php?page=submit_assignment&id=<?php echo (int)$assignment['assignment_id']; ?>">Submit</a>
                        <?php endif; ?>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>