<?php
/**
 * Created by PhpStorm.
 * User: hatdao
 * Date: 7/30/18
 * Time: 11:58 PM
 */

namespace App\Http\Controllers;


use App\Models\Repayment;
use Illuminate\Http\Request;

class RepaymentController extends Controller
{
    protected $model;

    public function __construct(Repayment $repayment)
    {
        $this->model = $repayment;
    }

    public function index()
    {
        return $this->model->all();
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
}