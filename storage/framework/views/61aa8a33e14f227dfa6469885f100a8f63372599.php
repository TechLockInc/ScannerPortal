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
            <form action="/add_route" method="post">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="client_code">Client Code</label>
                    <input type="text" class="form-control" id="client_code" name="client_code" style="text-transform:uppercase;" placeholder="Client Code" value="<?php echo e(old('client_code')); ?>">
                </div>
                <div class="form-group">
                    <label for="network_address">Network Address (Example: 192.168.1.0)</label>
                    <input type="text" class="form-control" id="network_address" name="network_address" placeholder="xxx.xxx.xxx.0" value="<?php echo e(old('network_address')); ?>">
                </div>
                <div class="form-group">
                    <label for="subnet_mask">Subnet Mask (Two numbers in CIDR notation)</label>
                    <input type="text" class="form-control" id="subnet_mask" name="subnet_mask" placeholder="xx" value="<?php echo e(old('subnet_mask')); ?>">
                </div>
                <button type="submit" class="btn btn-default">Add</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>