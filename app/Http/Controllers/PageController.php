<?php
namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\City;
use App\Models\Page;
use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class PageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = Page::paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Page $model)
    {
        return view('admin.pages.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        $page = Page::create($request->all());

        flash()->success('تم إضافة الصفحة بنجاح');
        return redirect('admin/page');
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
        $model = Page::findOrFail($id);
        return view('admin.pages.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);
        Page::findOrFail($id)->update($request->all());

        flash()->success('تم تعديل  الصفحة بنجاح.');
        return redirect('admin/page/'.$id.'/edit');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $source = Page::findOrFail($id);

        $source->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);
    }


}

