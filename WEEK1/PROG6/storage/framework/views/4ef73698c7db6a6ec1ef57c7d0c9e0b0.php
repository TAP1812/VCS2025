<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="mb-4">My Submission for: <?php echo e($assignment->title); ?></h1>
    
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Submission Details</h5>
        </div>
        <div class="card-body">
            <?php if($submission): ?>
                <div class="mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-3">Current Submission</h6>
                            <p class="mb-2"><strong>Submitted:</strong> <?php echo e($submission->created_at->diffForHumans()); ?></p>
                            <p class="mb-3"><strong>Last Updated:</strong> <?php echo e($submission->updated_at->diffForHumans()); ?></p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <a href="<?php echo e(route('submissions.download', ['filePath' => str_replace('submissions/', '', $submission->file_path)])); ?>" 
                               class="btn btn-primary">
                                <i class="bi bi-download"></i> Download Current Submission
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <form action="<?php echo e(route('submissions.update', $submission)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="file" class="form-label fw-bold">Update Submission</label>
                        <input type="file" class="form-control" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-arrow-up-circle"></i> Update Submission
                    </button>
                </form>
            <?php else: ?>
                <p>You haven't submitted anything for this assignment yet.</p>
                <a href="<?php echo e(route('assignments.index')); ?>" class="btn btn-primary">Go Back to Assignments</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/Prog7/resources/views/assignments/my-submission.blade.php ENDPATH**/ ?>