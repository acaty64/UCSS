<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Laracasts\Flash\Flash;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        //controlamos todos los roles de usuarios desde aquí
            $roles = explode("-", $roles);
            if(!in_array(Auth::user()->type, $roles)){
                Flash::success('Usted no tiene acceso a esta opcion.');
                return redirect()->back();         
            }
        //Sencilla pero efectiva, los dos primeros parámetros son necesarios a la hora de crear filtros que sean llamados antes de que la ruta sea procesada(before), si son para después(after), éstos deben llevar tres parámetros, siendo el tercero la respuesta.
        return $next($request);
    }
}
