
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>
<div class="white-box"style="border: 2px solid #e5ebec;">
    <div class="box-title">
        <legend><h3>คำขอรับใบรับรองห้องปฏิบัติการ</h3></legend>    
    </div>
    <div class="row">
        <?php if($certi_lab->status >= 9 || $certi_lab->status == 7): ?>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-9"></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="app_no" class="control-label">เลขที่คำขอ: </label>
                        <input type="text" class="form-control text-center" readonly value=" <?php echo e($certi_lab->app_no); ?> " >
                    </div>
                </div>
                <div class="col-md-9"></div>
                <div class="col-md-3 text-center">
                    <p>
                        <?php echo e(!empty($certi_lab->check->ResultReportDate) ?   $certi_lab->check->ResultReportDate : '-'); ?> 
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            ชื่อผู้ยื่นขอรับรองการรับรอง: <label for="app_name"><?php echo e(!empty($certi_lab->name) ?  $certi_lab->name :   $certi_information->name); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            เลขประจำตัวผู้เสียภาษีอากร: <label for="id_tax"><?php echo e($certi_information->tax_indentification_number); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            มีสำนักงานใหญ่ตั้งอยู่เลขที่ : <label for="head_num"><?php echo e($certi_information->address_headquarters); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            ตรอก/ซอย :  <label for="head_soi"><?php echo e($certi_information->headquarters_alley); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            ถนน : <label for="head_street"><?php echo e($certi_information->headquarters_road); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            หมู่ที่ : <label for="head_moo"><?php echo e($certi_information->headquarters_village_no); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            ตำบล/แขวง : <label for="head_tumbon"><?php echo e($certi_information->headquarters_district); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            อำเภอ/เขต : <label for="head_area"><?php echo e($certi_information->headquarters_amphur); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            จังหวัด : <label for="head_province"><?php echo e($certi_information->headquarters_province); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            รหัสไปรษณีย์ : <label for="head_post"><?php echo e($certi_information->headquarters_postcode); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            โทรศัพท์ : <label for="head_tel"><?php echo e($certi_information->headquarters_tel); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            โทรสาร: <label for="head_fax"><?php echo e($certi_information->headquarters_tel_fax); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            จดทะเบียนเป็นนิติบุคคลเมื่อวันที่: <label for="entity_date"><?php echo e(HP::DateThai($certi_information->date_regis_juristic_person) ?? '-'); ?></label>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>

    </div>
</div>
<?php $__env->startPush('js'); ?>
    <script src="<?php echo e(asset('js/mask/jquery.inputmask.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/mask/mask.init.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>