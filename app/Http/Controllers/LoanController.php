<?php
/**
 * Created by PhpStorm.
 * User: hatdao
 * Date: 7/30/18
 * Time: 11:58 PM
 */

namespace App\Http\Controllers;


use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    protected $model;

    public function __construct(Loan $loan)
    {
        $this->model = $loan;
    }

    public function index()
    {
        return $this->model->all();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->model::$rules);

        return $this->model::with('user', 'package')->create($request->only($this->model->fillable));
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        return $this->model->update($request->only($this->model->getModel()->fillable), $id);
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }

    public function pay(Request $request, $id)
    {
        $loan = $this->model->find($id);
        $firstUnpaidPayment = $loan->getFirstUnpaidPayment();
        return $firstUnpaidPayment->generatePayUrl();
    }
}