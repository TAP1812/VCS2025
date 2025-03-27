<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle mb-3">
                            <span class="avatar-text"><?php echo e(substr($user->username, 0, 1)); ?></span>
                        </div>
                        <h2 class="fw-bold text-primary"><?php echo e($user->username); ?>'s Profile</h2>
                    </div>
                    <div class="profile-info">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <p class="mb-0"><?php echo e($user->email); ?></p>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tag text-primary me-2"></i>
                            <p class="mb-0"><?php echo e($user->role); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title fw-bold mb-3">Send Message</h3>
                    <form action="<?php echo e(route('messages.store', $user)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <textarea name="message" class="form-control" rows="3" 
                                placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Messages with <?php echo e($user->username); ?></h3>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                            <i class="bi bi-plus-lg"></i> New Message
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="messages-list">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="message-item mb-3 <?php echo e($message->sender_id === auth()->id() ? 'text-end' : ''); ?>">
                                <div class="card d-inline-block <?php echo e($message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light'); ?>" style="max-width: 80%;">
                                    <div class="card-body p-2">
                                        <p class="mb-1"><?php echo e($message->message); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-<?php echo e($message->sender_id === auth()->id() ? 'light' : 'muted'); ?>">
                                                <?php echo e($message->created_at->diffForHumans()); ?>

                                            </small>
                                            <?php if($message->sender_id === auth()->id()): ?>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editMessageModal<?php echo e($message->id); ?>">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="<?php echo e(route('messages.destroy', $message)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-light btn-sm" onclick="return confirm('Delete this message?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if($message->sender_id === auth()->id()): ?>
                                <!-- Edit Message Modal -->
                                <div class="modal fade" id="editMessageModal<?php echo e($message->id); ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="<?php echo e(route('messages.update', $message)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Message</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <textarea name="message" class="form-control" rows="3" required><?php echo e($message->message); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center text-muted">
                                <p>No messages yet. Start a conversation!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Message Modal -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('messages.store', $user)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Send New Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <textarea name="message" class="form-control" rows="3" placeholder="Type your message here..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 100px;
    height: 100px;
    background-color: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
.avatar-text {
    color: white;
    font-size: 40px;
    font-weight: bold;
}
.profile-info {
    max-width: 400px;
    margin: 0 auto;
}
.messages-list {
    max-height: 500px;
    overflow-y: auto;
}
.message-item {
    animation: fadeIn 0.3s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/Prog7/resources/views/dashboard/users/show.blade.php ENDPATH**/ ?>