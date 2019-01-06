<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Response;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = Transaction::where(function($q) use($request) {
            if ($request->has('restaurant_id')){
                $q->where('restaurant_id',$request->restaurant_id);
            }
        })->latest()->paginate(20);
        return view('admin.transactions.index',compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Transaction $model
     * @return \Illuminate\Http\Response
     */
    public function create(Transaction $model)
    {
        return view('admin.transactions.create',compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'restaurant_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $transaction = new Transaction;
        $transaction->restaurant_id = $request->restaurant_id;
        $transaction->amount = $request->amount;
        $transaction->note = $request->note;
        $transaction->save();

        flash()->success('تم إضافة العملية المالية بنجاح');
        return redirect('admin/transaction');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Transaction::findOrFail($id);
        return view('admin.transactions.edit',compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'restaurant_id' => 'required',
            'amount' => 'required|numeric'
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->restaurant_id = $request->restaurant_id;
        $transaction->amount = $request->amount;
        $transaction->note = $request->note;
        $transaction->save();

        flash()->success('تم تعديل العملية المالية بنجاح.');
        return redirect('admin/transaction');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return response()->json($data, 200);
    }
}
