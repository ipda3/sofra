<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Contact;
use Response;


class ContactController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $contacts = Contact::latest()->paginate(20);
    return view('admin.contacts.index',compact('contacts'));
  }

  /**
   * Show the form for creating a new resource.1
   *
   * @return Response
   */
  public function create()
  {
    $model = new Contact;
    return view('admin.contacts.create',compact('model'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $this->validate($request,[
          'title' => 'required'
      ]);
      $contact = Contact::create($request->all());

      flash()->success('تم إضافة العرض بنجاح');
      return redirect('admin/contact');


  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
      $model = Contact::findOrFail($id);
      return view('admin.contacts.edit',compact('model'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id , Request $request)
  {
      $this->validate($request,[
          'title' => 'required'
      ]);
      $contact = Contact::findOrFail($id);
      $contact->update($request->all());

      flash()->success('تم تعديل بيانات العرض بنجاح');
      return redirect('admin/contact/'.$id.'/edit');
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $contact = Contact::findOrFail($id);
      $contact->delete();
      $data = [
          'status' => 1,
          'msg' => 'تم الحذف بنجاح',
          'id' => $id
      ];
      return Response::json($data, 200);
  }
  
}

?>