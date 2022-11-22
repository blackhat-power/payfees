<html>
<head>

<style> 
html,body {
    margin:0;
    padding:0;
}

#bill_to{

    margin-top: -12px;

}

        body {
            margin: 0 auto;
            color: #000000;
            background: #FFFFFF;
            font-family: "DejaVu Sans Mono";
            font-size: 12px;
        }

        
  

.container{
    display:block;
    width: 100%;
    height:130px;
    background-color: #FFFFFF;
    color:white !important;
}
#footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    padding-top: 15px;
    background-color: #050857;
    text-align: center;
    color: white !important;
}

#table-line{
    margin-top: -80px;
}


.row {
    text-align: center;
}
.first_box {
    display: inline-block;
    margin-right: 6px;
    color: black !important;
    width: 450px;
    height: 80px;
}

.second_box {
    display: inline-block;
    margin-right: 6px;
    color: black !important;
    width: 250px;
    height: 80px;
    margin-top: -10px;
}



.clear {
    clear: both;
}



#invoice_span{
    font-size:3.7em;
    display: inline-block;
    padding-top: 40px;
    padding-left: 35px;
    color: #040965 !important;
}


.school_address{
    float: right;
    padding-right: 40px;
    margin-top: -5px;
}

.bill_to_phone{
    margin-bottom:-20px;
}

.invoice_details{

    /* margin-left: 66px; */
    margin-left: 50px;
    margin-bottom:2%;
    width: 100%;
    /* margin-top: 10px; */
}

#cover_page{left:100px; top:422px;letter-spacing:-0.34px;}

.description {
    border-spacing: 0px;
    border-collapse: separate;
    border-top: 1px solid #999;

}
.description tr td {
    border-bottom: 1px solid #999;
    padding: 8;
}
.description  th  {
    padding: 8;
    border-bottom: 1px solid #999;
}

.charge_details{

    /* display: flex; */
   justify-content: center;
    margin-top: 2px;
    margin-left: 50px;
    
}

#imgg {
  position: absolute;
  left:200px;top:780px;
  text-align: center;
  z-index: calc(-9e999);
}

.account_no{

    margin-top: 13px;
}

.bill_to_phone_swift{

    margin-top:-20px;
}

</style>

    </head>
 
    <body>
    <img id="imgg" height="230" width="380" src="" alt="">
<div style="overflow: auto; position: relative; z-index:calc(9e999)"> 
<!-- <span id="cover_page" style="position: absolute; z-index:-2"> -->

<!-- </span> -->
       <div class="container">
        <span id="invoice_span">Invoice</span>

        <span style="padding-left: 140px; padding-top:100px">
</span>
    
        <div class="school_address">
        <img width="180" height="120" alt="logo" src="">
        </div>

    </div>

    <div class='container'>
    <div class='row'>
        <div class='first_box'>
        <table id="bill_to">
        <tr>
            <td><p class="bill_to_phone"><b> Bill To:</b></p></td>
            <td> <p class="bill_to_phone"> M/s   {{ strtoupper($particulars->name) }} </p>   </td>
        </tr>
        <tr>
            <td> <p class="bill_to_phone"> <b>Bill To Phone:</b> </p> </td>
            <td> <p class="bill_to_phone">  {{ $student_phone }}   </p>  </td>
        </tr>
        <tr>
            <td> <p class="bill_to_phone"> <b> Bill To Email:</b> </p></td>
            <td> <p class="bill_to_phone">  {{ $student_phone }} </p> </td>
        </tr>
    </table>
        </div>
        <div class='second_box'>

        <table style="font-size: 12px;">
            <tr>
                                  <td><p class="bill_to_phone" ><b> Invoice Date: </b></p></td>
                                  <td> <p class="bill_to_phone" > {{ date("M jS, Y", strtotime("".$particulars->invoice_date."")) }}  </p> </td>
                          </tr>
                            <tr>
                                <td>  <p class="bill_to_phone"> <b>Invoice Number:</b> </p> </td>
                                <td> <p class="bill_to_phone">  {{ $particulars->invoice_number }}  </p>  </td>
                            </tr>
  
  
                            <tr>
                                <td> <p class="bill_to_phone"> <b> Currency: </b>  </p>    </td>
                                <td> <p class="bill_to_phone"> Tanzania Shillings </p> </td>
                            </tr>
