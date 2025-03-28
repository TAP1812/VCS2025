<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-body text-center">
                    <?php if($user->avatar): ?>
                        <div class="avatar-circle mb-4 mx-auto overflow-hidden" style="width: 150px; height: 150px;">
                            <img src="<?php echo e(filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : ($user->avatar ? Storage::url($user->avatar) : 'https://via.placeholder.com/150')); ?>" alt="<?php echo e($user->username); ?>" 
                                 class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    <?php else: ?>
                        <div class="avatar-circle mb-4 mx-auto" style="width: 150px; height: 150px;">
                            <span class="avatar-text" style="font-size: 60px;"><?php echo e(substr($user->username, 0, 1)); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <h2 class="fw-bold mb-3"><?php echo e($user->fullname ?? $user->username); ?></h2>
                    <span class="badge bg-<?php echo e($user->role === 'admin' ? 'danger' : 'primary'); ?> mb-3">
                        <?php echo e(ucfirst($user->role)); ?>

                    </span>
                    
                    <div class="profile-details text-start mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Username</small>
                                <strong><?php echo e($user->username); ?></strong>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <strong><?php echo e($user->email); ?></strong>
                            </div>
                        </div>
                        
                        <?php if($user->phone): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Phone</small>
                                <strong><?php echo e($user->phone); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($user->fullname): ?>
                        <div class="d-flex align-items-center">
                            <div>
                                <small class="text-muted d-block">Full Name</small>
                                <strong><?php echo e($user->fullname); ?></strong>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
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

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Messages with <?php echo e($user->username); ?></h3>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                            <i class="fas fa-plus me-1"></i> New Message
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="messages-list">
                        <?php $__empty_1 = true; $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="message-item mb-3 <?php echo e($message->sender_id === auth()->id() ? 'text-end' : ''); ?>">
                                <div class="card d-inline-block <?php echo e($message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light'); ?>" style="max-width: 80%;">
                                    <div class="card-body p-3">
                                        <p class="mb-1"><?php echo e($message->message); ?></p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-<?php echo e($message->sender_id === auth()->id() ? 'light' : 'muted'); ?>">
                                                <?php echo e($message->created_at->diffForHumans()); ?>

                                            </small>
                                            <?php if($message->sender_id === auth()->id()): ?>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-<?php echo e($message->sender_id === auth()->id() ? 'light' : 'secondary'); ?> btn-sm" 
                                                            data-bs-toggle="modal" data-bs-target="#editMessageModal<?php echo e($message->id); ?>">Update
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="<?php echo e(route('messages.destroy', $message)); ?>" method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-<?php echo e($message->sender_id === auth()->id() ? 'light' : 'secondary'); ?> btn-sm" 
                                                                onclick="return confirm('Delete this message?')">Delete
                                                            <i class="fas fa-trash"></i>
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
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-comment-slash fa-3x mb-3"></i>
                                <p class="h5">No messages yet. Start a conversation!</p>
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
    background: linear-gradient(135deg, #0061f2 0%, #6e00ff 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}
.icon-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.profile-details {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
}
.messages-list {
    max-height: 500px;
    overflow-y: auto;
    padding: 15px;
}
.message-item {
    animation: fadeIn 0.3s ease-in;
    margin-bottom: 15px;
}
.message-item .card {
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
.card {
    border: none;
    border-radius: 12px;
    transition: all 0.3s ease;
}
.card-header {
    border-radius: 12px 12px 0 0 !important;
}
.btn {
    transition: all 0.3s ease;
}
.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}
.sticky-top {
    position: -webkit-sticky;
    position: sticky;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
<?php $__env->stopSection(); ?>








<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/Prog7/resources/views/dashboard/users/show.blade.php ENDPATH**/ ?>