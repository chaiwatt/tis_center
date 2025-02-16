<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">เพิ่มคณะผู้ตรวจประเมิน</h3>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-'.str_slug('board-auditor'))): ?>
                        <a class="btn btn-success pull-right" href="<?php echo e(app('url')->previous()); ?>">
                            <i class="icon-arrow-left-circle"></i> กลับ
                        </a>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <hr>
                    <?php if($errors->any()): ?>
                        <ul class="alert alert-danger">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>

                    <?php echo Form::open(['url' => '/certify/auditor', 'class' => 'form-horizontal', 'files' => true,'id'=>'form_auditor']); ?>


                    <?php echo $__env->make('certify.auditor.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo Form::close(); ?>


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>