<?php 
namespace MasExperto\Servicio;

use MasExperto\ME\Bases\Control;
use MasExperto\ME\M;
use MasExperto\ME\Finales\PresentadorXml;

class ControladorUsuarios extends Control
{
	public function ejecutarOperacion() {
		$contenido = '';
		$opciones = array();
		$roles = $this->cargarPerfil();
		$this->comprobarPermisos( $roles, 'permisos.xml' );
		switch ( $this->operacion ) {
			case 'USUARIOS-GET':
				$modelo = new ModeloUsuarios($this->DTO);
				$modelo->Consultar();
				$presentador = new PresentadorXml();
				$presentador->crearVista( 'permisos.xml' );
				$presentador->filtrarVisibles( $roles );
				$presentador->anexarResultados( $this->DTO );
				$presentador->anexarMetadatos( $modelo->D );
				$presentador->anexarMetadatos( $modelo->F, 'f' );
				$contenido = $presentador->Transformar( 'VistaUsuarios.xsl', M::E('RUTA/BACKEND') . '/servicios' );
				$this->ruteador->guardarCache(0);
				break;
			case 'USUARIOS-NUEVO':
				$modelo = new ModeloUsuarios($this->DTO);
				$modelo->Nuevo();
				$presentador = new PresentadorXml();
				$presentador->crearVista( 'permisos.xml' );
				$presentador->anexarResultados( $this->DTO );
				$presentador->anexarMetadatos( $modelo->D );
				$presentador->anexarMetadatos( $modelo->A, 'a' );
				$contenido = $presentador->Transformar( 'VistaUsuarios.xsl', M::E('RUTA/BACKEND') . '/servicios' );
				break;
			case 'USUARIOS-POST':
				$modelo = new ModeloUsuarios($this->DTO);
				$comprobacion = $modelo->Cotejar( 'Agregar' );
				if ( !$comprobacion['estado'] ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $comprobacion['mensaje'] );
				}
				$contenido = $modelo->Agregar();
				if ( $contenido['estado']==0 ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $contenido['mensaje'] );
				} else if ( $contenido['estado']==-1 ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $contenido['mensaje'] );
				}
				$this->ruteador->guardarCache(0);
				break;
			case 'USUARIOS/ID-GET':
				$modelo = new ModeloUsuarios($this->DTO);
				$gestion = $modelo->Abrir();
				if ( $gestion['estado'] ) {
					$presentador = new PresentadorXml();
					$presentador->crearVista( 'permisos.xml' );
					$presentador->anexarResultados( $this->DTO );
					$presentador->anexarMetadatos( $modelo->D );
					$presentador->anexarMetadatos( $modelo->A, 'a' );
					$opc = array();
					$opc['seccion'] = $this->DTO->get('seccion', 'parametro');
					$contenido = $presentador->Transformar( 'VistaUsuarios.xsl', M::E('RUTA/BACKEND') . '/servicios', $opc );
					$this->ruteador->guardarCache(0);
				} else {
					M::$entorno['M_SALIDA'] = 'JSON';
					$this->ruteador->enviarError( '404_NOTFOUND', $gestion['mensaje'] );
				}
				break;
			case 'USUARIOS/ID-PUT':
				$modelo = new ModeloUsuarios($this->DTO);
				$comprobacion = $modelo->Cotejar( 'Editar' );
				if ( !$comprobacion['estado'] ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $comprobacion['mensaje'] );
				}
				$contenido = $modelo->Editar();
				if ( !$contenido['estado'] ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $contenido['mensaje'] );
				}
				break;
			case 'USUARIOS/ID-DELETE':
				$modelo = new ModeloUsuarios($this->DTO);
				$contenido = $modelo->Borrar();
				if ( !$contenido['estado'] ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $contenido['mensaje'] );
				}
				break;
			case 'USUARIOS/ID-IMAGEN':
				$modelo = new ModeloUsuarios($this->DTO);
				M::$entorno['M_SALIDA'] = 'JSON';
				$gestion = $modelo->Imagen();
				if ( !$gestion['estado'] ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $gestion['mensaje'] );
				}
				$contenido = $gestion['imagen'];
				break;
			case 'USUARIOS-ATRIBUTOS':
				$modelo = new ModeloUsuarios($this->DTO);
                $contenido = $modelo->Atributos('Usuarios');
				$this->ruteador->guardarCache(0);
				break;
			case 'USUARIOS/ID-REFRESCAR':
				$modelo = new ModeloUsuarios($this->DTO);
				$modelo->Refrescar();
				$presentador = new PresentadorXml();
				$presentador->crearVista( 'permisos.xml' );
				$presentador->filtrarVisibles( $roles );
				$presentador->anexarResultados( $this->DTO );
				$presentador->anexarMetadatos( $modelo->D );
				$contenido = $presentador->Transformar( 'VistaUsuarios.xsl', M::E('RUTA/BACKEND') . '/servicios' );
				$this->ruteador->guardarCache(0);
				break;
			case 'USUARIOS-NUEVOAVATAR':
				$modelo = new ModeloUsuarios($this->DTO);
				$presentador = new PresentadorXml();
				$presentador->crearVista( 'permisos.xml' );
				$presentador->filtrarVisibles( $roles );
				$presentador->anexarMetadatos( $modelo->D );
				$presentador->anexarMetadatos( $modelo->A, 'a' );
				$contenido = $presentador->Transformar( 'VistaUsuarios.xsl', M::E('RUTA/BACKEND') . '/servicios' );
				$this->ruteador->guardarCache(0);
				break;
			case 'USUARIOS-AVATAR':
				$modelo = new ModeloUsuarios($this->DTO);
				M::$entorno['M_SALIDA'] = 'JSON';
				$gestion = $modelo->Avatar();
				if ( !$gestion['estado'] ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $gestion['mensaje'] );
				}
				$contenido = $gestion['imagen'];
				$this->guardarPerfil( M::E('M_USUARIO'), array ( 'imagen' => $gestion['avatar'] ) );
				break;
			case 'USUARIOS-NUEVACLAVE':
				$modelo = new ModeloUsuarios($this->DTO);
				$presentador = new PresentadorXml();
				$presentador->crearVista( 'permisos.xml' );
				$presentador->filtrarVisibles( $roles );
				$presentador->anexarMetadatos( $modelo->D );
				$presentador->anexarMetadatos( $modelo->A, 'a' );
				$contenido = $presentador->Transformar( 'VistaUsuarios.xsl', M::E('RUTA/BACKEND') . '/servicios' );
				$this->ruteador->guardarCache(0);
				break;
			case 'USUARIOS-CLAVE':
				$modelo = new ModeloUsuarios($this->DTO);
				$comprobacion = $modelo->Cotejar( 'Clave' );
				if ( !$comprobacion['estado'] ) {
					$this->ruteador->enviarError( '400_BADREQUEST', $comprobacion['mensaje'] );
				}
				$contenido = $modelo->Clave();
				if ( !$contenido['estado'] ) {
					$this->ruteador->enviarError( '500_INTERNALERROR', $contenido['mensaje'] );
				}
				break;

			default:
				$this->ruteador->enviarError( '405_NOTALLOWED' );
				break;
		}
		unset( $modelo, $presentador );
		$this->ruteador->enviarRespuesta( $contenido, $opciones );
	}
}
?>