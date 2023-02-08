<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use DB;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Traits\ExtractorTrait;
use App\Models\Charge;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class PadronController extends Controller
{
    use ExtractorTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index()
    {   
        //return view('documents.index') ;
        $count = 0;
        $numitems = 100;
        $max_id = 200112;
        //$paginator = Company::where('ruc','like','10%')->where('id','<',$max_id)->cursorPaginate($numitems,['*'],'cursor');
        $paginator = Organization::where('ruc','like','10%')->cursorPaginate($numitems,['*'],'cursor');
        //return $postTemp;
        do{
            $count+=$paginator->count();
            $next = $paginator->nextCursor();
            //$paginator = Company::where('ruc','like','10%')->where('id','<',$max_id)->cursorPaginate($numitems, ['*'], 'cursor', $next);
            $paginator = Organization::where('ruc','like','10%')->cursorPaginate($numitems, ['*'], 'cursor', $next);
        }while($paginator->hasMorePages());

        return $count;
        return [
            'result' => 'hi'
        ];
    }

     

    public function download()
    {
        try{
            $filepath = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_rar".DIRECTORY_SEPARATOR."padron_reducido_ruc.zip"));
            $url = "http://www2.sunat.gob.pe/padron_reducido_ruc.zip";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $raw_file_data = curl_exec($ch);
    
            if(curl_errno($ch)){
                 return 'error';
            }
            curl_close($ch);
    
            file_put_contents($filepath, $raw_file_data);

            return [ 'success' => true, 'message' => 'Datos descargados de sunat correctamente'];

        }catch(Exception $e)
        {
            return [ 'success' => false, 'message' => $e->getMessage()];
        }
    }

    public function extractor()
    {
        try{

          
            $ini = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_rar".DIRECTORY_SEPARATOR."padron_reducido_ruc.zip"));
            $fin = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_extract".DIRECTORY_SEPARATOR.""));
    
            $data = $this->extract($ini, $fin);
         
            return [ 'success' => true, 'message' => 'Extraccion de zip correctamente', 'data' => $data];

        }catch(Exception $e)
        {
            return [ 'success' => false, 'message' => $e->getMessage()];
        }
       
    }

    public function loadtdata()
    {
        try{


            DB::table('organizations')->truncate();

            $file = public_path();
            $prefix = 'padron_extract';
            $prefix2 = 'txt';
            $key = 'padron_reducido_ruc';
            $file =  str_replace(DIRECTORY_SEPARATOR, '/', public_path("{$prefix}".DIRECTORY_SEPARATOR."{$key}.{$prefix2}"));
    
            $query = "LOAD DATA LOCAL INFILE '" . $file . "'
            INTO TABLE organizations  FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n' IGNORE 1 LINES
                    (ruc,
                    nombre_razon_social,
                    estado_contribuyente,
                    condicion_domicilio,
                    ubigeo,
                    tipo_via,
                    nombre_via,
                    codigo_zona,
                    tipo_zona,
                    numero,
                    interior,
                    lote,
                    departamento,
                    manzana,
                    kilometro,
                    @status,
                    @created_at,
                    @updated_at)
            SET status=1,created_at=NOW(),updated_at=null";
            DB::connection()->getpdo()->exec($query);


           return [ 'success' => true, 'message' => 'Datos csv cargados a BD correctamente'];

      }catch(Exception $e){
            
            return [ 'success' => false, 'message' => $e->getMessage()];
        }
       
    }

    public function charges_data()
    {
        try{

            $history = Charge::create([
                'reference' => 'FACTURADOR',
                'state' => 0
            ]);

            //DOWNLOAD ZIP ------
            $filepath = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_rar".DIRECTORY_SEPARATOR."padron_reducido_ruc.zip"));
            $url = "http://www2.sunat.gob.pe/padron_reducido_ruc.zip";

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $raw_file_data = curl_exec($ch);
    
            if(curl_errno($ch)){
                 return 'error';
            }
            curl_close($ch);
    
            file_put_contents($filepath, $raw_file_data);

            //EXTRACT ZIP
            $ini = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_rar".DIRECTORY_SEPARATOR."padron_reducido_ruc.zip"));
            $fin = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_extract".DIRECTORY_SEPARATOR.""));
            $data = $this->extract($ini, $fin);

            //LOAD DATA TXT TO MYSQL
            DB::table('organizations')->truncate();
            $file = public_path();
            $prefix = 'padron_extract';
            $prefix2 = 'txt';
            $key = 'padron_reducido_ruc';
            $file =  str_replace(DIRECTORY_SEPARATOR, '/', public_path("{$prefix}".DIRECTORY_SEPARATOR."{$key}.{$prefix2}"));
            $query = "LOAD DATA LOCAL INFILE '" . $file . "'
            INTO TABLE organizations  FIELDS TERMINATED BY '|' LINES TERMINATED BY '\n' IGNORE 1 LINES
                    (ruc,
                    nombre_razon_social,
                    estado_contribuyente,
                    condicion_domicilio,
                    ubigeo,
                    tipo_via,
                    codigo_zona,
                    tipo_zona,
                    numero,
                    interior,
                    lote,
                    departamento,
                    manzana,
                    kilometro,
                    @status,
                    @created_at,
                    @updated_at)
            SET status=1,created_at=NOW(),updated_at=null";
            DB::connection()->getpdo()->exec($query);


            $history->state = 1;
            $history->save();

            return [ 'success' => true, 'message' => 'Datos descargados de sunat correctamente'];

        }catch(Exception $e)
        {
            return [ 'success' => false, 'message' => $e->getMessage()];
        }
        catch(\PDOException $Exception ) {
            return [
                'success' => false,
                'message' => $Exception->getMessage()
            ];
        }
       
    }


    public function list_history()
    {
        $data = Charge::orderBy('created_at')->get();
        return [
            'success' => true,
            'data' => $data
        ];
    }



    function downloadZipFile($url, $filepath){

        $filepath = str_replace(DIRECTORY_SEPARATOR, '/', public_path("padron_rar".DIRECTORY_SEPARATOR."{$filepath}"));

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $headers = array(
            'X-Filename: padron_reducido_ruc.zip', 
            'X-Filetype: application/zip', 
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $raw_file_data = curl_exec($ch);
   
        if(curl_errno($ch)){
           echo 'error:' . curl_error($ch);
        }
        curl_close($ch);
   
        file_put_contents($filepath, $raw_file_data);
        //return (filesize($filepath) > 0)? true : false;
    }

    public function test(){
        Log::info('Hola');
    }
}
