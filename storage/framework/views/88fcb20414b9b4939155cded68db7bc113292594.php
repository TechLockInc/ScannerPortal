<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <h1>Add an appliance</h1>
            <form action="/addappliance" method="post">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="client_code">Client Code</label>
                    <input type="text" class="form-control" id="client_code" name="client_code" placeholder="Client Code">
                </div>
                <div class="form-group">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Client Name">
                </div>
                <div class="form-group">
                    <label for="tunnel">Tunnel IP</label>
                    <input type="text" class="form-control" id="tunnel" name="tunnel" placeholder="xxx.xxx.xxx.xxx">
                </div>
                <div class="form-group">
                    <label for="external">External IP</label>
                    <input type="text" class="form-control" id="external" name="external" placeholder="xxx.xxx.xxx.xxx">
                </div>
                <button type="submit" class="btn btn-default">Add</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>