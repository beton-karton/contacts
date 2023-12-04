<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactModel;

class Contacts extends Component
{
    public $firstName, $lastName, $phone, $email;
    public $contact, $contacts;
    public $contactId = null;
    public $searchString = '';
    public $is_edit = false;
    public $search = false;

    public function render()
    {
            $letters = ContactModel::distinct()
                      ->selectRaw("SUBSTR(firstName, 1, 1) AS firstLetter")
                      ->where(function($query){
                        $query->where('firstName','like','%'.$this->searchString.'%')
                        ->orWhere('lastName','like','%'.$this->searchString.'%');
                      })
                      ->orderBy('firstLetter')
                      ->get();
              foreach($letters as $letter){
                  $letter->contacts = ContactModel::where('firstName','like', $letter->firstLetter.'%')
                        ->where(function($query){
                            $query->where('firstName','like','%'.$this->searchString.'%')
                            ->orWhere('lastName','like','%'.$this->searchString.'%');
                        })
                          ->orderBy('firstName')
                          ->get();
              }

        $this->contacts = $letters;
        return view('livewire.contacts');
    }
    public function selectContact($id)
    {
        $this->contactId = $id;
        $this->contact = ContactModel::find($id);
    }
    public function addContact()
    {
        $this->firstName = null;
        $this->lastName = null;
        $this->phone = null;
        $this->email = null;

        $this->dispatch('show_contactModal');
    }
    public function editContact()
    {
        $this->is_edit = true;
        $this->firstName = $this->contact->firstName;
        $this->lastName = $this->contact->lastName;
        $this->phone = $this->contact->phone;
        $this->email = $this->contact->email;
        $this->dispatch('show_contactModal');
    }
    public function saveContact()
    {
        if(!$this->is_edit){
            $contact = ContactModel::create([
                'firstName' => trim($this->firstName),
                'lastName' => trim($this->lastName),
                'phone' => $this->phone,
                'email' => $this->email
            ]);
            $this->contactId = $contact->id;
            $this->contact = $contact;
        }else{
            $contact = ContactModel::find($this->contactId);
            $contact->firstName = trim($this->firstName);
            $contact->lastName = trim($this->lastName);
            $contact->phone = $this->phone;
            $contact->email = $this->email;
            $contact->save();
            $this->contact = $contact;
        }
        $this->is_edit = false;
        $this->dispatch('hide_contactModal');
    }
    public function delContact()
    {
        $this->dispatch('show_confirmModal');
    }    public function deleteContact()
    {
        $contact = ContactModel::find($this->contactId);
        $contact->delete();
        $this->contactId = null;
        $this->dispatch('hide_confirmModal');
    }
    public function makeSearch()
    {
        $this->search = !$this->search;
    }
    public function clearSearch()
    {
        $this->searchString = '';
    }
}
