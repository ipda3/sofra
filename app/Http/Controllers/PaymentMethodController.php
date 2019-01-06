<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\PaymentMethod;
use Response;


class PaymentMethodController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $payment_methods = PaymentMethod::paginate(20);
    return view('admin.payment_methods.index',compact('payment_methods'));
  }

  /**
   * Show the form for creating a new resource.1
   *
   * @return Response
   */
  public function create()
  {
    $model = new PaymentMethod;
    return view('admin.payment_methods.create',compact('model'));
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
      PaymentMethod::create($request->all());
      flash()->success('تمت الإضافة بنجاح');
      return redirect('admin/payment-method');


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
      $model = PaymentMethod::findOrFail($id);
      return view('admin.payment_methods.edit',compact('model'));
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
      PaymentMethod::findOrFail($id)->update($request->all());
      flash()->success('تم التعديل بنجاح');
      return redirect('admin/payment-method');
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $record = PaymentMethod::findOrFail($id);
      $count = $record->orders()->count();
      if ($count > 0)
      {
          $data = [
              'status' => 0,
              'msg' => 'لا يمكن مسح التصنيف ، يوجد مطاعم مسجلة به'
          ];
          return Response::json($data, 200);
      }
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