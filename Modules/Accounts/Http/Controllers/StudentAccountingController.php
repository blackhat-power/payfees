<?php

namespace Modules\Accounts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Configuration\Entities\AccountSchoolDetail;
use Modules\Registration\Entities\AccountStudentDetail;

class StudentAccountingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['activeLink'] = 'create_invoice';
    //    return auth()->user()->id;
        $data['student'] = $student = AccountStudentDetail::join('account_school_detail_classes','account_student_details.account_school_details_class_id','=','account_school_detail_classes.id')
                                            ->where('account_student_details.id',auth()->user()->id)
                                            ->first();
    //    return $data['class'] = $student->classes;
        $data['session'] = AccountSchoolDetail::first()->current_session;
        
        
        return view('accounts::payments.student.create_invoice')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('accounts::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('accounts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('accounts::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
