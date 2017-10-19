<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 50%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <h1><?php echo e($client_code); ?></h1>
            <?php $appliance = \App\Appliance::where('client_code', $client_code)->first(); ?>
            <h3>Client name: <?php echo e($appliance->client_name); ?></h3>
            <h3>Tunnel IP  : <?php echo e($appliance->tunnel); ?></h3>
            <h3>External IP: <?php echo e($appliance->external); ?></h3>
            <h3>Subnets:</h3>
            <?php if(Session::has('success')): ?>
                <div class="alert alert-success"><?php echo Session::get('success'); ?></div>
            <?php endif; ?>
            <?php if(Session::has('failure')): ?>
                <div class="alert alert-danger"><?php echo Session::get('failure'); ?></div>
            <?php endif; ?>
            <h3></h3>
            <?php $allRoutes = \App\Route::where('gateway', $appliance->id)->get();  
                function mask2cidr($mask){  
                     $long = ip2long($mask);  
                     $base = ip2long('255.255.255.255');  
                     return 32-log(($long ^ $base)+1,2);       
                }  
            ?>
            <?php if($allRoutes->first() == NULL): ?>
                There is not any subnet associated with this appliance.
            <?php else: ?>
            
                <?php $__currentLoopData = $allRoutes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <h5><?php echo e($route->subnet); ?> / <?php echo e(mask2cidr($route->mask)); ?></h5>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <h3></h3><h3></h3>
            <h4>Add a subnet</h4>
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
            <form action="/view_appliance" method="post">
                <?php echo csrf_field(); ?>

                <div class="body">    
                    <div class="wrapper">
                        <span class="inline">
                            <input class="inputbold" type="text" id="network_address" name="network_address" placeholder="xxx.xxx.xxx.xxx" style="width: 120px;" value="<?php echo e(old('network_address')); ?>"/>/
                            <input class="inputbold" type="text" id="subnet_mask"  name="subnet_mask" placeholder="xx" style="width: 35px;" value="<?php echo e(old('subnet_mask')); ?>"/>
                            <input class="inputbold" type="hidden" id="client_code"  name="client_code" value="<?php echo e($appliance->client_code); ?>"/>
                            <button type="submit" class="inputbold">Add</button>
                        </span>
                   </div>
                </div>
            </form>
        </div>
        <a href="<?php echo e(url('/delete_route')); ?>"><u>Delete a subnet?</u></a>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>