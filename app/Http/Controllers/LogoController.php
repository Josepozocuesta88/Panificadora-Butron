<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoController extends Controller
{
  public function updateLogo(Request $request)
  {
    $request->validate([
      'logo' => 'nullable|image|mimes:png|max:2048',
      'bglogin' => 'nullable|image|mimes:png|max:2048',
      'bgprincipal' => 'nullable',
    ]);

    $pathLogo = public_path('images/web/logo.png');
    $pathBgLogin = public_path('images/web/bglogin.png');
    $pathBgPrincipal = public_path('images/web/hero-index.png');

    if ($request->hasFile('logo')) {
      if (file_exists($pathLogo)) {
        unlink($pathLogo);
      }
      $request->file('logo')->move(dirname($pathLogo), 'logo.png');
    }

    if ($request->hasFile('bglogin')) {
      if (file_exists($pathBgLogin)) {
        unlink($pathBgLogin);
      }
      $request->file('bglogin')->move(dirname($pathBgLogin), 'bglogin.png');
    }

    if ($request->hasFile('bgprincipal')) {
      if (file_exists($pathBgPrincipal)) {
        unlink($pathBgPrincipal);
      }
      $request->file('bgprincipal')->move(dirname($pathBgPrincipal), 'hero-index.png');
    }

    return redirect()->back()->with('success', 'Logo actualizado correctamente');
  }
}
