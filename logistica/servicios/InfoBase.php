<?php
use \MasExperto\ME\Bases\BaseDatos;

$this->mensaje = 'Hola (alias),|Hemos recibido una solicitud de restablecimiento de contraseña de su cuenta en la Aplicación (app).|Para cambiar su contraseña debe ingresar los siguientes datos en la página de "Acceso de usuarios".||Usuario: (usuario)|Codigo: (codigo)||La dirección para acceder a la Aplicación es:|(url)||Este es un mensaje automático enviado a petición del usuario, favor de NO responder.|';

$this->T = array(
	'usuario-no-autenticado'	=> _( 'Nombre-de-usuario-o-contraseña-no-validos' ),
	'ingresar-a-la-app'			=> _( 'Inicie-sesion-para-ingresar-a-la-aplicacion' ),
	'iniciar-sesion'			=> _( 'Iniciar-sesion' ),
    'acceso-usuarios'			=> _( 'Acceso-usuarios' ),
    'olvido-contraseña'			=> _( 'Olvido-su-contraseña?' ),
    'su-correo'			        => _( 'Su-correo-electronico' ),
    'enviar-codigo'			    => _( 'Enviar-codigo' ),
    'vaya-a'	        		=> _( 'Si-ya-lo-recibio-vaya-a' ),
    'ingresar-codigo'			=> _( 'Ingresar-codigo' ),
    'restablecer-contraseña'	=> _( 'Restablecer-su-contraseña' ),
    'restablecer'			    => _( 'Restablecer' ),
    'confirma-correo'			=> _( 'Le-enviamos-un-correo-con-instrucciones' ),
    'escriba-codigo'			=> _( 'Escriba-el-codigo-que-recibio-y-complete-el-formulario' ),
    'codigo'			        => _( 'Codigo' ),
    'usuario'		        	=> _( 'Usuario' ),
    'nueva-contraseña'			=> _( 'Nueva-contraseña' ),
    'repita-contraseña'			=> _( 'Repita-la-contraseña' ),
    'ingrese-correo'			=> _( 'Ingrese-su-correo-para-enviarle-un-codigo-para-restablecer-su-contraseña' ),
    'asunto-codigo'				=> _( 'Asunto-mensaje-codigo' ),
	'cuenta-no-valida'			=> _( 'El-correo-no-corresponde-a-ninguna-cuenta-vigente' ),
	'codigo-enviado'			=> _( 'El-codigo-fue-enviado-por-correo' ),
	'codigo-no-enviado'			=> _( 'El-codigo-no-pudo-enviarse' ),
	'codigo-no-valido'			=> _( 'El-codigo-ingresado-no-es-valido' ),
	'clave-no-restablecida'		=> _( 'La-contraseña-no-pudo-restablecerse' ),
	'clave-restablecida'		=> _( 'La-contraseña-fue-restablecida' ),
    'perfil-usuario'            => _( 'M_Perfil-de-usuario' ),
    'elegir-idioma'             => _( 'M_Elegir-idioma' ),
    'menu-admin'                => _( 'M_Administracion' ),
    'menu-usuarios'             => _( 'M_Usuarios' ),
    'menu-adm-usu'              => _( 'M_Administrar-usuarios' ),
    'menu-contras'              => _( 'M_Cambiar-contraseña' ),
    'espere-momento'            => _( 'Espere-un-momento' ),
    'salir'                     => _( 'Salir' ),
    'cerrar-sesion'             => _( 'Cerrar-sesion' ),
    'cambiar-a'                 => _( 'Cambiar-a' ),
    'hace'                      => _( 'Hace' ),
    'no-hay'                    => _( 'No-hay' ),
    'por-revisar'               => _( 'por-revisar' ),
    'ver-todo'                  => _( 'Ver-todo' ),
    'panel-comandos'            => _( 'Panel-de-comandos' ),
    'editor-html'               => _( 'Editor-HTML' ),
    'sin-items'                 => _( 'No-hay-items-para-elegir' ),
    'desde'                     => _( 'Desde' ),
    'hasta'                     => _( 'Hasta' )
);
$this->I = array(
	'sin-conexion'				=> _( 'Error-de-conexion-vuelva-a-intentar-luego' ),
	'respuesta-vacia'			=> _( 'La-respuesta-no-contiene-datos' ),
	'claves-diferentes'			=> _( 'Debe-escribir-dos-veces-la-misma-contraseña' ),
    'base-cambiada'             => _( 'Se-cambio-a:-(n)' ),
    'base-no-cambiada'          => _( 'No-se-eligio-ningun-caso' ),
    'cambiar-imagen'            => _( 'Cambiar-imagen' ),
    'cancelar'                  => _( 'Cancelar' ),
    'elegir-archivo'            => _( 'Elegir-archivo' ),
    'elegir-imagen'             => _( 'Elegir-nueva-imagen' ),
    'error-peso-archivo'        => _( 'El-archivo-supera-el-peso-maximo-permitido' ),
    'error-tipo-archivo'        => _( 'No-se-puede-subir-el-tipo-de-archivo' ),
    'espere'                    => _( 'Espere' ),
    'funcion-no-elegida'        => _( 'No-se-ha-elegido-ninguna-funcion-para-ejecutar' ),
    'funcion-sin-casos'         => _( 'No-hay-casos-elegidos-para-ejecutar-la-funcion' ),
    'guardar'                   => _( 'Guardar' ),
    'opcion-cancelar'           => _( 'No,-cancelar' ),
    'subir'                     => _( 'Cargar' ),
    'url-sin-datos'             => _( 'No-se-indico-una-url-para-abrir' )
);
$this->A['codigo']=array('tipo'=>'texto', 'pos'=>'1', 'minimo'=>10, 'maximo'=>15, 'etiqueta'=>_('A_Codigo'), 'area'=>'1', 'forma'=>'texto_medio', 'ayuda'=>_('A_Codigo'), 'error'=>_('no-es-valido'), 'regla'=>'[A-Za-z0-9]+', 'validar'=>'Restaurar');
$this->A['usuario']=array('tipo'=>'texto', 'pos'=>'2', 'minimo'=>3, 'maximo'=>20, 'etiqueta'=>_('A_Usuario'), 'area'=>'1', 'forma'=>'texto_medio', 'ayuda'=>_('A_Usuario'), 'error'=>_('debe-tener-entre-(min)-y-(max)-caracteres-solo-letras-y-numeros'), 'regla'=>'[A-Za-z0-9]+', 'validar'=>'Autenticar,Restaurar');
$this->A['clave']=array('tipo'=>'texto', 'pos'=>'3', 'minimo'=>5, 'maximo'=>15, 'etiqueta'=>_('A_Contraseña'), 'area'=>'1', 'forma'=>'texto_medio', 'ayuda'=>_('A_Contraseña'), 'error'=>_('debe-tener-entre-(min)-y-(max)-caracteres-solo-letras-numeros-y-caracteres: .,-_'), 'regla'=>'[A-Za-z0-9.,_-]+', 'validar'=>'Autenticar,Restaurar,');
$this->A['clave2']=array('tipo'=>'texto', 'pos'=>'4', 'minimo'=>5, 'maximo'=>15, 'etiqueta'=>_('A_Contraseña'), 'area'=>'1', 'forma'=>'texto_medio', 'ayuda'=>_('A_Contraseña'), 'error'=>_('debe-tener-entre-(min)-y-(max)-caracteres-solo-letras-numeros-y-caracteres: .,-_'), 'regla'=>'[A-Za-z0-9.,_-]+', 'validar'=>'Restaurar,');
$this->A['email']=array('tipo'=>'texto', 'pos'=>'5', 'minimo'=>5, 'maximo'=>50, 'etiqueta'=>_('A_Correo-electronico'), 'area'=>'1', 'forma'=>'texto_medio', 'ayuda'=>_('A_Correo-electronico'), 'error'=>_('debe-ser-un-correo-valido'), 'regla'=>'[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})', 'validar'=>'Enviar');

$this->sql['autenticar'] = "SELECT id, alias, email, imagen, roles, app AS instancia FROM usuarios WHERE (usuario='{{usuario}}') AND (clave='{{clave}}') AND (estado=1) AND (app='{{m_instancia}}') LIMIT 0,1";
$this->sql['comprobar'] = "SELECT id FROM usuarios WHERE (usuario='{{usuario}}') AND (estado=1) AND (codigo='{{codigo}}') AND (app='{{m_instancia}}') AND (CHAR_LENGTH(codigo)>0)";
$this->sql['cambiar'] = "UPDATE usuarios SET clave='{{clave}}', codigo=NULL WHERE usuario='{{usuario}}' AND codigo='{{codigo}}' AND app='{{m_instancia}}'";
$this->sql['buscar'] = "SELECT id, usuario, alias FROM usuarios WHERE (email='{{email}}') AND (estado=1) AND (app='{{m_instancia}}')";
$this->sql['codigo'] = "UPDATE usuarios SET codigo='{{codigo}}' WHERE id='{{id}}' AND app='{{m_instancia}}'";
