<?php


namespace App\Imports;

// use App\Group;
// use App\Models\Account;
// use App\Models\Contact;
// use App\Models\ContactPerson;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;
// use Maatwebsite\Excel\Row;
// use Maatwebsite\Excel\Concerns\OnEachRow;
// use Modules\Configuration\Entities\AccountSchoolDetail;
// use Modules\Registration\Entities\AccountStudentDetail;


namespace App\Imports;

use App\Models\Account;
use App\Models\Contact;
use App\Models\ContactPerson;
use App\Models\User as ModelsUser;
use App\User;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Configuration\Entities\AccountSchoolDetailClass;
use Modules\Configuration\Entities\AccountSchoolDetailStream;
use Modules\Registration\Entities\AccountStudentDetail;

class StudentImport implements ToCollection,WithHeadingRow
{
    public $stream;
    public $class;

    public function __construct($class,$stream)
    {
        $this->class = $class;
        $this->stream = $stream;
        
    }

    public function collection(Collection $rows)
    {

        // var_dump($this->stream);
        // exit();

foreach ($rows as $row) {
    $full_name = $row['first_name'] .' '. $row['middle_name'] . ' '. $row['last_name'];
    $account =   Account::firstOrCreate(
        [
         'name'=>$full_name,
        ],
        [
            // 'name'=>$full_name,
            'created_by'=>auth()->user()->id,
        ]
    );

    if ($account) {
        if ($row['gender'] == 'male') {
            $avatar = 'man_avatar.png';
        } else {
            $avatar = 'avatar-woman.png';
        }
       $dob = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d');
       

        $student_detail =  AccountStudentDetail::firstOrCreate(
            [
             'account_id'=>$account->id
            ],
            [
                'account_id'=>$account->id,
                'first_name'=>$row['first_name'],
                'middle_name'=>$row['middle_name'],
                'last_name'=>$row['last_name'],
                'gender'=>$row['gender'],
                'admitted_year'=>$row['admitted_year'],
                'dob'=>$dob,
                'session'=>AccountSchoolDetail::select('account_school_details.*')->first()->current_session,
                'account_school_details_id'=>AccountSchoolDetail::select('account_school_details.*')->first()->id,
                'account_school_details_class_id'=>$this->class,
                'account_school_detail_stream_id'=>$this->stream,
                'profile_pic'=>$avatar

            ]
        );


        


        if ($student_detail) {
            
            $contacts = Contact::where('contactable_id', $student_detail->id)->delete();

            Contact::create(
                [
                    'contact_type_id'=>1,
                    'contact'=>$row['phone'],
                    'contactable_id' => $student_detail->id,
                    'contactable_type' => AccountStudentDetail::class,

                ]
            );

            Contact::create(
                [
                    'contact_type_id'=>2,
                    'contact'=>$row['email'],
                    'contactable_id' => $student_detail->id,
                    'contactable_type' => AccountStudentDetail::class,

                ]
            );


            Contact::create(
                [
                    'contact_type_id'=>3,
                    'contact'=>$row['address'],
                    'contactable_id' => $student_detail->id,
                    'contactable_type' => AccountStudentDetail::class,

                ]
            );

            ContactPerson::where('personable_id',$student_detail->id)->delete();

            if( $row['father_name'] && $row['father_occupation'] ){

                $father = ContactPerson::create(
                    [
                    'full_name'=>$row['father_name'],
                    'occupation'=>$row['father_occupation'],
                    'relationship'=>'FATHER',
                    'personable_type' => AccountStudentDetail::class,
                    'personable_id' => $student_detail->id,
    
                    ]
                );
    
                Contact::where('contactable_id',$father->id)->where('contactable_type',ContactPerson::class)->delete();
    
                if ($father) {
                    Contact::create(
                        [
                            'contact_type_id'=>1,
                            'contact'=>$row['father_phone'],
                            'contactable_id' => $father->id,
                            'contactable_type' => ContactPerson::class,
    
                        ]
                    );
                }

            }



            if( $row['mother_name'] && $row['mother_occupation'] ){

                $mother = ContactPerson::create(
                    [
                    'full_name'=>$row['mother_name'],
                    'occupation'=>$row['mother_occupation'],
                    'relationship'=>'MOTHER',
                    'personable_type' => AccountStudentDetail::class,
                    'personable_id' => $student_detail->id,
    
                    ]
                );
    
                Contact::where('contactable_id',$mother->id)->where('contactable_type',ContactPerson::class)->delete();
    
                if ($mother) {
    
                    Contact::create(
    
                        [
                            'contact_type_id'=>1,
                            'contact'=>$row['mother_phone'],
                            'contactable_id' => $mother->id,
                            'contactable_type' => ContactPerson::class,
    
                        ]
                                );
    
                }


            }

            if($row['guardian_name'] && $row['guardian_occupation'] ){

            $guardian = ContactPerson::create(
                [
                'full_name'=>$row['guardian_name'],
                'occupation'=>$row['guardian_occupation'],
                'relationship'=>'GUARDIAN',
                'personable_type' => AccountStudentDetail::class,
                'personable_id' => $student_detail->id,

                ]
            );

            Contact::where('contactable_id',$guardian->id)->where('contactable_type',ContactPerson::class)->delete();

            if ($guardian) {
                $final_store =  Contact::create(
                    [
                        'contact_type_id'=>1,
                        'contact'=>$row['guardian_phone'],
                        'contactable_id' => $guardian->id,
                        'contactable_type' => ContactPerson::class,

                    ]
                );
            }

            }

        }
    }
}

    DB::commit();
}

}












