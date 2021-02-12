<?php

namespace App\Http\Controllers;

use App\Bitacora;
use App\FacturaVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacturaVentaController extends Controller
{
    public function index()
    {
        return view('facturaventa.lista');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'descripcion' => 'required',
            'monto' => 'required',
            'asiento_id' => 'required'
        ]);
        $request['empresa_id'] = Auth::user()->empresaId;
        $facturaventa = FacturaVenta::create($request->all());
        $facturaventa->save();
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => "Registró una nueva factura de venta: $facturaventa->id"
        ]);
        return redirect()->back()->with('info','Creado con éxito');
    }

    public function registrar()
    {
        return view('facturaventa.crear');
    }

    // public function update(Request $request, $id)
    // {
    //     FacturaVenta::where('id', $id)->update($request->all());
    //     return redirect()->back()->with('act','Actualizado con éxito');
    // }

    public function delete($id)
    {
        $facturaventa = FacturaVenta::findOrFail($id);
        $facturaventa->estado = 1;
        $facturaventa->update();
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => "Eliminó la factura de venta: $facturaventa->id"
        ]);
        return redirect()->back()->with('delete','Eliminado con éxito');
    }
}
