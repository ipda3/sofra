<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Client;
use Response;


class ClientController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $clients = Client::with('region')->paginate(20);
    return view('admin.clients.index',compact('clients'));
  }

  /**
   * Show the form for creating a new resource.1
   *
   * @return Response
   */
  public function create()
  {
    $model = new Client;
    return view('admin.clients.create',compact('model'));
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
      $client = Client::create($request->all());

      flash()->success('تمت الإضافة بنجاح');
      return redirect('admin/client');


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
      $model = Client::findOrFail($id);
      return view('admin.clients.edit',compact('model'));
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
      $client = Client::findOrFail($id);
      $client->update($request->all());

      flash()->success('تم تعديل بيانات العرض بنجاح');
      return redirect('admin/client/'.$id.'/edit');
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $client = Client::findOrFail($id);
      $client->delete();
      $data = [
          'status' => 1,
          'msg' => 'تم الحذف بنجاح',
          'id' => $id
      ];
      return Response::json($data, 200);
  }
  
}

?>