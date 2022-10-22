<?php 
namespace MasExperto\Servicio;

use MasExperto\ME\Bases\Modelo;
use MasExperto\ME\M;

class ModeloBase extends Modelo
{
    private $mensaje;

	function __construct( &$dto ) {
		parent::__construct( $dto);
        include('InfoBase.php');
	}
	public function Autenticar() {
		$clave = $this->dto->get('clave');
		$usuario = $this->dto->get('usuario');
		$sql = str_replace( '{{clave}}', hash( 'ripemd256', M::E('LLAVE/CLAVE').$clave ), $this->sql['autenticar'] );
		$sql = str_replace( '{{usuario}}', $usuario, $sql );
		$sql = str_replace( '{{m_instancia}}', M::E('M_INSTANCIA'), $sql );
        $this->bd->Conectar( M::E('BD/1'), $this->dto );
        $sql = $this->bd->reemplazarValores( $sql );
		$resultado = $this->bd->consultarElemento( $sql, 'usuario', false );
		$estado = ( $resultado['total']==1 && $resultado['estado']==1 && is_numeric($resultado['id']) ? 1 : 0 );
		return array(
			'estado'=> $estado,
			'total'=> $resultado['total'],
			'id'=> $resultado['id'],
			'datos'=> &$this->dto->resultados['usuario']
		);
	}
	public function cambiarClave() {
		$estado = 0;
		$clave = $this->dto->get('clave');
		$clave2 = $this->dto->get('clave2');
		$usuario = $this->dto->get('usuario');
		$codigo = $this->dto->get('codigo');
		$mensaje = $this->T['clave-no-restablecida'];
		if ( $clave != $clave2 ) {
			$mensaje = $this->I['claves-diferentes'];
		} else {
			$sql = str_replace( '{{usuario}}', $usuario, $this->sql['comprobar'] );
			$sql = str_replace( '{{codigo}}', $codigo, $sql );
            $this->bd->Conectar( M::E('BD/1'), $this->dto );
            $sql = $this->bd->reemplazarValores( $sql );
			$resultado = $this->bd->consultarElemento( $sql, 'usuario', false );
			$estado = ( $resultado['estado']==1 && $resultado['total']==1 ? 1 : 0 );
			if ( $estado ) {
				$sql = str_replace( '{{clave}}', hash( 'ripemd256', M::E('LLAVE/CLAVE').$clave ), $this->sql['cambiar'] );
				$sql = str_replace( '{{usuario}}', $usuario, $sql );
				$sql = str_replace( '{{codigo}}', $codigo, $sql );
                $sql = $this->bd->reemplazarValores( $sql );
				$respuesta = $this->bd->editarElementos( $sql, 'usuario' );
				$estado = ( $respuesta['estado']==1 && $respuesta['total']==1 ? 1 : 0 );
			} else {
				$mensaje = $this->T['codigo-no-valido'];
			}
		}
		if ( $estado == 1 ) {
			$mensaje = $this->T['clave-restablecida'];
		}
		return array(
			'estado'=> $estado,
			'mensaje'=> $mensaje
		);
	}
	public function enviarCodigo() {
		$codigo = uniqid();
		$contenido = str_replace( '|', chr(10), $this->mensaje);
		$mensaje = $this->T['codigo-no-enviado'];
		$email = $this->dto->get( 'email' );
		$this->bd->Conectar( M::E('BD/1'), $this->dto );
		$sql = $this->bd->reemplazarValores( $this->sql['buscar'] );
		$resultado = $this->bd->consultarElemento( $sql, 'caso', false );
		$estado = ( $resultado['estado']==1 && $resultado['total']==1 ? 1 : 0);
		if ( $estado == 1 ) {
			$id = $this->dto->resultados['caso']['id'];
			$usuario = $this->dto->resultados['caso']['usuario'];
			$alias = $this->dto->resultados['caso']['alias'];
			$sql = str_replace( '{{id}}', $id, $this->sql['codigo'] );
			$sql = str_replace( '{{codigo}}', $codigo, $sql );
            $sql = $this->bd->reemplazarValores( $sql );
			$resultado = $this->bd->editarElementos( $sql, 'codigo' );
			$estado = ( $resultado['estado']==1 ? 1 : 0);
			if ( $estado == 1 ) {
				$contenido = str_replace( '(alias)', $alias, $contenido);
				$contenido = str_replace( '(codigo)', $codigo, $contenido);
				$contenido = str_replace( '(usuario)', $usuario, $contenido);
				$contenido = str_replace( '(app)', M::E('APP_TITULO'), $contenido);
				$contenido = str_replace( '(url)', M::E('M_SERVIDOR') . '/' . M::E('M_INSTANCIA'), $contenido);
				$conector = M::E('CONECTOR/CORREO');
				$mail = new $conector;
				$mail->Conectar( M::E('CORREO/1') );
				$envio = $mail->enviarMensaje( $this->T['asunto-codigo'], $contenido, array( $email ) );
				$estado = intval($envio['estado']);
				$mensaje = $envio['mensaje'];
				unset( $mail );
			}
		} else {
			$mensaje = $this->T['cuenta-no-valida'];
		}
		if ( $estado == 1 ) {
			$mensaje = $this->T['codigo-enviado'];
		}
		return array(
			'estado'=> $estado,
			'mensaje'=> $mensaje
		);
	}
}