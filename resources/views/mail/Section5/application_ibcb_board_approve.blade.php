<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <style>
            #style{
                padding: 5px;
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
            .indent-body {
                text-indent: 30px;
            }
        </style>
    </head>
    <body>
        <div id="style">
            <p>
                <b>เรียน {{ $applicant_name }}</b>
            </p>
            <p>
                เรื่อง {{ $subject }}
            </p>
            <p class="indent-body">
                ตามที่ท่านได้ยื่นคำขอรับการแต่งตั้งเป็นผู้ตรวจสอบการทำผลิตภัณฑ์อุตสาหกรรม
                        เลขคำขอ {{ $application_no }} เมื่อวันที่ {{ $application_date }}
                        สำนักงานมาตรฐานผลิตภัณฑ์อุตสาหกรรม (สมอ.) ได้อนุมัติให้เป็นผู้ตรวจสอบแล้ว
                        โดยมีผลตั้งแต่วันที่ {{ $start_date }} เป็นต้นไป
                        <br>ท่านสามารถเข้าใช้งานระบบยื่นคำขอรับใบอนุญาตผ่านระบบอินเทอร์เน็ต (e-License) โดยใช้ข้อมูลดังต่อไปนี้
                        <div>URL : {!! $url !!}</div>
                        <div>Username : {{ $username }}</div>
                        <div>Password : {{ $password }}</div>

                        <br><br>จึงเรียนมาเพื่อทราบ
            </p>

        </div>
    </body>
</html>
