<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Support\Facades\Session;

// class RememberLastPage
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */

//     //  public function handle(Request $request, Closure $next)
//     // {
//     //     if (!$request->ajax() && $request->isMethod('get')) {
//     //         Session::put('last_page_url', url()->previous());

//     //         // Aquí debes definir cómo determinar el nombre de la página
//     //         // Session::put('last_page_name', 'Página Anterior');
//     //         $previousRequest = app('request')->create(url()->previous());
//     //         $previousRoute = app('router')->getRoutes()->match($previousRequest);
//     //         $previousPageName = $previousRoute->getName();
    
//     //         Session::put('last_page_name', $previousPageName);
//     //     }

//     //     return $next($request);
//     // }

// }
