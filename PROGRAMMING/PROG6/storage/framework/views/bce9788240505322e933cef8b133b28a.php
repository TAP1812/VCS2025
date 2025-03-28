<?php $__env->startSection('content'); ?>
<h1 class="mb-4">Assignments</h1>

<?php if(auth()->user()->isTeacher()): ?>
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Create Assignment</h5>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('assignments.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" class="form-control" name="file" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Assignment</button>
        </form>
    </div>
</div>
<?php endif; ?>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0">Assignments List</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($assignment->title); ?></td>
                        <td><?php echo e($assignment->description); ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?php echo e(route('assignments.download', ['filePath' => str_replace('assignments/', '', $assignment->file_path)])); ?>" 
                                   class="btn btn-primary btn-sm me-2">
                                    <i class="bi bi-download"></i> Download
                                </a>
                                <?php if(auth()->user()->isTeacher()): ?>
                                    <a href="<?php echo e(route('assignments.submissions', $assignment)); ?>" 
                                       class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-eye"></i> View Submissions
                                    </a>
                                <?php endif; ?>
                                <?php if(auth()->user()->isStudent()): ?>
                                    <button class="btn btn-success btn-sm me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#submitModal<?php echo e($assignment->id); ?>">
                                        <i class="bi bi-upload"></i> Submit
                                    </button>
                                    <a href="<?php echo e(route('assignments.my-submission', $assignment)); ?>" 
                                       class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-file-text"></i> My Submission
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    
                    <?php if(auth()->user()->isStudent()): ?>
                    <!-- Submit Modal -->
                    <div class="modal fade" id="submitModal<?php echo e($assignment->id); ?>" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="<?php echo e(route('assignments.submit', $assignment)); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="modal-header">
                                        <h5 class="modal-title">Submit Assignment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload File</label>
                                            <input type="file" class="form-control" name="file" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/PROG6/resources/views/assignments/index.blade.php ENDPATH**/ ?>