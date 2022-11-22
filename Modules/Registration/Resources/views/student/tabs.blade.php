<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link  {{  $current_tab == 'profile_detail' ? 'active' : ''}} " id="profile"  href="{{ route('students.profile',$student->id)   }}" role="tab">Profile</a>
     </li>
    <li class="nav-item">  
       <a class="nav-link {{  $current_tab == 'contact_people' ? 'active' : ''}} " href="{{ route('student.profile.contact.people',$student->id)    }}" role="tab">Contact People</a>
    </li>
    <li class="nav-item">
     <a class="nav-link  {{  $current_tab == 'invoice_list' ? 'active' : ''}}" href="{{ route('student.profile.view.invoices',$student->id)}}" role="tab">Invoices List</a>
  </li>
    <li class="nav-item">
       <a class="nav-link {{  $current_tab == 'attachments' ? 'active' : ''}}"  href="{{ route('student.profile.view.attachments',$student->id)}}" role="tab">Attachments</a>
    </li>
 </ul>