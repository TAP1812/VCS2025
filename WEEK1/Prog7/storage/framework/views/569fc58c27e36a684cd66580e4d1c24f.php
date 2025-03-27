<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Submissions for: <?php echo e($assignment->title); ?></h1>
    
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Student Submissions</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Submitted At</th>
                        <th>File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($submission->student->fullname); ?></td>
                            <td><?php echo e($submission->created_at->diffForHumans()); ?></td>
                            <td>
                                <div class="text-center">
                                    <a href="<?php echo e(route('submissions.download', ['filePath' => str_replace('submissions/', '', $submission->file_path)])); ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/Prog7/resources/views/assignments/submissions.blade.php ENDPATH**/ ?>