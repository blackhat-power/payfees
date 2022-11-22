
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
            color: #000000 !important;
            background: #FFFFFF;
            font-family: "DejaVu Sans Mono";
            font-size: 12px;
        }

        
  

.container{
    display:block;
    width: 100%;
    height:140px;
    background-color: #FFFFFF;
    color:#000000 !important;
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
}
.description tr td {
    border-bottom: 1px solid #999;
    padding: 8;
}
.description  th  {
     padding: 2; 
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
        <span id="invoice_span">Contra Voucher</span>

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
            <thead> 
                <tr> 
                    <th> Voucher Number:  </th> 
                    <th style="width:50px">   </th>
                    <th> Date Of Issue:  </th>    
                </tr>
            
            </thead>
            <tbody>

                <tr>
                
                    <td>  {{ $journal_entry->reference }}  </td>
                    <td style="width:50px">    </td>
                    <td>  {{ date("M jS, Y", strtotime("".$journal_entry->date."")) }}  </td>
                
                </tr>

            </tbody>
    </table>
        </div>
        <div class='second_box'>
            <table id="bill_to">
            <tbody>

                <tr>
                    <td> &nbsp;</td> <td> &nbsp;</td>
                    <td> <b> Currency: </b>  </td>
                    <td>  Tanzanian Shillings </td>
                </tr>

            </tbody>
        </table>

        </div>

        <div class="charge_details">

    <table class="description" style="width:94%;">
        <thead>
            <tr>
                <th style="color: #040965; text-align: left;">Account</th>
                <th style="text-align: left; color:#040965">  Description </th>
                <th style="text-align: right; color:#040965" > Debit </th>
                <th style="text-align: right; color:#040965" > Credit </th>
               </tr>
        </thead>

        <tbody>
            @foreach ($journal_entry_items as $index => $item )
            <tr>
                <td style="text-align: left; color:black !important"> {{ ucwords($item->account_name) }} </td>
                <td>  {{ ucwords($item->description) }} </td>
                @if( $item->operation == "DEBIT")
                <td style="text-align: right; padding:8px;"> {{ number_format($item->amount)   }}  </td>
                <td> </td>
                @else
                <td> </td>
                <td style="text-align: right; padding:8px">  {{ number_format($item->amount)   }}  </td>
                @endif
            </tr>
            @endforeach

        </tbody>
       
    </table>
    <table  style="width:94%;">
        <thead>
               {{-- <tr>
                <th style="text-align: left; color:#040965; padding-bottom:10px; padding-left:340px"> TOTAL  PAYABLE </th>
                <th  style="background-color: #548235; color: white; text-align: right; padding:6px"> <strong>{{ number_format($particulars->amount)}}</strong> </th>
               </tr>

               <tr>
                <td colspan="15" style="color: #040965; width:100%; padding:5px; background-color:#D6EEEE"> AMOUNT IN WORDS: <p style="font-family: maserrati !important; display:inline"> <b> {{  Helper::inwords($particulars->amount)    }} Only </b> </p></td>
            </tr> --}}

        </thead>            
    </table>



</div>
</div>


<div id="footer">

<div style="text-align: center; margin-bottom:3%">
<p  style="text-align: center;"> Address:&nbsp; {{ $address }} </p>
<span  style="text-align: center;"> Phone: {{ $phone }} &nbsp;  </span>
<span  style="text-align: center;"> Email: &nbsp; {{ $email }} </span>
</div>
                        
</div>

</div>

</body>

    

</html>




