// class StudentImport implements OnEachRow
// {
//     public function onRow(Row $row){}

    // public function onRow(Row $row)
    // {
    //     $rowIndex = $row->getIndex();
    //     return $row      = $row->toArray();

    //         DB::beginTransaction();

    //         $full_name = $row['first_name'] .' '. $row['middle_name'] . ' '. $row['last_name'];
    //        $account =   Account::create(
    //             [
    //                 'name'=>$full_name,
    //                 'created_by'=>auth()->user()->id,
    //             ]

    //             );
                

    //             User::create(
    //                 [

    //                 ]
    //                 );

    //             if($account){
    //             //    return $class = $request->students_stream;
    //                  if($row['gender'] == 'male'){
    //                      $avatar = 'man_avatar.png';
    //                  }
    //                  else{
    //                     $avatar = 'avatar-woman.png';
    //                  }
    //                $student_detail =  AccountStudentDetail::create(
    //                     [
    //                         'account_id'=>$account->id,
    //                         'first_name'=>$row['first_name'],
    //                         'middle_name'=>$row['middle_name'],
    //                         'last_name'=>$row['last_name'],
    //                         'gender'=>$row['gender'],
    //                         'admitted_year'=>$row['admitted_year'],
    //                         'dob'=>$row['dob'],
    //                         'session'=>AccountSchoolDetail::select('account_school_details.*')->first()->current_session,
    //                         'account_school_details_id'=>AccountSchoolDetail::select('account_school_details.*')->first()->id,
    //                         'account_school_details_class_id'=>$row['students_class'],
    //                         'account_school_detail_stream_id'=>$row['students_stream'],
    //                         'profile_pic'=>$avatar

    //                     ]
    //                     );


    //                 Contact::create(
    //                     [
    //                         'contact_type_id'=>1,
    //                         'contact'=>$row['phone'],
    //                         'contactable_id' => $student_detail->id,
    //                         'contactable_type' => AccountStudentDetail::class,

    //                     ]);

    //                     Contact::create(
    //                         [
    //                             'contact_type_id'=>2,
    //                             'contact'=>$row['email'],
    //                             'contactable_id' => $student_detail->id,
    //                             'contactable_type' => AccountStudentDetail::class,
    
    //                         ]);


    //                         Contact::create(
    //                             [
    //                                 'contact_type_id'=>3,
    //                                 'contact'=>$row['address'],
    //                                 'contactable_id' => $student_detail->id,
    //                                 'contactable_type' => AccountStudentDetail::class,
        
    //                             ]);


    //                     $father = ContactPerson::create(
    //                         [
    //                         'full_name'=>$row['father_name'],
    //                         'occupation'=>$row['father_occupation'],
    //                         'relationship'=>'FATHER',
    //                         'personable_type' => AccountStudentDetail::class,
    //                         'personable_id' => $student_detail->id,
     
    //                     ]);

    //                 Contact::create(
    //                     [
    //                         'contact_type_id'=>1,
    //                         'contact'=>$row['father_phone'],
    //                         'contactable_id' => $father->id,
    //                         'contactable_type' => ContactPerson::class,

    //                     ]);

    //                     $mother = ContactPerson::create(
    //                         [
    //                         'full_name'=>$row['mother_name'],
    //                         'occupation'=>$row['mother_occupation'],
    //                         'relationship'=>'MOTHER',
    //                         'personable_type' => AccountStudentDetail::class,
    //                         'personable_id' => $student_detail->id,
     
    //                         ]
    //                                                 );

    //                     Contact::create(
    //                         [
    //                             'contact_type_id'=>1,
    //                             'contact'=>$row['mother_phone'],
    //                             'contactable_id' => $mother->id,
    //                             'contactable_type' => ContactPerson::class,
    
    //                         ]
    //                     );


    //                     $guardian = ContactPerson::create(
                            
    //                         [
    //                         'full_name'=>$row['guardian_name'],
    //                         'occupation'=>$row['guardian_occupation'],
    //                         'relationship'=>'GUARDIAN',
    //                         'personable_type' => AccountStudentDetail::class,
    //                         'personable_id' => $student_detail->id,
     
    //                     ]);

    //                 $final_store =  Contact::create(
    //                         [
    //                             'contact_type_id'=>1,
    //                             'contact'=>$row['guardian_phone'],
    //                             'contactable_id' => $guardian->id,
    //                             'contactable_type' => ContactPerson::class,
    
    //                         ]
    //                     );
    //             }
    //       DB::commit();


    // }
// }




// AccountStudentDetail([
//     "first_name" => $row[0],
//     "middle_name" => $row[1],
//     "last_name" => $row[2],
//     "gender" => $row[3],
//     "dob" => $row[4],
//     "class" => $row[5], // User Type User
//     "stream" => $row[6],
//     ""=>$row[7],
// ]);