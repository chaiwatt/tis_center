
<?php
$labRequestBranchs = [];
  if ($labCalRequest->count() != 0) {
      $labRequestBranchs = $labCalRequest->where('type',2);
  }else if($labTestRequest->count() != 0)
  {
      $labRequestBranchs = $labTestRequest->where('type',2);
  }
?>

<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
<div class="white-box"style="border: 2px solid #e5ebec;">
    <div class="box-title">
        <legend><h3>รายละเอียดที่อยู่ห้องปฏิบัติการ
        
        <?php if($labRequestBranchs->count()  != 0): ?>
         (สถานปฏิบัติการหลายสถานที่)
        <?php endif; ?>
    </h3>
        </legend>    
    </div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                        วัตถุประสงค์ในการยื่นคำขอ : 
                 </div>
                 <div class="col-md-5 text-left">
                  <label for="purpose_type">
                    <?php if($certi_lab->purpose_type == 1): ?>
                            <label for="">ขอใบรับรอง</label>
                     <?php elseif($certi_lab->purpose_type == 2): ?>
                            <label for="">ต่ออายุใบรับรอง</label>
                    <?php elseif($certi_lab->purpose_type == 3): ?>
                            <label for="">ขยายขอบข่าย</label>
                     <?php endif; ?>
                </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    อ้างอิงเลขที่คำขอ : 
                 </div>
                 <div class="col-md-8 text-left">
                    <label for="lab_name">
                        <?php echo e(@$certi_lab->certificate_exports_id); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    ใบรับรองเลขที่ : 
                 </div>
                 <div class="col-md-8 text-left">
                    <label for="lab_name">
                        <?php echo e($certi_lab->certificate_exports_id); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    หมายเลขการรับรอง : 
                 </div>
                 <div class="col-md-8 text-left">
                    <label for="lab_name">
                        <?php echo e($certi_lab->accereditation_no); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                       ความสามารถห้องปฏิบัติการ : 
                 </div>
                 <div class="col-md-5 text-left">
                    <label for="lab_type">
                        <?php if($certi_lab->lab_type == 3): ?>
                        <label for="">ทดสอบ</label>
                        <?php elseif($certi_lab->lab_type == 4): ?>
                            <label for="">สอบเทียบ</label>
                        <?php endif; ?>
                    </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                      ชื่อห้องปฏิบัติการ : 
                 </div>
                 <div class="col-md-8 text-left">
                    <label for="lab_name">
                        <?php echo e($certi_lab->lab_name); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                     ชื่อห้องปฏิบัติการ (eng) : 
                 </div>
                 <div class="col-md-8 text-left">
                    <label for="lab_name_en">
                        <?php echo e($certi_lab->lab_name_en ?? null); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                      ชื่อย่อห้องปฏิบัติการ  : 
                 </div>
                 <div class="col-md-8 text-left">
                    <label for="lab_name_short">
                        <?php echo e($certi_lab->lab_name_short ?? null); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    เลขที่ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="lab_name">
                        <?php echo e($certi_lab->address_no); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    หมู่ที่ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="allay">
                        <?php echo e($certi_lab->allay); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    ตรอก/ซอย : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="village_no">
                        <?php echo e($certi_lab->village_no); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    ถนน : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="road">
                        <?php echo e($certi_lab->road); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    จังหวัด : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="province">
                        <?php echo e($certi_lab->basic_province->PROVINCE_NAME  ?? '-'); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    เขต/อำเภอ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="amphur">
                        
                        <?php echo e($certi_lab->amphur  ?? '-'); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    แขวง/ตำบล : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="district">
                        
                        <?php echo e($certi_lab->district  ?? '-'); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    รหัสไปรษณีย์ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="postcode">
                        <?php echo e($certi_lab->postcode); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    โทรศัพท์ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="tel">
                        <?php echo e($certi_lab->tel); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    โทรสาร : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="tel_fax">
                        <?php echo e($certi_lab->tel_fax); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    บุคคลติดต่อ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="contactor_name">
                        <?php echo e($certi_lab->contactor_name); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    Email : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="email">
                        <?php echo e($certi_lab->email); ?>

                   </label>
                 </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="row">
                 <div class="col-md-4 text-right">
                    โทรศัพท์ผู้ติดต่อ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="contact_tel">
                        <?php echo e($certi_lab->contact_tel); ?>

                   </label>
                 </div>
                 <div class="col-md-2 text-right">
                    โทรศัพท์มือถือ : 
                 </div>
                 <div class="col-md-3 text-left">
                    <label for="telephone">
                        <?php echo e($certi_lab->telephone); ?>

                   </label>
                 </div>
            </div>
        </div>

    </div>
  </div>

    <div class="box-title">
        <legend><h3>รายละเอียดที่อยู่ห้องปฏิบัติการ EN</h3></legend>    
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        เลขที่ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="lab_name">
                            <?php echo e($certi_lab->lab_address_no_eng); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        หมู่ที่ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="allay">
                            <?php echo e($certi_lab->lab_moo_eng); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        ตรอก/ซอย : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="village_no">
                            <?php echo e($certi_lab->lab_soi_eng); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        ถนน : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="road">
                            <?php echo e($certi_lab->lab_street_eng); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        จังหวัด : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="province">
                            <?php echo e($certi_lab->lab_province_eng->PROVINCE_NAME  ?? '-'); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        เขต/อำเภอ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="amphur">
                            
                            <?php echo e($certi_lab->lab_amphur_eng  ?? '-'); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        แขวง/ตำบล : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="district">
                            
                            <?php echo e($certi_lab->lab_district_eng  ?? '-'); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        รหัสไปรษณีย์ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="postcode">
                            <?php echo e($certi_lab->lab_postcode_eng); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        พิกัดที่ตั้ง (ละติจูด) : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="tel">
                            <?php echo e($certi_lab->lab_latitude); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        พิกัดที่ตั้ง (ลองจิจูด) : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="tel_fax">
                            <?php echo e($certi_lab->lab_longitude); ?>

                    </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    


<?php if($labRequestBranchs->count() != 0): ?>
<hr>
    <?php $__currentLoopData = $labRequestBranchs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $labRequestBranch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="box-title">
        <legend><h3>รายละเอียดที่อยู่ห้องปฏิบัติการ (สาขา<?php echo e(trim($labRequestBranch->tambol_name)); ?>: <?php echo e(trim($labRequestBranch->province_name)); ?>)</h3></legend>    
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        เลขที่ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="lab_name">
                            <?php echo e($labRequestBranch->no); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        หมู่ที่ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="allay">
                            <?php echo e($labRequestBranch->moo); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        ตรอก/ซอย : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="village_no">
                            <?php echo e($labRequestBranch->soi); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        ถนน : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="road">
                            <?php echo e($labRequestBranch->street); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        จังหวัด : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="province">
                            <?php echo e($labRequestBranch->province_name  ?? '-'); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        เขต/อำเภอ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="amphur">

                            <?php echo e($labRequestBranch->amphur_name  ?? '-'); ?>

                    </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 text-right">
                        แขวง/ตำบล : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="district">

                            <?php echo e($labRequestBranch->tambol_name  ?? '-'); ?>

                    </label>
                    </div>
                    <div class="col-md-2 text-right">
                        รหัสไปรษณีย์ : 
                    </div>
                    <div class="col-md-3 text-left">
                        <label for="postcode">
                            <?php echo e($labRequestBranch->postal_code); ?>

                    </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>



</div>