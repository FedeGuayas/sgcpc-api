<?php
/**
 * Controlador base del que extenderan todos los controladores de la api, para compartir metodos
 */
namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use ApiResponser;

    public function __construct(){
    }
}
