<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\District;
use Modules\Location\Entities\Region;
use Yajra\DataTables\DataTables;

class DistrictsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink']='districts';
        $data['regions'] = Region::all();
        return view('location::districts.index')->with($data);
    }

  
    public function districtsDatatable(){
        $districts = District::with('region');
        // $districts = District::all();
        
        return DataTables::of($districts)

        ->addColumn('zone',function($district){
            return $zone = $district->region->zone->name;

        })

        ->addColumn('region',function($district){
            return $region = $district->region->name;   

        })

        ->addColumn('wards',function($district){

          return  $district->wards->count('id');
             
         })

        ->addColumn('action', function($district){
            $button = '';
                    //    $button .= '  <a href="" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                       $button .= ' <a href="" data-edit_district_id = '.$district->id.' data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  dstrctEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
                       $button .= ' <a href="" data-delete_district_id ='.$district->id.'  data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  dstrctDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
                 
            return '<nobr>'.$button. '</nobr>';

            })
      ->rawColumns(['action'])
      ->make();


    }



    public function destroyDistrict($id){
        try {
            $district = District::find($id)->delete();


            if ($district) {
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



       public function districtStore(Request $request){

            // return  $request->all();

        try {
            DB::beginTransaction();
            $district = District::updateOrCreate(
                [
                 'id'=>$request->district_id
                ],
                [
                 'name'=>$request->district_name,
                 'region_id'=>$request->region_id,
                 'post_code'=>$request->post_code,
                 'descriptions'=>$request->descriptions,

                ]
         );

         DB::commit();
         if ($district) {
            $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record creqted successful'];
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

       return $district = District::find($id);

    }

}
