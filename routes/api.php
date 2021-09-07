<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/ejercicio1-anagramas', function (Request $request) {
    $request->validate([
        'cadena1' => 'required|string|max:50',
        'cadena2' => 'required|string|max:50',
    ]);

    $cadena1_array = str_split($request->cadena1);
    $cadena2_array = str_split($request->cadena2);

    foreach ($cadena1_array as $cadena1_letra) {
        $encontrado = false;
        foreach ($cadena2_array as $cadena2_letra) {
            if (strtolower($cadena2_letra) == strtolower($cadena1_letra)) {
                $encontrado = true;
                break;
            }
        }
        if (!$encontrado) {
            return "Las cadenas no son anagramas";
            break;
        }
    }

    return "Las cadenas sí son anagramas";
});

Route::get('/ejercicio2-diferencia-absoluta', function (Request $request) {

    $matriz = [
        [8, 2, 8],
        [4, 4, 6],
        [9, 8, 3]
    ];

    $total1 = 0;
    $total2 = 0;
    foreach ($matriz as $key => $fila) {
        $total1 += $fila[$key];
        $total2 += $fila[count($fila)-($key + 1)];
    }

    $direfenciaAbsoluta = $total1 - $total2;

    return "Su diferencia absoluta es: " . $direfenciaAbsoluta;
});

Route::post('/ejercicio3-manzanas-naranjas', function (Request $request) {

    $request->validate([
        's' => 'required|numeric|min:1',
        't' => 'required|numeric|min:1',
        'a' => 'required|numeric|min:1',
        'manzanasArrojadas' => 'required|array',
        'naranjasArrojadas' => 'required|array'
    ]);

    //Casa de Juan
    $s = $request->s;
    $t = $request->t;

    $a = $request->a; //Ubicación manzanas
    $b = $request->b; //Ubicación naranjas

    $m = count($request->manzanasArrojadas); //Cantidad manzanas
    $n = count($request->naranjasArrojadas); //Cantidad naranjas

    $manzanasArrojadas = $request->manzanasArrojadas;
    $naranjasArrojadas = $request->naranjasArrojadas;

    $manzanasAterrizadas = [];

    foreach ($manzanasArrojadas as $key => $manzanaArrojada) {
        $manzanasAterrizadas[] = $manzanaArrojada + $a;
    }

    $naranjasAterrizadas = [];

    foreach ($naranjasArrojadas as $key => $naranjaAterrizada) {
        $naranjasAterrizadas[] = $naranjaAterrizada + $b;
    }

    $manzanasQueCayeronEnLaCasa = array_filter($manzanasAterrizadas, function ($manzanaAterrizada) use ($s, $t) {
            return $manzanaAterrizada >= $s && $manzanaAterrizada <= $t;
    });

    $naranjasQueCayeronEnLaCasa = array_filter($naranjasAterrizadas, function ($naranjaAterrizada) use ($s, $t) {
            return $naranjaAterrizada >= $s && $naranjaAterrizada <= $t;
    });
    
    return [
        'Manzanas' => count($manzanasQueCayeronEnLaCasa),
        'Naranjas' => count($naranjasQueCayeronEnLaCasa)
    ];
});