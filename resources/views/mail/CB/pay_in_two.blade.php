
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
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #66ccff;
        color: #000000;
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
            <b>เรียน    {{  !empty($certi_cb->name) ? $certi_cb->name   :  ''  }} </b>
        </p>
        <p> 
            <b> เรื่อง  แจ้งตรวจสอบการชำระค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง </b> 
        </p>
        <p style="text-indent: 50px;">ตามที่   {{  !empty($certi_cb->name) ? $certi_cb->name   :  ''  }}  ได้แนบหลักฐานการชำระเงินค่าธรรมเนียมคำขอ และค่าธรรมเนียมใบรับรอง คำขอรับใบรับรองหน่วยรับรอง
            หมายเลขคำขอ {{  !empty($certi_cb->app_no) ?   $certi_cb->app_no  :  ''  }}   สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม
            @if ($PayIn->status == 1)
               <span style="color:#69b838;"> ได้รับการชำระเงินเรียบร้อยแล้ว </span>
            @else
               <span style="color:#69b838;"> ยังไม่ได้รับการชำระเงิน </span>
            @endif
        </p> 
        
        @if ($PayIn->conditional_type == 1) <!-- เรียกเก็บค่าธรรมเนียม --> 
            <p>	ค่าธรรมเนียมคำขอการใบรับรอง สก. :
                <span style="color:#26ddf5;">{{ !empty($PayIn->amount_fixed) ?  number_format($PayIn->amount_fixed,2).' บาท ' : '0.00' }}</span>
            </p>
            <p>	ค่าตรวจสอบคำขอ :
                <span style="color:#26ddf5;">{{ !empty($PayIn->amount) ?  number_format($PayIn->amount,2).' บาท '  : '0.00' }}</span>
            </p>
            <p>ค่าธรรมเนียมใบรับรอง สก. :
                <span style="color:#26ddf5;">{{ !empty($PayIn->amount_fee) ?  number_format($PayIn->amount_fee,2).' บาท '   : '0.00' }}</span>
            </p>
        @elseif($PayIn->conditional_type == 2) <!-- ยกเว้นค่าธรรมเนียม --> 
        <p>	หมายเหตุ :
            <span>{{ !empty($PayIn->remark) ? $PayIn->remark  : null  }}</span>
        </p>
        @elseif($PayIn->conditional_type == 3) <!--  ไม่เรียกชำระเงิน หรือ กรณีอื่นๆธรรมเนียม --> 
        <p>	หมายเหตุ :
            <span>{{ !empty($PayIn->remark) ? $PayIn->remark  : null  }}</span>
        </p>
        @endif
        
        @if (!empty($PayIn->detail) )
            <p>	หมายเหตุ :
                <span>{{ $PayIn->detail  ?? null  }}</span>
            </p>
        @endif

        <p style="text-indent: 50px;"> จึงเรียนมาเพื่อโปรดดำเนินการ </p>
        <img src="{!! asset('plugins/images/anchor_sm200.jpg') !!}"  height="200px" width="200px"/>
        <p>
            {!!   !empty(auth()->user()->UserContact) ? auth()->user()->UserContact  :  ''   !!}
        </p>
    </div> 
</body>
</html>

