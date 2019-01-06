<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Offer;
use Response;


class OfferController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $offers = Offer::with('restaurant')->paginate(20);
    return view('admin.offers.index',compact('offers'));
  }

  /**
   * Show the form for creating a new resource.1
   *
   * @return Response
   */
  public function create()
  {
    $model = new Offer;
    return view('admin.offers.create',compact('model'));
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
      $offer = Offer::create($request->all());

      flash()->success('تم إضافة العرض بنجاح');
      return redirect('admin/offer');


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
      $model = Offer::findOrFail($id);
      return view('admin.offers.edit',compact('model'));
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
      $offer = Offer::findOrFail($id);
      $offer->update($request->all());

      flash()->success('تم تعديل بيانات العرض بنجاح');
      return redirect('admin/offer/'.$id.'/edit');
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $offer = Offer::findOrFail($id);
      $offer->delete();
      $data = [
          'status' => 1,
          'msg' => 'تم الحذف بنجاح',
          'id' => $id
      ];
      return Response::json($data, 200);
  }
  
}

?>