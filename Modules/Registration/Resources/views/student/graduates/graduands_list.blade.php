


    <div class="card">
        <div  class="card-header">
            <div class="row">
        
                <div class="col-md-4">
                    <input type="text" id="search_table"  placeholder="search" class="form-control form-control-sm">
                </div>
        
            </div>
        </div>
                <div class="card-body">
                    <form method="post" id="graduands_form" action="">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Current Session</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="myTable">
                            @foreach($students->sortBy('account_student_details.name') as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img class="rounded-circle" style="height: 30px; width: 30px;" src="{{ asset('storage/student_profile_pics/'.$student->profile_pic) }}" alt="img"></td>
                                    <td>{{ ucwords($student->full_name) }} </td>
                                    <td>{{ $old_year }}</td>
                                    <td>
                                       <div class="d-inline-block mr-3">
                                            <input type="checkbox" name="p-{{$student->id}}"  value="G" class="checkbox-input checkboxes" checked>
                                            <input type="hidden" name="p-{{$student->id}}"  value="D" disabled>
                                        </div> 
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                    <div class="text-center mt-3">
                        <button class="btn btn-sm btn-success" id="graduate_students"><i class="fas fa-chevron-circle-up"></i> Graduate Students</button>
                    </div>
                </div>
        
            </div>
        
        
        
        