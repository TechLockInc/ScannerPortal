<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <h1>Add an appliance</h1>
            <?php if(count($errors)): ?>
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.
                    <br/>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="/add_appliance" method="post">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="client_code">Client Code</label>
                    <input type="text" class="form-control" id="client_code" name="client_code" style="text-transform:uppercase;" placeholder="Client Code" value="<?php echo e(old('client_code')); ?>">
                </div>
                <div class="form-group">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Client Name" value="<?php echo e(old('client_name')); ?>">
                </div>
                <div class="form-group">
                    <label for="tunnel">Tunnel IP</label>
                    <input type="text" class="form-control" id="tunnel" name="tunnel" placeholder="xxx.xxx.xxx.xxx" value="<?php echo e(old('tunnel')); ?>">
                </div>
                <div class="form-group">
                    <label for="external">External IP</label>
                    <input type="text" class="form-control" id="external" name="external" placeholder="xxx.xxx.xxx.xxx" value="<?php echo e(old('external')); ?>">
                </div>
                <button type="submit" class="btn btn-default">Add</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>