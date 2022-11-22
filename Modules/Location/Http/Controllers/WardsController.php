<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\District;
use Modules\Location\Entities\Region;
use Modules\Location\Entities\Ward;
use Yajra\DataTables\DataTables;

class WardsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink']='wards';
        $data['districts'] = District::all();
        $data['regions']=Region::all();
        return view('location::wards.index')->with($data);
    }

    public function wardsDatatable(){
        $wards = Ward::with('district');
        // $districts = District::all();
        
        return DataTables::of($wards)

        ->addColumn('district',function($ward){
            return $zone = $ward->district->name;

        })

        ->addColumn('zone',function($ward){
            return $zone = $ward->district->region->zone->name;

        })

        ->addColumn('region',function($ward){
            return $region = $ward->district->region->name;   

        })

        ->addColumn('action', function($ward){
            $button = '';
                    //    $button .= '  <a href="javascript:void(0)" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                       $button .= ' <a href="javascript:void(0)" data-edit_ward_id = '.$ward->id.' data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  wardEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
                       $button .= ' <a href="javascript:void(0)" data-delete_ward_id ='.$ward->id.'  data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  wardDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
                 
            return '<nobr>'.$button. '</nobr>';

            })
      ->rawColumns(['action'])
      ->make();


    }



    public function destroyWard($id){
        try {
            $ward = Ward::find($id)->delete();
            if ($ward) {
                $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record deleted successful'];
                return response()->json($data);

            }

            $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
            return  response()->json($data);

        } catch (QueryException $e) {
            //dd( $e->getMessage() ) ;
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response()->json($data);

        } 
    
       }



       public function wardStore(Request $request){

            //  return  $request->all();

        try {
            DB::beginTransaction();
            $ward = Ward::updateOrCreate(
                [
                 'id'=>$request->ward_id
                ],
                [
                 'name'=>$request->ward_name,
                 'district_id'=>$request->district_id,
                 'post_code'=>$request->post_code,
                 'descriptions'=>$request->descriptions,

                ]
         );

         DB::commit();

         if ($ward) {
            $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record created successful'];
            return response()->json($data);

        }

        $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be created'];
        return  response()->json($data);

    } catch (QueryException $e) {
        //dd( $e->getMessage() ) ;
        $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
        return  response()->json($data);

    }

     
   }



   public function edit($id)
    {
        $data['activeLink']='districts';

       return $district = Ward::find($id);

    }





}
