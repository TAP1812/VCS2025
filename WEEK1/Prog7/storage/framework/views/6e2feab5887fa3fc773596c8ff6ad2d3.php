<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Profile Settings</h3>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <!-- Avatar Display -->
                    <div class="text-center mb-4">
                        <img src="<?php echo e(filter_var($user->avatar, FILTER_VALIDATE_URL) ? $user->avatar : ($user->avatar ? Storage::url($user->avatar) : 'https://via.placeholder.com/150')); ?>" 
                             class="rounded-circle" 
                             alt="Avatar"
                             style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                    </div>

                    <!-- Profile Form -->
                    <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Username and Role -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <?php if($user->isTeacher()): ?>
                                        <input type="text" class="form-control" name="username" 
                                               value="<?php echo e(old('username', $user->username)); ?>" required>
                                    <?php else: ?>
                                        <div class="form-control bg-light"><?php echo e($user->username); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <div class="form-control bg-light"><?php echo e(ucfirst($user->role)); ?></div>
                                </div>
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Full Name</label>
                            <?php if($user->isTeacher()): ?>
                                <input type="text" class="form-control" id="fullname" name="fullname" 
                                       value="<?php echo e(old('fullname', $user->fullname)); ?>" required>
                            <?php else: ?>
                                <div class="form-control bg-light"><?php echo e($user->fullname); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo e(old('email', $user->email)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?php echo e(old('phone', $user->phone)); ?>">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Avatar</label>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Upload Image</label>
                                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="avatar_url" class="form-label">Or Use Image URL</label>
                                <input type="url" class="form-control" id="avatar_url" name="avatar_url" 
                                       placeholder="https://example.com/image.jpg">
                                <small class="text-muted">Enter a URL to use an external image as your avatar</small>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kalilinux/VCS2025/WEEK1/Prog7/resources/views/profile/show.blade.php ENDPATH**/ ?>