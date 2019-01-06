<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

use Response;

class RegionController extends Controller
{
    //
    public function index()
    {
        $regions = Region::paginate(20);
        return view('admin.regions.index',compact('regions'));
    }

    public function create(Region $model)
    {
        return view('admin.regions.create',compact('model'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required'
        ]);

        Region::create($request->all());

        flash()->success('تم إضافة المنطقة بنجاح');
        return redirect('admin/region');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $model = Region::findOrFail($id);

        return view('admin.regions.edit',compact('model'));
    }

    public function update(Request $request , $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required'
        ]);

        Region::findOrFail($id)->update($request->all());

        flash()->success('تم تعديل بيانات المنطقة بنجاح.');
        return redirect('admin/region/'.$id.'/edit');

    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);
        $count = $region->restaurants()->count();
        if ($count > 0)
        {
            $data = [
                'status' => 0,
                'msg' => 'لا يمكن مسح المنطقة ، يوجد مطاعم مسجلة بها'
            ];
            return Response::json($data, 200);
        }
        $region->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);
    }
}
