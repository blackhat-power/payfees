<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\Region;
use Modules\Location\Entities\Zone;
use Yajra\DataTables\DataTables;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink']='regions';
        $data['zones'] = Zone::all();

        return view('location::regions.index')->with($data);

    }


    public function regionsDatatable(){


        $regions = Region::with('zone')->with('districts')->get();
       
        


        return DataTables::of($regions)

        ->addColumn('zone',function($region){
            return $zone = $region->zone->name;

        })

        ->addColumn('districts',function($region){
            return $districts = $region->districts_count;

        })

        ->addColumn('wards',function($region){

          return  $wards = $region->wardzsCount->count('id');
             
         })

        ->addColumn('action', function($region){
            $button = '';
                    //    $button .= '  <a href="" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                       $button .= ' <a href="" data-edit_region_id = '.$region->id.' data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  rgnEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
                       $button .= ' <a href="" data-delete_region_id ='.$region->id.'  data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  rgnDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
                 
            return '<nobr>'.$button. '</nobr>';

            })
      ->rawColumns(['action'])
      ->make();


    }



    public function destroyRegion($id){
        try {
            $region = Region::find($id)->delete();

            if ($region) {
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



       public function regionStore(Request $request){

        try {
            DB::beginTransaction();
            $region = Region::updateOrCreate(
                [
                 'id'=>$request->region_id
                ],
                [
                 'name'=>$request->region_name,
                 'zone_id'=>$request->zone,
                 'post_code'=>$request->post_code,
                 'descriptions'=>$request->descriptions,

                ]
         );

         DB::commit();

         if ($region) {
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
        $data['activeLink']='regions';
       return $region = Region::find($id);

    }


    public function create()
    {
        return view('location::create');
    }

 
}
