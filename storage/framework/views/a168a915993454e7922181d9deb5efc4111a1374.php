
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <style>
       #style{
            padding: 5px;
            border: 5px solid gray;
            margin: 0;
       }
       #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
            }

        #customers th {
        background-color: #66ccff;
        color: #000000;
        }
        .center {
            text-align: center;
         }
         .right {
            text-align: right;
         }
   </style>
</head>
<body>
   <div id="style">

    <p> 
        <b>เรียน    <?php echo e(!empty($certi_lab->BelongsInformation->name) ?  $certi_lab->BelongsInformation->name   :  ''); ?> </b>
    </p>
    <p> 
        <b>เรื่อง   การประมาณการค่าใช้จ่าย</b>    
    </p>

   <p class="indent50"> 
      ตามที่   <?php echo e(!empty($certi_lab->BelongsInformation->name) ?   $certi_lab->BelongsInformation->name   :  ''); ?>

      ได้ยื่นคำขอรับบริการยืนยันความสามารถห้องปฏิบัติการ
      คำขอเลขที่  <?php echo e(!empty($certi_lab->app_no) ?   $certi_lab->app_no  :  ''); ?> 
       ลงรับวันที่  <?php echo e(!empty($certi_lab->check->report_date) ?  HP::formatDateThaiFull($certi_lab->check->report_date) : ''); ?>  นั้น
      
   </p>
   <p class="indent50"> 
      สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรมขอแจ้งสรุปสาขา/ขอบข่ายที่ขอรับการรับรองห้องปฏิบัติการ และประมาณการค่าใช้จ่ายในการตรวจประเมิน โดยมีรายละเอียดดังนี้ 
   </p>
 
            <table id="customers" width="80%">
                <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            <th width="50%">รายละเอียด</th>
                            <th width="15%">จำนวนเงิน (บาท)</th>
                            <th width="15%">จำนวนวัน (วัน)</th>
                            <th width="15%">รวม (บาท)</th>
                        </tr>
                </thead>
                <tbody>
                    <?php if(count($cost->items) > 0): ?>
                       <?php $__currentLoopData = $cost->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $sum =  str_replace(",","", $item->amount) * $item->amount_date;
                                $details =  App\Models\Bcertify\StatusAuditor::where('id',$item->desc)->first();
                            ?>
                            <?php if(!empty($details)): ?>
                            <tr>
                                <td class="center"><?php echo e($key + 1); ?></td>
                                <td><?php echo e(!is_null($details) ? $details->title : null); ?></td>
                                <td class="right"><?php echo e(number_format(str_replace(",","", $item->amount),2)); ?></td>
                                <td class="right"><?php echo e($item->amount_date); ?></td>
                                <td class="right"><?php echo e(number_format($sum,2) ?? ''); ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
                 <footer>
                    <tr>
                        <td colspan="4" class="center">รวม</td>
                        <td class="right">
                            <?php echo e($cost->SumAmount  ?? ''); ?>

                        </td>
                    </tr>
                </footer>
            </table>
   <p class="indent50"> 
        และหากท่านมีความประสงค์จะเปลี่ยนแปลงสาขา/ขอบข่ายที่ขอรับการรับรองห้องปฏิบัติการ
        โปรดแจ้งสำนักงานทราบพร้อมระบุเหตุผลภายใน 15 วัน หากพ้นกำหนดเวลาดังกล่าว 
        สำนักงานจะถือว่าท่านยืนยันและยอมรับในสาขา/ขอบข่ายที่ขอรับการรับรองห้องปฏิบัติการ ตามข้างต้น
    </p>
    <p>
        จึงเรียนมาเพื่อโปรดดำเนินการ  
    <br>
        
            --------------------------
    </p>
            <img src="<?php echo asset('plugins/images/anchor_sm200.jpg'); ?>"  height="200px" width="200px"/>
    <p>
    <?php echo auth()->user()->UserContact; ?>

    </p>
    </div>
</body>
</html>

