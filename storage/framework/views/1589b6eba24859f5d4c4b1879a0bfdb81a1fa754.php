<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
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
<div class="container" style="width: 100%">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>All Appliances</h2></div>
                <?php if(Session::has('success')): ?>
                    <div class="alert alert-success"><?php echo Session::get('success'); ?></div>
                <?php endif; ?>
                <?php if(Session::has('failure')): ?>
                    <div class="alert alert-danger"><?php echo Session::get('failure'); ?></div>
                <?php endif; ?>
                <div class="panel-body">
                    <?php $allAppliances = \App\Appliance::all(); ?>
                    <?php if($allAppliances->first() == NULL): ?>
                        There is not any appliance stored in the database!
                    <?php else: ?>
                        <table>
                            <tr>
                                <th>Client Code</th>
                                <th>Client Name</th>
                                <th>Tunel IP</th>
                                <th>External IP</th>
                                <th>Hostname</th>
                            </tr>
                            <?php $__currentLoopData = $allAppliances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appliance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th><a href="<?php echo e(url('/view_appliance/'.$appliance->client_code)); ?>"><?php echo e($appliance->client_code); ?></th>
                                    <th><?php echo e($appliance->client_name); ?></th>
                                    <th><?php echo e($appliance->tunnel); ?></th>
                                    <th><?php echo e($appliance->external); ?></th>
                                    <?php $vm = \App\Vm::where('id', $appliance->hostname)->first();?>
                                    <th><?php echo e($vm->hostname); ?></th>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>