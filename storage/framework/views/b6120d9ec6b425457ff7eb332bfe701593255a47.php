<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title pull-left">แก้ไขคณะผู้ตรวจประเมิน</h3>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view-'.str_slug('board-auditor'))): ?>
                        <a class="btn btn-success pull-right" href="<?php echo e(app('url')->previous()); ?>">
                            <i class="icon-arrow-left-circle" aria-hidden="true"></i> กลับ
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

                    <?php echo Form::open(['url' => '/certify/auditor/'.$ba->id, 'class' => 'form-horizontal', 'files' => true, 'method' => 'put','id'=>'form_auditor']); ?>

                        <div id="box-readonly">
                            <?php echo $__env->make('certify.auditor.form-edit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    <?php echo Form::close(); ?>


                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?> 
    <script> 
        jQuery(document).ready(function() {
            let degree = '<?php echo e(($ba->state == 1)  ? 1 : 2); ?>';
     
            let status = '<?php echo e(($ba->status == 1)  ? 1 : 2); ?>';
            let reason_cancel = '<?php echo e(($ba->reason_cancel == 1)  ? 1 : 2); ?>';
            if(  status == 1  || reason_cancel == 1 ){
                $('#box-readonly').find('button[type="submit"]').remove();
                $('#box-readonly').find('.icon-close').parent().remove();
                $('#box-readonly').find('.fa-copy').parent().remove();
                $('#box-readonly').find('.div_hide').hide();
                $('#box-readonly').find('input').prop('disabled', true);
                $('#box-readonly').find('input').prop('disabled', true);
                $('#box-readonly').find('textarea').prop('disabled', true); 
                $('#box-readonly').find('select').prop('disabled', true);
                $('#box-readonly').find('.bootstrap-tagsinput').prop('disabled', true);
                $('#box-readonly').find('span.tag').children('span[data-role="remove"]').remove();
                $('#box-readonly').find('button').prop('disabled', true);
            }
        });
    </script>
     
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>