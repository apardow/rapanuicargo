<?php 
namespace MasExperto\Servicio;

use MasExperto\ME\Bases\Control;
use MasExperto\ME\M;
use MasExperto\ME\Finales\PresentadorXml;

class ControladorInterno extends Control
{
	public function ejecutarOperacion() {
		$contenido = '';
		$opciones = array();
		$this->ruteador->autorizarAcceso();
		$roles = $this->cargarPerfil();
		$this->comprobarPermisos( $roles, 'permisos.xml' );
		switch ( $this->operacion ) {
			case 'BASE-GET': 
				$presentador = new PresentadorXml();
				$contenido = $presentador->abrirPlantilla( 'inicio.html', M::E('RUTA/BACKEND') );
				$this->ruteador->guardarCache(0);
				break;
			case 'BASE-MENU':
                $modelo = new ModeloBase($this->DTO);
				$presentador = new PresentadorXml();
				$presentador->crearVista( 'menu.xml' );
				$presentador->filtrarVisibles( $roles );
				$presentador->anexarResultados( $this->DTO );
				$contenido = $presentador->Transformar( 'menu.xsl', M::E('RUTA/WEBME') );
				break;
			case 'BASE-ATRIBUTOS':
                $modelo = new ModeloBase($this->DTO);
                $contenido = $modelo->Atributos();
                $this->ruteador->guardarCache(0);
				break;
			case 'BASE-CAMBIAR':
				$this->ruteador->Redirigir( './app.php?M_IDIOMA=' . M::E('M_IDIOMA') );
				break;
			default:
				$this->ruteador->enviarError( '422_UNPROCESSABLE' );
				break;
		}
		unset( $modelo, $presentador );
		$this->ruteador->enviarRespuesta( $contenido, $opciones );
	}
}