</table>

        </div>
    </div>
    <div class='clear'></div>
</div>




<table id="table-line" style="width: 100%;">
    <tr> <td style="padding-left: 40px;padding-right:40px" colspan="2"> <hr  style="background-color: #eaedef !important"/> </td> </tr>
    </table>

    <div class="charge_details">
    <div>  <h2 style="color:lightslategrey"> Charge Details </h2> </div>
    <div>
        <table class="description" style="width:94%;">
            <thead>
                <tr>
                    <th style="color: #040965">SN</th>
                    <th style="text-align: center; color:#040965"> CHARGE DESCRIPTION </th>
                    <th style="text-align: right; color:#040965" > AMOUNT </th>
                   </tr>
            </thead>

            <tbody>
                @foreach ($invoice_items as $index => $item )
                <tr>
                    <td style="text-align: center;">{{++$index}}</td>
                    <td > Payment for </b> {{ strtolower($item->descriptions) }} </b> </td>
                    <td style="text-align: right; padding:8px;">{{ number_format($item->rate) }}  </td>
                </tr>
                @endforeach

            </tbody>
           
        </table>
        <table  style="width:94%;">
            <thead>
                   <tr>
                    <th style="text-align: left; color:#040965; padding-bottom:10px; padding-left:340px"> TOTAL  PAYABLE </th>
                    <th  style="background-color: #548235; color: white; text-align: right; padding:6px"> <strong>{{ number_format($particulars->amount)}}</strong> </th>
                   </tr>

                   <tr>
                    <td colspan="15" style="color: #040965; width:100%; padding:5px; background-color:#D6EEEE"> AMOUNT IN WORDS: <p style="font-family: maserrati !important; display:inline"> <b> {{  Helper::inwords($particulars->amount)    }} Only </b> </p></td>
                </tr>

            </thead>            
        </table>
<div>

    <table style="font-size: 12px">
        <tr>
                <td style="text-align: left; width: 100%">
                <table>
                    @foreach ($school_bank_details as $bank_detail )
                    <tr>
                    <td style="text-align: left; width: 100%">
                        <tr>
                            <table>
                                <tr><td><strong>Bank Details</strong></td></tr>
                                <tr>
                                    <td><span>Bank Name<b>:</b>&nbsp;</span></td>
                                    <td>{{$bank_detail->bank_name}}</td>
                                </tr>
                                <tr>
                                    <td><span>Acc No<b>:</b>&nbsp;</span></td>
                                    <td>{{$bank_detail->account_no}}</td>
                                </tr>
                            </table>
                        </tr>
                    </td> 
                </tr>

                    @endforeach
                 
                </table>
            </td>
            <td style="padding-left: 390px; padding-top:2px">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate( $qrcode )) !!} ">
            </td>
            </tr>
            <br />
            </table>

    <table style="width: 100%;">
    <tr> <td style="padding-left: 5px;padding-right:40px" colspan="2"> <hr  style="background-color: #eaedef !important"/> </td> </tr>
    </table>

    <table style="font-size: 12px; margin-left:270px; margin-top:20px">
            <tr>
                <td colspan="2" style="vertical-align: top; text-align: center;">
                    <strong style="color: #1B219C">APPROVED BY: </strong><br /><br />
                    <span>      </span>
                    <br />
                   <span>Adelmars Kiselar</span> 
                </td>
            </tr>
    </table>
            </div>
            </div>
    </div>


<div id="footer">

<div style="text-align: center; margin-bottom:3%">

<p  style="text-align: center;"> Address:&nbsp; {{ $school_address }} </p>
<span  style="text-align: center;"> Phone: {{ $school_phone }} &nbsp;  </span>
<span  style="text-align: center;"> Email: &nbsp; {{ $school_email }} </span>
</div>
                        
</div>

</div>

</body>

    

</html>




















