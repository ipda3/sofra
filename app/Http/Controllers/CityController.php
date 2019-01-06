<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

use App\Http\Requests;

use Response;

class CityController extends Controller
{
    //
    public function index()
    {
        $cities = City::paginate(20);

        return view('admin.cities.index',compact('cities'));
    }

    public function create(City $model)
    {
        return view('admin.cities.create',compact('model'));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        City::create($request->all());

        flash()->success('تم إضافة المدينة بنجاح');
        return redirect('admin/city');
    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $model = City::findOrFail($id);
        return view('admin.cities.edit',compact('model'));
    }

    public function update(Request $request , $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        City::findOrFail($id)->update($request->all());

        flash()->success('تم تعديل بيانات المدينة بنجاح.');
        return redirect('admin/city/'.$id.'/edit');

    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);

        $city->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);
    }
}
