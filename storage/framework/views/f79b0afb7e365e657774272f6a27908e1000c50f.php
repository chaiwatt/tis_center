<?php $key95=0?>
    <div class="white-box"style="border: 2px solid #e5ebec;">
        <div class="box-title">
            <legend><h3> 9. การเข้าร่วมการทดสอบความชำนาญ / การเปรียบเทียบผลระหว่างห้องปฏิบัติการ (Participation in Proficiency testing program / Interlaboratory comparison) </h3></legend>

        </div>
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
    
                  <div class="col-md-12">
                            <?php if(!is_null($certi_lab_attach_all9) && $certi_lab_attach_all9->count() > 0): ?>
                            <div class="row">
                                <?php $__currentLoopData = $certi_lab_attach_all9; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($data->file): ?>
                                    <div class="col-md-12 form-group">
                                        <a href="<?php echo e(url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))); ?>" target="_blank">
                                            <?php echo HP::FileExtension($data->file)  ?? ''; ?>

                                            <?php echo e(!empty($data->file_client_name) ? $data->file_client_name :  basename($data->file)); ?>

                                        </a>
                                    </div>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                </div>
      
             </div>
        </div>
    </div>      