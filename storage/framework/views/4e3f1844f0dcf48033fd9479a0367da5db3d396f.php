


<?php $key96=0?>

<div class="white-box"style="border: 2px solid #e5ebec;">
    <div class="box-title">
        <legend><h3>10. เอกสารอ้างอิง ชื่อย่อ</h3></legend>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-1">

              <div class="col-md-12">
                     <?php if(!is_null($certi_lab_attach_all10) && $certi_lab_attach_all10->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $certi_lab_attach_all10; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data->file): ?>
                                <div class="col-md-12 form-group">
                                    <a href="<?php echo e(url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file)  ))); ?>" target="_blank">
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


<div class="white-box"style="border: 2px solid #e5ebec;">
    <div class="box-title">
        <legend><h3> 11. เอกสารอื่นๆ (Others) </h3></legend>
    </div>
    <div class="row">
        <div class="col-md-11 col-md-offset-1">

              <div class="col-md-12">
                        <?php if(!is_null($certi_lab_attach_more) && $certi_lab_attach_more->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $certi_lab_attach_more; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($data->file): ?>
                                <div class="col-md-12 form-group">
                                    <?php echo e(@$data->file_desc); ?>

                                    <a href="<?php echo e(url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name : basename($data->file) ))); ?>" target="_blank">
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

<?php if($certi_lab->desc_delete != '' && !is_null($certi_lab->desc_delete)): ?>
<div class="row form-group">
    <div class="col-md-12">
        <div class="white-box" style="border: 2px solid #e5ebec;">
            <legend><h4>ยกเลิกคำขอ</h4></legend>
<div class="row">
    <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 text-light"> ระบุเหตุผล :    <label for="#"><?php echo e(!empty($certi_lab->desc_delete)? $certi_lab->desc_delete : null); ?></label> </div>
                </div>
            </div>
    </div>

    <div class="clearfix"></div>
    <?php if($CertiLabDeleteFile->count() > 0): ?>
    <div class="row">
        <?php $__currentLoopData = $CertiLabDeleteFile; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($data->path): ?>
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-12 text-light">
                            <?php echo e(@$data->name); ?>

                            <a href="<?php echo e(url('certify/check/file_client/'.$data->file.'/'.( !is_null($data->file_client_name) ? $data->file_client_name :  basename($data->file)  ))); ?>" target="_blank">
                            <?php echo HP::FileExtension($data->path)  ?? ''; ?>

                                <?php echo e(basename($data->path)); ?>

                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>

        </div>
    </div>
</div>
<?php endif; ?>

<div class="row form-group">
    <div class="col-md-12">
        <div class="checkbox checkbox-success">
            <input id="checkbox_confirm" class="checkbox_confirm" type="checkbox" name="checkbox_confirm"  disabled
                   value="1"  <?php echo e((isset($certi_lab) && $certi_lab->checkbox_confirm  == 1) ? 'checked': ''); ?>>
            <label for="checkbox_confirm"> &nbsp;    ห้องปฏิบัติการทดสอบและสอบเทียบขอรับรองว่า (LAB hereby affirms certify that)  
                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#myModal"><b>คลิก</b> </button>
            </label>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog  modal-lg" role="document">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
 
          <p>
            
                (1) ข้าพเจ้ารับทราบและให้คำมั่นจะปฏิบัติตามพระราชบัญญัติการมาตรฐานแห่งชาติ พ.ศ. 2551 รวมถึงกฎกระทรวง ประกาศ หลักเกณฑ์ วิธีการ และเงื่อนไข มาตรฐานข้อกำหนดสำหรับการรับรองระบบงาน ข้อกำหนดอื่น ๆ และ/หรือ ที่จะมีการกำหนด แก้ไขเพิ่มเติมในภายหลังด้วย 
                <br>
                I have acknowledged and committed to continually fulfil the requirements for accreditation and the other obligations of the conformity assessment body, and to comply with National Standardization Act, B.E.2551 (2008) including ministerial regulations, notification, criteria methods and conditions according to the act, standard requirement, conditions determined by TISI and/or any changes in future
          </p>
          <p>
             
                (2) ข้าพเจ้าจะชำระค่าธรรมเนียมคำขอรับใบรับรองและใบรับรองทันทีที่ได้รับใบแจ้งการชำระเงินจากสำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม 
                <br>
                I will pay application fee, and certificate document fee upon receiving the Pay-in Slip from TISI without delays.
          </p>
        </div>
      </div>
    </div>
  </div>