<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Users</h2>
    <div class="row">
        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo e($user->name); ?></h5>
                        <p class="card-text"><?php echo e($user->email); ?></p>
                        <a href="<?php echo e(route('users.show', $user)); ?>" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/Prog7/resources/views/dashboard/users/index.blade.php ENDPATH**/ ?>