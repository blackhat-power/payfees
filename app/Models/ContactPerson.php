<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactPerson extends Model
{
    use HasFactory;
    protected $fillable = [
        'personable_type',
        'personable_id',
        'relationship',
        'full_name',
        'occupation'
    ];

    public function personable(){
        return $this->morphTo();  
    }
    
    public function contacts(){
        return $this->morphMany(Contact::class,'contactable');
    }

    public function getContactsAttribute()
    {
        $contacts = Contact::where('contactable_type', 'App\Models\ContactPerson')
        ->where('contactable_id', $this->id)
            ->whereIn('contact_type_id', [1, 2, 3])
            ->groupBy('contact_type_id')
            ->get();
        return $contacts ? $contacts : [];
    }
    public function getEmailAttribute(){ 
        
        $contacts = Contact::where('contactable_type', 'App\Models\ContactPerson')
            ->where('contactable_id', $this->id)
            ->where('contact_type_id', 2)
            ->first();
        return $contacts ? $contacts->contact : [];
     }

    public function getAddressAttribute(){ 
        
        $contacts = Contact::where('contactable_type', 'App\Models\ContactPerson')
            ->where('contactable_id', $this->id)
            ->where('contact_type_id', 3)
            ->first();
        return $contacts ? $contacts->contact : [];
     }

     public function getPhoneAttribute(){ 
        $contacts = Contact::where('contactable_type', 'App\Models\ContactPerson')
            ->where('contactable_id', $this->id)
            ->where('contact_type_id', 1)
            ->first();
        return $contacts ? $contacts->contact : [];
     }




}
