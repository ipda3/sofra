<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\DeliveryMethod;
use Response;


class DeliveryMethodController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $delivery_methods = DeliveryMethod::paginate(20);
    return view('admin.delivery_methods.index',compact('delivery_methods'));
  }

  /**
   * Show the form for creating a new resource.1
   *
   * @return Response
   */
  public function create()
  {
    $model = new DeliveryMethod;
    return view('admin.delivery_methods.create',compact('model'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
      $this->validate($request,[
          'name' => 'required'
      ]);
      DeliveryMethod::create($request->all());
      flash()->success('تمت الإضافة بنجاح');
      return redirect('admin/delivery-method');


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
      $model = DeliveryMethod::findOrFail($id);
      return view('admin.delivery_methods.edit',compact('model'));
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
          'name' => 'required',
      ]);
      DeliveryMethod::findOrFail($id)->update($request->all());
      flash()->success('تم التعديل بنجاح');
      return redirect('admin/delivery-method');
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $record = DeliveryMethod::findOrFail($id);
      $record->delete();
      $data = [
          'status' => 1,
          'msg' => 'تم الحذف بنجاح',
          'id' => $id
      ];
      return Response::json($data, 200);
  }
  
}

?>