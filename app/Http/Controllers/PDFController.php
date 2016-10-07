<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Curso;

class PdfController extends Controller
{
    public function usuario($user_id)
    {
//dd($user_id);
        //
    	$view_user = User::find($user_id)->toArray();
        $datauser = User::find($user_id)->datauser()->get()->toArray();
//dd($datauser);
    	$view = \View::make('pdf.usuario', compact('view_user','datauser'))->render();
    	$pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('usuario');
    }

    public function silaboCurso(Request $request)
    {
//        dd($request->all());
        $curso = Curso::find($request->curso_id);
//        dd($curso->wcurso);
        $filename = $curso->ccurso.'.pdf';
//dd($filename);
        $arch_pdf = asset('pdf\silabos\\').$filename;
//dd($path);

    //    $arch_pdf = storage_path() . "\pdf\silabos\\" . $filename;
//        $arch_pdf = '/pdf/silabos/'. $filename;
//dd($arch_pdf);
        return view('pdf.silabo')
            ->with('arch_pdf',$arch_pdf)
            ->with('wcurso',$curso->wcurso);
    }


    /****************************************************************************/
    public function invoice() 
    {
        $data = $this->getData();
        $date = date('Y-m-d');
        $invoice = "2222";
        $view =  \View::make('pdf.invoice', compact('data', 'date', 'invoice'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('invoice');
    }

    public function getData() 
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }
}
