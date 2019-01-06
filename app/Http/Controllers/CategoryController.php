<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Category;
use Response;


class CategoryController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $categories = Category::paginate(20);
    return view('admin.categories.index',compact('categories'));
  }

  /**
   * Show the form for creating a new resource.1
   *
   * @return Response
   */
  public function create()
  {
    $model = new Category;
    return view('admin.categories.create',compact('model'));
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
      Category::create($request->all());
      flash()->success('تم إضافة القسم بنجاح');
      return redirect('admin/category');


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
      $model = Category::findOrFail($id);
      return view('admin.categories.edit',compact('model'));
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
      Category::findOrFail($id)->update($request->all());
      flash()->success('تم تعديل بينات القسم بنجاح');
      return redirect('admin/category');
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
      $category = Category::findOrFail($id);
      $count = $category->restaurants()->count();
      if ($count > 0)
      {
          $data = [
              'status' => 0,
              'msg' => 'لا يمكن مسح التصنيف ، يوجد مطاعم مسجلة به'
          ];
          return Response::json($data, 200);
      }
      $category->delete();
      $data = [
          'status' => 1,
          'msg' => 'تم الحذف بنجاح',
          'id' => $id
      ];
      return Response::json($data, 200);
  }
  
}

?>