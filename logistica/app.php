<?php
use MasExperto\ME\M;
use MasExperto\ME\Finales\RuteadorHttp;
use MasExperto\Servicio\ControladorInterno;
use MasExperto\Servicio\ControladorExterno;

require '../../config/logistica.php';

M::$entorno['M_INSTANCIA']          = basename(__DIR__);
M::$entorno['RUTA']['FRONTEND']     = __DIR__;
M::$entorno['RUTA']['BACKEND']      = __DIR__;
M::$entorno['ALMACEN']['PUBLICO']   = __DIR__ . '/almacen';
M::$entorno['ALMACEN']['PRIVADO']   = __DIR__ . '/almacen';
M::$entorno['RUTA']['ESQUEMAS']     = __DIR__ . '/servicios';
M::$entorno['RUTA']['LOCALES']      = __DIR__ . '/locales';

if ( substr_count($_SERVER['HTTP_HOST'], '.') == 0 ) {
	M::$entorno['BD']['1']['USER']		= 'root';
	M::$entorno['BD']['1']['PASSW']		= '';
}

function Iniciar() {
    $ruteador = new RuteadorHttp();
    $ruteador->procesarSolicitud();
    $token = $ruteador->revisarCredencial();
    if ( strlen($token)>100 && M::E('SOLICITUD/COMANDO')!='login' ) {
        $ruteador->autorizarAcceso();
        $clase1 = '\MasExperto\Servicio\Controlador' . ucfirst( M::E('RECURSO/COLECCION') );
        $clase2 = '\MasExperto\Servicio\Controlador' . ucfirst( M::E('ANTECESOR/COLECCION') );
        if ( class_exists( $clase1, true ) ) {
            $control = new $clase1;
            $control->traduccion = M::E('RECURSO/COLECCION');
        } elseif ( class_exists( $clase2, true ) ) {
            $control = new $clase2;
            $control->traduccion = M::E('ANTECESOR/COLECCION');
        } else {
            $control = new ControladorInterno();
            $control->traduccion = 'base';
        }
    } else {
        $control = new ControladorExterno();
        $control->traduccion = 'base';
    }
    $control->Iniciar( $ruteador );
    $control->ejecutarOperacion();
    unset( $control, $ruteador );
}
Iniciar();

//M::Trazar('-------------------------' . M::E('SOLICITUD/OPERACION') . '-------------------------');
//M::Trazar(M::E(''));
