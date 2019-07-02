<?php
/**
 * Created by PhpStorm.
 * User: biastegalaraga
 * Date: 15/2/18
 * Time: 4:08 PM
 */

namespace App\Http\Controllers;

use App\Traits\GatewayTrait;
use Illuminate\Http\Request;

class UptimeController extends Controller
{

    use GatewayTrait;

    public function index(Request $request)
    {
        $this->success = true;
        $this->message = 'Avnos Verification Server ' . ucwords(strtolower(env('APP_ENV', 'DEFAULT')));
        return $this->json();
    }

}