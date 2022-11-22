<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Students List</title>
</head>
<body>

<table>
    <thead>
    <tr>
            <th>SN</th>
            <th>Date</th>
            <th>Invoice No.</th>
            <th>Student</th>
            <th>Gender</th>
            <th>Amount Billed</th>
            <th>Amount Paid</th>
            <th>Balance</th>
    </tr>
    </thead>

   <tbody>


        @foreach ($invoices  as $loop => $invoice)  
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td></td>
            <td> {{  App\Models\Account::find($invoice->account_id)->students[0]->full_name;      }} </td>
            <td>  {{   date("jS  F, Y", strtotime(App\Models\Account::find($invoice->account_id)->students[0]->dob)) }} </td>
            <td>  {{  App\Models\Account::find($invoice->account_id)->students[0]->gender }} </td>
            <td> 
                
                @php
                     $bill_model = $invoice->BilledAmount;
                    $amount = 0;
                    foreach ($bill_model as $bill) {
                        $amount += $bill->billed_amount;
                    }
                    echo  number_format($amount); 
                @endphp            
            </td>

            <td>    
                @php
   
                   $receipts = $invoice->receipts;
                   $receipt_items = 0;
                   foreach($receipts as $receipt_item){
                       $receipt_items += $receipt_item->receiptItems()->sum('rate');
                   }
   
                   echo number_format($receipt_items);
                    
                @endphp
                 
               </td>

               <td>

                @php
                    $receipts = $invoice->receipts;
            $receipt_items = 0;
            foreach($receipts as $receipt_item){
                $receipt_items += $receipt_item->receiptItems()->sum('rate');
            }
        echo number_format($invoice->invoiceItems()->sum('rate') - $receipt_items);  
                @endphp

            </td>

        </tr>
        @endforeach

   
    </tbody>
</table>

</body>
</html>

