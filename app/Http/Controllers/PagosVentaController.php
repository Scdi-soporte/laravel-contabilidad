<?php

namespace App\Http\Controllers;

use App\Bitacora;
use App\PagosVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagosVentaController extends Controller
{
    public function index()
    {
        return view('pagoventas.lista');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'monto' => 'required',
            'facturaVenta_id' => 'required'
        ]);
        $pagosventa = PagosVenta::create($request->all());
        $pagosventa->save();
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => "Registró un nuevo pago de venta: $pagosventa->id"
        ]);
        return redirect()->back()->with('info','Creado con éxito');
    }

    public function registrar()
    {
        return view('pagoventas.crear');
    }

    // public function update(Request $request, $id)
    // {
    //     PagosVenta::where('id', $id)->update($request->all());
    //     return redirect()->back()->with('act','Actualizado con éxito');
    // }

    public function delete($id)
    {
        $pagosventa = PagosVenta::findOrFail($id);
        $pagosventa->estado = 1;
        $pagosventa->update();
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => "Eliminó el pago de venta: $pagosventa->id"
        ]);
        return redirect()->back()->with('delete','Eliminado con éxito');
    }
}
