<?php 
namespace MasExperto\Servicio;

use MasExperto\ME\Bases\Almacen;
use MasExperto\ME\Bases\Modelo;
use MasExperto\ME\Finales\Dto;
use MasExperto\ME\M;

class ModeloUsuarios extends Modelo
{
	function __construct( &$dto ) {
		parent::__construct( $dto );
		include('InfoUsuarios.php');
	}
	public function Imagen() {
		$estado = 0;
		$mensaje = '';
		$imagen = '';
		$anterior = '';
		$opciones['tipos'] = array( 'jpg', 'jpeg', 'png' );
		$opciones['peso'] = '3 MB';
		$opciones['nombre'] = '{{uniqid}}';
		$carga = $this->almacen->cargarArchivos( Almacen::PRIVADO, $opciones );
		if ( $carga['estado'] ) {
			$opciones = array();
			$opciones['calidad'] = 97;
			$opciones['ancho'] = 300;
			$opciones['alto'] = 300;
			$opciones['formato'] = 'jpg';
			$opciones['carpeta'] = 'img';
			$adaptacion = $this->almacen->adaptarImagenes( Almacen::PUBLICO, $carga['contenidos'], $opciones );
			if ( $adaptacion['estado'] ) {
				$imagen = $adaptacion['contenidos'][0]['completa'];
			} else {
				$mensaje = implode( '. ', $adaptacion['errores'] );
			}
		} else {
			$mensaje = implode( '. ', $carga['errores'] );
		}
		if ( strlen( $imagen )>0 ) {
			$sql = str_replace( '{{id}}', M::E('RECURSO/ELEMENTO'), $this->sql['caso_leer']);
            $this->bd->Conectar( M::E('BD/1'), $this->dto );
            $sql = $this->bd->reemplazarValores( $sql );
			$respuesta = $this->bd->consultarElemento( $sql, 'anterior', false );
			$estado = ( $respuesta['estado']==1 && $respuesta['total']==1 ? 1 : 0);
			if ( $estado == 1 ) {
				$anterior = $this->dto->resultados['anterior']['imagen'];
				if ( substr_count($anterior, 'usuario.jpg')>0 || substr_count($anterior, 'logo.jpg')>0 ) {
					$anterior = '';
				}
                $sql = str_replace( '{{imagen}}', $imagen, $this->sql['cambiar_imagen']);
                $sql = str_replace( '{{id}}', M::E('RECURSO/ELEMENTO'), $sql);
                $sql = $this->bd->reemplazarValores( $sql );
                $respuesta = $this->bd->editarElementos( $sql, 'imagen' );
                $estado = $respuesta['estado'];
			}
			if ( $estado == 1 ) {
				if ( strlen($anterior)>0 && file_exists(M::E('RUTA/RAIZ') . $anterior) && substr_count($anterior,'usuario.')==0 ) {
					unlink( M::E('RUTA/RAIZ') . $anterior );
				}
			} else {
				$mensaje = $this->T['imagen-no-asignada'];
			}
		}
		return array(
			'estado'=> $estado,
			'imagen'=> $imagen,
			'mensaje'=> $mensaje
		);
	}
	public function Refrescar() {
		$mensaje = '';
		$this->dto->set( 'id', M::E('RECURSO/ELEMENTO') );
		$sql = $this->sql['consultar'];
		$sql = str_replace( ' WHERE 1', ' WHERE ' . $this->tabla . ".id='{{id}}'", $sql );
        $this->bd->Conectar( M::E('BD/1'), $this->dto );
		$sql = $this->bd->reemplazarValores( $sql );
		$respuesta = $this->bd->consultarElemento( $sql, 'caso', false );
		$estado = ( $respuesta['estado']==1 && $respuesta['total']==1 ? 1 : 0);
		if ( $estado == 0 ) {
		    $mensaje = $this->T['caso-no-existe'];
		} else {
			if ( isset($this->sql['lista_clases']) ) {
				$this->dto->set('M_MAX', 100, 'parametro');
				$this->dto->set('M_NAV', 1, 'parametro');
				$sql = $this->bd->reemplazarValores( $this->sql['lista_clases'] );
				$this->bd->consultarColeccion( $sql, 'lista_clases', false );
			}
		}
		return array(
			'estado'=> $estado,
			'mensaje'=> $mensaje
		);
	}
	public function Avatar() {
		$estado = 0;
		$mensaje = '';
		$imagen = '';
		$anterior = '';
		$opciones['tipos'] = array( 'jpg', 'jpeg', 'png' );
		$opciones['peso'] = '3 MB';
		$opciones['nombre'] = '{{uniqid}}';
		$carga = $this->almacen->cargarArchivos( Almacen::PRIVADO, $opciones );
		if ( $carga['estado'] ) {
			$opciones = array();
			$opciones['calidad'] = 97;
			$opciones['ancho'] = 300;
			$opciones['alto'] = 300;
			$opciones['formato'] = 'jpg';
			$opciones['carpeta'] = 'img';
			$adaptacion = $this->almacen->adaptarImagenes( Almacen::PUBLICO, $carga['contenidos'], $opciones );
			if ( $adaptacion['estado'] ) {
				$imagen = $adaptacion['contenidos'][0]['completa'];
			} else {
				$mensaje = implode( '. ', $adaptacion['errores'] );
			}
		} else {
			$mensaje = implode( '. ', $carga['errores'] );
		}
		if ( strlen( $imagen )>0 ) {
			$sql = str_replace( '{{id}}', M::E('M_USUARIO'), $this->sql['caso_leer']);
            $this->bd->Conectar( M::E('BD/1'), $this->dto );
            $sql = $this->bd->reemplazarValores( $sql );
			$respuesta = $this->bd->consultarElemento( $sql, 'anterior', false );
			$estado = ( $respuesta['estado']==1 && $respuesta['total']==1 ? 1 : 0);
			if ( $estado == 1 ) {
				$anterior = $this->dto->resultados['anterior']['imagen'];
				if ( substr_count($anterior, 'usuario.jpg')>0 ) {
					$anterior = '';
				}
                $sql = str_replace( '{{imagen}}', $imagen, $this->sql['cambiar_imagen']);
                $sql = str_replace( '{{id}}', M::E('M_USUARIO'), $sql);
                $sql = $this->bd->reemplazarValores( $sql );
                $respuesta = $this->bd->editarElementos( $sql, 'imagen' );
                $estado = $respuesta['estado'];
			}
			if ( $estado == 1 ) {
				if ( strlen($anterior)>0 && file_exists(M::E('RUTA/RAIZ') . $anterior) && substr_count($anterior,'usuario.')==0 ) {
					unlink( M::E('RUTA/RAIZ') . $anterior );
				}
			} else {
				$mensaje = $this->T['imagen-no-asignada'];
			}
		}
		return array(
			'estado'=> $estado,
			'imagen'=> $imagen,
			'avatar'=> $imagen,
			'mensaje'=> $mensaje
		);
	}
	public function Clave() {
		$estado = 0;
		$nueva = $this->dto->get('nueva');
		$nueva2 = $this->dto->get('nueva2');
		$clave = $this->dto->get('clave');
		$mensaje = $this->T['clave-no-cambiada'];
		if ( $nueva != $nueva2 ) {
			$mensaje = $this->I['claves-diferentes'];
		} else {
			$sql = str_replace( '{{clave}}', hash( 'ripemd256', M::E('LLAVE/CLAVE').$clave ), $this->sql['comprobar_clave'] );
			$sql = str_replace( '{{id}}', M::E('M_USUARIO'), $sql );
            $this->bd->Conectar( M::E('BD/1'), $this->dto );
            $sql = $this->bd->reemplazarValores( $sql );
			$resultado = $this->bd->consultarElemento( $sql, 'usuario', false );
			$estado = ( $resultado['total']==1 && $resultado['estado']==1 ? 1 : 0 );
			if ( $estado == 1 ) {
				$sql = str_replace( '{{clave}}', hash( 'ripemd256', M::E('LLAVE/CLAVE').$nueva ), $this->sql['cambiar_clave'] );
				$sql = str_replace( '{{id}}', M::E('M_USUARIO'), $sql );
                $sql = $this->bd->reemplazarValores( $sql );
				$respuesta = $this->bd->editarElementos( $sql, 'usuario' );
				$estado = $respuesta['estado'];
			} else {
				$mensaje = $this->T['clave-no-valida'];
			}
		}
		if ( $estado == 1 ) {
			$mensaje = $this->T['clave-cambiada'];
		}
		return array(
			'estado'=> $estado,
			'mensaje'=> $mensaje
		);
	}

}
?>