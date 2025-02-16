

<div id="viewForm91" class="<?php echo e($certi_lab->lab_type == 4 ? 'show':'hide'); ?>">
    <div class="white-box"style="border: 2px solid #e5ebec;">
        <div class="box-title">
            <legend><h3> 6. ขอบข่ายที่ยื่นขอรับการรับรอง (<span class="text-warning">ห้องปฏิบัติการสอบเทียบ</span>) (Scope of Accreditation Sought  (<span class="text-warning">For calibration laboratory</span>))</h3></legend>
            
        </div>
          <div class="row">
            <div class="col-md-12">
                <?php if($certi_lab_attach_all62->count() > 0): ?>
                    <div class="col-md-11 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <label for="#" class="label_other_attach ctext-light">แนบไฟล์ขอบข่ายที่ต้องการยื่นขอการรับรอง</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 col-md-offset-1">
                        <div class="row">
                            <div class="col-md-12 text-left">
                                <?php
                                    $latestFile62 = $certi_lab_attach_all62->sortByDesc('created_at')->first(); // สมมติว่าใช้ 'created_at' แทนวันที่
                                ?>

                                <?php if($latestFile62 && $latestFile62->file): ?>
                                    <div class="col-md-12 form-group">
                                        <a href="<?php echo e(url('certify/check/file_client/'.$latestFile62->file.'/'.( !is_null($latestFile62->file_client_name) ? $latestFile62->file_client_name : basename($latestFile62->file) ))); ?>" target="_blank">
                                            <?php echo HP::FileExtension($latestFile62->file) ?? ''; ?>

                                            <?php echo e(!empty($latestFile62->file_client_name) ? $latestFile62->file_client_name : basename($latestFile62->file)); ?>

                                        </a>
                                    </div>
                                <?php endif; ?>

                                
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
             </div>
             <div class="col-md-12" id="scope_table_wrapper">
    
             </div>
        </div>
    </div>       
</div>

