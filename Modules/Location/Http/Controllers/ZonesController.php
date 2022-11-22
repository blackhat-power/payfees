<?php

namespace Modules\Location\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Location\Entities\Zone;
use Yajra\DataTables\DataTables;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink']='zones';
        return view('location::zones.index')->with($data);
    }


    public function zonesDatatable(){
        $zones = Zone::all();
        return DataTables::of($zones)

        ->addColumn('region', function($zone){
            
            return $zone->regions->count('id');

            })

        ->addColumn('action', function($zone){
            $button = '';
                    //    $button .= '  <a href="" class="button-icon button btn btn-sm rounded-small btn-warning  more-details-1"><i class="fa fa-eye m-0"></i></a>';
                       $button .= ' <a href="javascript:void(0)" data-edit_zone_id = '.$zone->id.' data-original-title="Edit"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-info  zoneEditBtn" ><i class="fa fa-edit  m-0"></i></a>';
                       $button .= ' <a href="javascript:void(0)" data-delete_zone_id ='.$zone->id.' data-original-title="Dlt"  data-toggle="tooltip" class="button-icon button btn btn-sm rounded-small btn-danger  zoneDltBtn" ><i class="fa fa-trash  m-0"></i></a>';
                 
            return '<nobr>'.$button. '</nobr>';

            })
        ->rawColumns(['action'])
        ->make();
    }


    public function destroyZone($id){
        try {
            $zone = Zone::find($id)->delete();

            if ($zone) {
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



       public function zoneStore(Request $request){

        try {
            DB::beginTransaction();

            $zone = Zone::updateOrCreate(
                [
                 'id'=>$request->zone_id
                ],
                [
                 'name'=>$request->zone,
                 'descriptions'=>$request->descriptions,

                ]
            );

            DB::commit();

            if ($zone) {
                //  return 'successful';
                if ($zone) {
                    $data = ['state'=>'Done', 'title'=>'Successful', 'msg'=>'Record deleted successful'];
                    return response()->json($data);
                }

                $data = ['state'=>'Fail', 'title'=>'Fail', 'msg'=>'Record could not be deleted'];
                return  response()->json($data);
            }
        }

         catch (QueryException $e) {
            //dd( $e->getMessage() ) ;
            $data = ['state'=>'Error', 'title'=>'Database error', 'msg'=>'Something went wrong!<br />' . $e->errorInfo[2]];
            return  response()->json($data);

        }
       

     
   }



   public function edit($id)
    {
       return $zone = Zone::find($id);

    }




}
