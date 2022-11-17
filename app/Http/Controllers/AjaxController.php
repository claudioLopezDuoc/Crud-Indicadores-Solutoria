<?php

namespace App\Http\Controllers;

use App\Models\AjaxCrud;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request as Request2;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->cliente= new \GuzzleHttp\Client();
    }

    public function getToken()
    {
        $client = new Client();
        $headers = [
            'Content-Type' => 'application/json'
        ];
        //Se podria automatizar el ingreso de correo, para que se use el correo con el cual se loguean.
        $body = '{
            "userName": "cllopezpziiyv6_jmy@indeedemail.com",  
            "flagJson": true
            }';

        $request = new Psr7Request('POST', 'https://postulaciones.solutoria.cl/api/acceso/', $headers, $body);

        $res = $client->sendAsync($request)->wait();

        $body = $res->getBody()->getContents();
        //convertimos en Json el Cuerpo, para crear los subindices.
        $datos = json_decode($body);
        //Almacenamos el Subindice en la variable
        $token = $datos->{'token'};
        
        return $token;

        //echo $token;
    }
    

    public function getDatos()
    {
        $token = $this->getToken();

        $client = new Client();
        $headers = [
            'Authorization' => 'Bearer '.$token,
            'Content-Type' => 'application/json'
            ];
        $body = '';

        $request = new Psr7Request('GET', 'https://postulaciones.solutoria.cl/api/indicadores/', $headers, $body);

        $res = $client->sendAsync($request)->wait();
        $datos =json_decode($res->getBody()->getContents(), true);
        
        $query = '';
        $table_data = '';
        

        foreach ($datos as $row) {
            $query .=
              DB::insert("INSERT IGNORE INTO  indicadores VALUES 
                          ('" . $row["id"] . "', '" . $row["nombreIndicador"] . "', 
                          '" . $row["codigoIndicador"] . "','" . $row["unidadMedidaIndicador"] . "',
                          '" . $row["valorIndicador"] . "','" . $row["fechaIndicador"] . "',
                          '" . $row["tiempoIndicador"] . "','" . $row["origenIndicador"] . "'
                        ); "
                    );

                    
          
            $table_data .= '
                          <tr>
                              <td>' . $row["id"] . '</td>
                              <td>' . $row["nombreIndicador"] . '</td>
                              <td>' . $row["codigoIndicador"] . '</td>
                              <td>' . $row["unidadMedidaIndicador"] . '</td>
                              <td>' . $row["valorIndicador"] . '</td>
                              <td>' . $row["fechaIndicador"] . '</td>
                              <td>' . $row["tiempoIndicador"] . '</td>
                              <td>' . $row["origenIndicador"] . '</td>
                          </tr>
                          ';
          }
          return redirect('ajax');
    }

    
    //
    public function index(Request2 $request)
    {
     
        if($request->ajax()){
            $data = DB::select('select * from indicadores where codigoIndicador = "UF"');
            return DataTables::of($data)
                    ->addColumn('action',function($row){
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editIndicador">Editar</a>';
   
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteIndicador">Borrar</a>';
    
                        return $btn;
                    })  
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('ajax');
    }
    

    public function store(Request2 $request)
    {
        /*
        #validacion de los campos. Si llega a ser necesaria.
        $campos = [
            'nombreIndicador'=>'required|String|max:100',
            'codigoIndicador'=>'required|String|max:100',
            'unidadMedidaIndicador'=>'required|String|max:100',
            'valorIndicador'=>'required|numeric|max:68|',
            'fechaIndicador'=>'required|date|max:65',
            'tiempoIndicador'=>'required|String|max:100',
            'origenIndicador'=>'required|String|max:100',
        ];
        $mensaje=[
            'required'=>'El :attribute es requerido', #:attribute es un comodin, sustituira el mensaje para cada campo que este vacio 
            'numeric'=>'El :attribute Debe ser de tipo numerico',

        ];

        $this->validate($request, $campos, $mensaje);

        */
        
        AjaxCrud::updateOrCreate(['id' => $request->id],
                [
                    'nombreIndicador'=>$request->nombreIndicador,
                    'codigoIndicador'=>$request->codigoIndicador,
                    'unidadMedidaIndicador'=>$request->unidadMedidaIndicador,
                    'valorIndicador'=>$request->valorIndicador,
                    'fechaIndicador'=>$request->fechaIndicador,
                    'tiempoIndicador'=>$request->tiempoIndicador,
                    'origenIndicador'=>$request->origenIndicador,
                ]);        
     
        return response()->json(['success'=>'Indicador Actualizado.']);
    }

    public function edit($id)
    {
        $indicador = AjaxCrud::find($id);
        return response()->json($indicador);
    }
    
    public function destroy($id)
    {
        AjaxCrud::find($id)->delete();
      
        return response()->json(['success'=>'Indicador deleted successfully.']);
    }

    /*public function grafico(){
        $indicadores = AjaxCrud::all();

        $puntos = [];
        foreach($indicadores as $indicador){
            $puntos[] = ['name' => $indicador['codigoIndicador'],
            'data' => $indicador['valorIndicador']
            ];
        }
        return view('ajax', ['data' => json_encode($puntos)]);
    }*/

}
