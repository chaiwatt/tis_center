<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            /* width: 60%; */
            padding: 5px;
            border: 5px solid gray;
            margin: 0;
            
       }    
       .customers td, .customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

        .customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #66ccff;
        color: #000000;
        }   
        
        .center {
            text-align: center;
         }
         .right {
            text-align: right;
        }    
        .indent50 {
        text-indent: 50px;
        } 
        .indent100 {
        text-indent: 100px;
        }
   </style>
</head>
<body>
   <div id="style">
    
    <p> 
        <b>เรียน    <?php echo e(!empty($certi_lab->BelongsInformation->name) ?   $certi_lab->BelongsInformation->name   :  ''); ?> </b>
    </p>
    <p> 
        <b>เรื่อง  การแต่งตั้งคณะผู้ตรวจประเมิน</b>    
    </p>

    <p class="indent50"> 
        ตามที่    <?php echo e(!empty($certi_lab->BelongsInformation->name) ?  $certi_lab->BelongsInformation->name   :  ''); ?>

        เห็นชอบการประมาณการค่าใช้จ่าย ของ   <?php echo e(!empty($certi_lab->BelongsInformation->name) ?  $certi_lab->BelongsInformation->name  :  ''); ?>

        คำขอเลขที่  <?php echo e(!empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''); ?> 
        สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมขอแจ้งกำหนดการตรวจประเมินพร้อมรายชื่อคณะผู้ตรวจประเมิน 
        โดยมีรายละเอียดดังนี้
    </p>
    <p class="indent50"> 
        กำหนดการ  <?php echo e(!empty($auditors->DataBoardAuditorDateMail ) ?  $auditors->DataBoardAuditorDateMail   :  ''); ?>    
    </p>
    <p class="indent50"> 
        ผู้ตรวจประเมิน
    </p>


        <?php if(count($auditors->groups) > 0): ?>
        <p> 
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            โดยคณะผู้ตรวจประเมิน มีรายนามดังต่อไปนี้
        </p>
        <table   class="customers" width="80%">
            <thead>
                    <tr>
                        <th width="2%">#</th>
                        <th width="10%">สถานะผู้ตรวจประเมิน</th>
                        <th width="10%" >ชื่อผู้ตรวจประเมิน</th>
                        <th width="10%" >หน่วยงาน</th>
                    </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $auditors->groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr> 
                    <td  class="center"><?php echo e($key + 1); ?></td>
                    <td><?php echo e($data->sa->title ?? '-'); ?></td>
                    <td>
                        <?php if(count($data->auditors) > 0): ?>
                                <?php $__currentLoopData = $data->auditors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $auditor = $ai->auditor;
                                ?>
                                    <?php echo e($auditor->name_th ?? '-'); ?> <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                         -
                        <?php endif; ?>
                    </td>
                    
                    <td>
                        <?php if(count($data->auditors) > 0): ?>
                            <?php $__currentLoopData = $data->auditors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ai): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $auditor = $ai->auditor;
                                    $departmentTitle = $auditor->department->title ?? ''; // ตรวจสอบว่ามี title หรือไม่
                                ?>
                                <?php echo e(str_contains($departmentTitle, 'ไม่มีรายละเอียด') ? '-' : $departmentTitle); ?> <!-- ตรวจสอบคำว่า "ไม่มีรายละเอียด" -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    
                </tr> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>

        <?php if(count($auditors->cost_item_confirm) > 0): ?>
        <p class="indent50"> 
            ค่าใช้จ่าย 
        </p>
        <table   class="customers" width="80%">
            <thead>
                     <tr>
                        <th  class="center">#</th>
                        <th>รายละเอียด</th>
                        <th>จำนวนเงิน</th>
                        <th>จำนวนวัน</th>
                        <th>รวม (บาท)</th>
                    </tr>
            </thead>
            <tbody>
                <?php    
                $SumAmount = 0;
                ?>
                <?php $__currentLoopData = $auditors->cost_item_confirm; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php     
                    $amount_date = !empty($items->amount_date) ? $items->amount_date : 0 ;
                    $amount = !empty($items->amount) ? $items->amount : 0 ;
                    $sum =   $amount*$amount_date;
                    $SumAmount  +=  $sum;
                    ?>
                <tr> 
                    <td  class="center"><?php echo e($key + 1); ?></td>
                    <td><?php echo e(!empty($items->StatusAuditorTo->title) ? $items->StatusAuditorTo->title : null); ?></td>
                    <td  class="right"><?php echo e(number_format( $items->amount,2)); ?></td>
                    <td  class="right"><?php echo e($amount_date ?? null); ?></td>
                    <td  class="right"><?php echo e(number_format($sum,2)); ?></td>
                </tr> 
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
            <footer>
                <tr>
                    <td colspan="4" class="right">รวม</td>
                    <td  class="right">
                         <?php echo e(!empty($SumAmount) ?  number_format($SumAmount, 2) : '-'); ?> 
                    </td>
                </tr>
            </footer>
        </table>
        <?php endif; ?>
        
        <p class="indent50"> 
            จึงเรียนมาเพื่อทราบ และหากท่านมีข้อขัดข้องในองค์ประกอบของคณะผู้ตรวจประเมินและกำหนดการตรวจประเมิน ดังกล่าวประการใด โปรดแจ้งสำนักงานทราบพร้อมระบุเหตุผลโดยด่วนด้วย 
            และขอให้ท่านเข้าระบบ <a href="<?php echo e($url ?? '/'); ?>"class="btn btn-link" target="_blank">E-Accreditation</a> เพื่อยื่นยันคณะผู้ตรวจประเมินและวันที่ตรวจประเมิน ภายหลังจากรับการตรวจประเมินเรียบร้อยแล้ว  จักขอบคุณยิ่ง
          <br>
          
          --------------------------
      </p>
          <img src="<?php echo asset('plugins/images/anchor_sm200.jpg'); ?>"  height="200px" width="200px"/>
     <p>
        
         
        

        <?php
        $user = null;
            $examiner =  App\Models\Certify\Applicant\CheckExaminer::where('app_certi_lab_id', $certi_lab->id)->first();
            if($examiner !== null){
                $user = \App\User::find($examiner->user_id);
            }
            // $user = \App\User::find(1);
        ?>
        

        <?php if($user == null): ?>
        <?php echo auth()->user()->UserContact; ?>

            <?php else: ?>
            <?php echo $user->UserContact; ?>

        <?php endif; ?>
          
     </p>
    </div> 
</body> 
</html>

