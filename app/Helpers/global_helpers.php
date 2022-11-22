<?php
namespace App\Helpers;

use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Modules\Registration\Entities\AccountStudentDetail;





    function number_to_words($number){

        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $f->format($number);

        

    }

class Helper{
   
 public static function debtors_list_count(){
    $debtors_count = 0;
    $debtors = AccountStudentDetail::select('account_student_details.*',DB::raw("SUM(receipt_items.quantity* receipt_items.rate ) as pd_amnt"),
    DB::raw("SUM(invoice_items.rate * invoice_items.quantity ) as bll_amnt"
    ))
  ->join('accounts','account_student_details.account_id','=','accounts.id')
  ->join('invoices','accounts.id','=','invoices.account_id')
  ->join('invoice_items','invoices.id','=','invoice_items.invoice_id')
  ->leftjoin('receipts','invoices.id','=','receipts.invoice_id')
  ->leftjoin('receipt_items','receipts.id','=','receipt_items.receipt_id')
  ->groupBy(['account_student_details.id'])->get();
  $data = [];
  foreach($debtors as $debtor){
      
      $student = AccountStudentDetail::find($debtor->id);
      $billed_amount = $student->debt_amount;
      $paid_amount = $student->paid_amount;
      $balance =  $billed_amount - $paid_amount;
      if($balance){
        $debtors_count += 1;
          $data [] = ['name' => $student->full_name, 'student_id'=>$student->id, 'billed_amount'=>$billed_amount, 'amount_paid'=>$paid_amount, 'balance'=>$balance ]; 

      }
  }

 return $debtors_count;


} 


public static function add_leading_zeros($number, $length = 4)
    {
    $difference = $length - strlen($number);
    $ret_val = '';
    for ($i = 0; $i < $difference; $i++) {
        $ret_val .= '0';
    }
    return $ret_val .= $number;
    }


    public static function pendingPaymentsApproval(){
        $invoices = Invoice::select('invoices.*')
        ->join('accounts','invoices.account_id','=','accounts.id')
        ->join('account_student_details','accounts.id','=','account_student_details.account_id')
        ->join('receipts','invoices.id','receipts.invoice_id')
        ->where('receipts.status',1)->count();
        return $invoices;
    }


    public static function format_message($message,$type)
    {
         return '<p class="alert alert-'.$type.'">'.$message.'</p>';
    }


    public static function inwords(float $num, $code_name = 'Tanzanian Shillings')
    {

        $num = str_replace(array(',', ' '), '' , trim($num));
        if(! $num) {
            return false;
        }
        $amount_after_decimal = round($num - ($dec = floor($num)), 2) * 100;
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );

        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }

        $thisClass = new self();
        $get_cents = ($amount_after_decimal > 0) ? "And " . $thisClass->getCents($amount_after_decimal) . ' Cents' : '';
        return ucwords(implode(' ', $words) .' '. $code_name.' '.$get_cents );
    }



    }




   
   



   


 


    


   



    