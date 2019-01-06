<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use App\Models\Section;
use Illuminate\Http\Request;

use Response;

class ItemController extends Controller
{
    //
    public function index(Restaurant $restaurant)
    {
        $items = $restaurant->items()->paginate(20);
        return view('admin.items.index',compact('items','restaurant'));
    }

    public function create(Item $model,Restaurant $restaurant)
    {
        return view('admin.items.create',compact('model','restaurant'));
    }

    public function store(Request $request,Restaurant $restaurant)
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
        ]);
        
        $item = Item::create($request->all());
        if ($request->hasFile('photo'))
        {
            $photo = $request->file('photo');
            $destinationPath = public_path().'/uploads/items';
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111,99999).'.'.$extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given
            $item->photo =  'uploads/items/'.$name;
            $item->save();
        }
        
        flash()->success('تم إضافة الصنف بنجاح');
        return redirect('admin/'.$restaurant->id.'/item');
    }

    public function show($id)
    {
        
    }

    public function edit(Restaurant $restaurant,Item $model)
    {
        return view('admin.items.edit',compact('model','restaurant'));
    }

    public function update(Request $request ,Restaurant $restaurant, $item )
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'section_id' => 'required'
        ]);

        $item->update($request->all());
        if ($request->hasFile('photo'))
        {
            $photo = $request->file('photo');
            $destinationPath = public_path().'/uploads/items';
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time().''.rand(11111,99999).'.'.$extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given
            $item->photo =  'uploads/items/'.$name;
            $item->save();
        }

        flash()->success('تم تعديل بيانات الصنف بنجاح.');
        return redirect('admin/'.$restaurant->id.'/item/'.$item->id.'/edit');

    }

    public function destroy(Restaurant $restaurant ,$item)
    {
        // to do
        // delete addons and options
        $item ->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $item->id
        ];
        return Response::json($data, 200);
    }

    public function duplicate(Request $request, $restaurant, $item)
    {
        $addons = $item->addons;
        $newItem = $item->replicate();
        $newItem->save();
        foreach ($addons as $addon)
        {
            $newAddon = $addon->replicate();
            $newAddon->item_id = $newItem->id;
            $newAddon->save();

            $options = $addon->options;

            foreach ($options as $option)
            {
                $newOption = $option->replicate();
                $newOption->addon_id = $newAddon->id;
                $newOption->save();
            }
        }

        flash()->success('تم نسخ بيانات الصنف بنجاح.');
        return back();
    }
}
