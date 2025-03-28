<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <h1 class="mb-4">Challenges</h1>

    <?php if(auth()->user()->isTeacher()): ?>
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Create Challenge</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('challenges.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="hint" class="form-label">Hint</label>
                    <textarea class="form-control" name="hint" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Upload .txt file</label>
                    <input type="file" class="form-control" name="file" accept=".txt" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Challenge</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title mb-0">Challenges List</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Hint</th>
                        <th>Action</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($challenge->hint); ?></td>
                            <td>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#challengeModal<?php echo e($challenge->id); ?>">
                                    Solve
                                </button>
                            </td>
                            <td>
                                <span class="badge <?php echo e(isset($statuses[$challenge->id]) && $statuses[$challenge->id] === 'solved' ? 'bg-success' : 'bg-secondary'); ?>">
                                    <?php echo e($statuses[$challenge->id] ?? 'not solved'); ?>

                                </span>
                            </td>
                        </tr>
                        
                        <div class="modal fade" id="challengeModal<?php echo e($challenge->id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?php echo e(route('challenges.solve', $challenge)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Solve Challenge</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="answer" class="form-label">Your Answer</label>
                                                <input type="text" class="form-control" name="answer" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/PROG6/resources/views/challenges/index.blade.php ENDPATH**/ ?>