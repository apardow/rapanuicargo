<?php 
namespace MasExperto\Servicio;

use MasExperto\ME\Bases\Control;
use MasExperto\ME\Finales\PresentadorXml;
use MasExperto\ME\M;

class ControladorExterno extends Control
{
	public function ejecutarOperacion() {

		switch ( $this->operacion ) {
            case 'BASE-POST':
				$modelo = new ModeloBase($this->DTO);
				$comprobacion = $modelo->Cotejar( 'Autenticar' );
				if ( !$comprobacion['estado'] ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $comprobacion['mensaje'] );
				}
				$contenido['token'] = '';
				$contenido['url'] = $this->DTO->get( 'M_URL', 'parametro' );
				$resultado = $modelo->Autenticar();
				if ( $resultado['estado'] ) {
					$this->guardarPerfil( $resultado['id'], $resultado['datos'] );
					$contenido['token'] = M::generarToken( 'sesion', $resultado['id'] );
					if ( $contenido['url']=='' ) {
						$contenido['url'] = M::E('M_PUNTOFINAL') . '/app.php';
					}
				} else {
					$mensaje = $modelo->T['usuario-no-autenticado'];
					$this->ruteador->enviarError( '400_BADREQUEST', $mensaje );
				}
				$this->ruteador->guardarCache(0);
				$this->ruteador->enviarRespuesta( $contenido );
				break;
			case 'BASE-ATRIBUTOS': 
				$modelo = new ModeloBase($this->DTO);
				$contenido = $modelo->Atributos();
				$this->ruteador->guardarCache(0);
				$this->ruteador->enviarRespuesta( $contenido );
				break;
			case 'BASE-PUT':
				$modelo = new ModeloBase($this->DTO);
				$comprobacion = $modelo->Cotejar( 'Restaurar' );
				if ( !$comprobacion['estado'] ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $comprobacion['mensaje'] );
				}
				$contenido = $modelo->cambiarClave();
				if ( !$contenido['estado'] ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $contenido['mensaje'] );
				}
				$this->ruteador->guardarCache(0);
				$this->ruteador->enviarRespuesta( $contenido );
				break;
			case 'BASE-ENVIAR': 
				$modelo = new ModeloBase($this->DTO);
				$comprobacion = $modelo->Cotejar( 'Enviar' );
				if ( !$comprobacion['estado'] ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $comprobacion['mensaje'] );
				}
				$contenido = $modelo->enviarCodigo();
				if ( !$contenido['estado'] ) {
					$this->ruteador->enviarError( '404_NOTFOUND', $contenido['mensaje'] );
				}
				$this->ruteador->guardarCache(0);
				$this->ruteador->enviarRespuesta( $contenido );
				break;
            case 'BASE-GET':
            case 'LOGIN-GET':
            default:
				if ( M::E('M_SALIDA') == 'HTML' ) {
                    $modelo = new ModeloBase($this->DTO);
                    $presentador = new PresentadorXml();
                    $contenido = $presentador->abrirPlantilla( 'login.html' );
                    $this->ruteador->enviarRespuesta( $contenido );
				}
				break;
		}
	}
}