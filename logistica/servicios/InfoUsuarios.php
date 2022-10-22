<?php 
use \MasExperto\ME\Bases\BaseDatos;

$this->entidad = 'usuarios';
$this->tabla = 'usuarios';

$this->sql['agregar'] = "INSERT INTO usuarios (alias, email, roles, usuario, clave, app) VALUES ('{{alias}}', '{{email}}', '{{roles}}', '{{usuario}}', '{{clave}}', '{{m_instancia}}');";
$this->sql['editar'] = "UPDATE usuarios SET alias='{{alias}}', email='{{email}}', estado='{{estado}}', roles='{{roles}}' WHERE id='{{id}}' AND app='{{m_instancia}}';";
$this->sql['consultar'] = "SELECT id, alias, email, estado, imagen FROM usuarios WHERE 1 AND app='{{m_instancia}}' ORDER BY id DESC;";
$this->sql['borrar'] = "DELETE FROM usuarios WHERE id='{{id}}' AND app='{{m_instancia}}';";
$this->sql['abrir'] = "SELECT * FROM usuarios WHERE id='{{id}}' AND app='{{m_instancia}}'";
$this->sql['caso_leer'] = "SELECT imagen FROM usuarios WHERE id='{{id}}' AND app='{{m_instancia}}'";
$this->sql['cambiar_imagen'] = "UPDATE usuarios SET imagen='{{imagen}}' WHERE id='{{id}}' AND app='{{m_instancia}}'";
$this->sql['comprobar_clave'] = "SELECT alias FROM usuarios WHERE (clave='{{clave}}') AND (estado=1) AND (id='{{id}}') AND (app='{{m_instancia}}')";
$this->sql['cambiar_clave'] = "UPDATE usuarios SET clave='{{clave}}' WHERE id='{{id}}' AND app='{{m_instancia}}'";

$this->F['alias'] = array('codigo'=>BaseDatos::FILTRO_CONTIENE, 'etiqueta'=>'Nombre', 'tipo'=>'CONTIENE', 'pos'=>'1', 'forma'=>'texto_largo');
$this->F['email'] = array('codigo'=>BaseDatos::FILTRO_CONTIENE, 'etiqueta'=>'Correo', 'tipo'=>'CONTIENE', 'pos'=>'2', 'forma'=>'texto_largo');
$this->F['estado'] = array('codigo'=>BaseDatos::FILTRO_NUMERO, 'etiqueta'=>'Estado', 'tipo'=>'NUMERO', 'pos'=>'3', 'forma'=>'lista_diccionario');
$this->F['roles'] = array('codigo'=>BaseDatos::FILTRO_INCLUYE, 'etiqueta'=>'Roles', 'tipo'=>'INCLUYE', 'pos'=>'4', 'forma'=>'lista_opciones');

$this->D['estado'] = array( array('id'=>'1','etiqueta'=>'Vigente'), array('id'=>'0','etiqueta'=>'No vigente'));
$this->D['roles'] = array( array('id'=>'Admin','etiqueta'=>'Administrador'), array('id'=>'Usua','etiqueta'=>'Usuario'));
$this->D['area'] = array( array('id'=>'General','etiqueta'=>'General'));

$this->A['alias'] = array('tipo'=>'texto', 'pos'=>'1', 'minimo'=>5, 'maximo'=>50, 'etiqueta'=>'Nombre', 'area'=>'General', 'forma'=>'texto_largo', 'ayuda'=>'Nombre de la persona', 'error'=>'debe tener entre (min) y (max) caracteres, sólo letras', 'regla'=>'[A-Za-zÀ-ÿ ª\"\'\.]+', 'validar'=>'Agregar,Editar');
$this->A['email'] = array('tipo'=>'texto', 'pos'=>'2', 'minimo'=>5, 'maximo'=>50, 'etiqueta'=>'Correo', 'area'=>'General', 'forma'=>'texto_largo', 'ayuda'=>'Correo electrónico', 'error'=>'debe ser un correo válido', 'regla'=>'[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})', 'validar'=>'Agregar,Editar');
$this->A['estado'] = array('tipo'=>'entero', 'pos'=>'3', 'minimo'=>0, 'maximo'=>1, 'etiqueta'=>'Estado', 'area'=>'General', 'forma'=>'lista_diccionario', 'ayuda'=>'', 'error'=>'', 'regla'=>'', 'validar'=>'Editar');
$this->A['roles'] = array('tipo'=>'opciones', 'pos'=>'4', 'minimo'=>1, 'maximo'=>0, 'etiqueta'=>'Roles', 'area'=>'General', 'forma'=>'lista_opciones', 'ayuda'=>'', 'error'=>'', 'regla'=>'', 'validar'=>'Agregar,Editar');
$this->A['usuario'] = array('tipo'=>'texto', 'pos'=>'5', 'minimo'=>3, 'maximo'=>50, 'etiqueta'=>'Usuario', 'area'=>'General', 'forma'=>'texto_medio', 'ayuda'=>'Nombre de usuario', 'error'=>'debe tener entre (min) y (max) caracteres', 'regla'=>'', 'validar'=>'Agregar,');
$this->A['clave'] = array('tipo'=>'texto', 'pos'=>'6', 'minimo'=>5, 'maximo'=>15, 'etiqueta'=>'Contraseña', 'area'=>'General', 'forma'=>'texto_medio', 'ayuda'=>'Contraseña', 'error'=>'debe tener entre (min) y (max) caracteres, sólo letras, números y caracteres: .,-_', 'regla'=>'[A-Za-z0-9.,_-]+', 'validar'=>'Agregar,');
$this->A['imagen'] = array('tipo'=>'texto', 'pos'=>'7', 'minimo'=>0, 'maximo'=>120, 'etiqueta'=>'', 'area'=>'General', 'forma'=>'cambiar_imagen', 'ayuda'=>'', 'error'=>'', 'regla'=>'', 'validar'=>'');
$this->A['nueva'] = array('tipo'=>'texto', 'pos'=>'9', 'minimo'=>5, 'maximo'=>15, 'etiqueta'=>'Nueva contraseña', 'area'=>'General', 'forma'=>'texto_medio', 'ayuda'=>'Escriba su nueva contraseña', 'error'=>'debe tener entre (min) y (max) caracteres, sólo letras, números y caracteres: .,-_', 'regla'=>'[A-Za-z0-9.,_-]+', 'validar'=>'Clave');
$this->A['nueva2'] = array('tipo'=>'texto', 'pos'=>'10', 'minimo'=>5, 'maximo'=>15, 'etiqueta'=>'Contraseña confirmada', 'area'=>'', 'forma'=>'texto_medio', 'ayuda'=>'Vuelva a escribirla', 'error'=>'debe tener entre (min) y (max) caracteres, sólo letras, números y caracteres: .,-_', 'regla'=>'[A-Za-z0-9.,_-]+', 'validar'=>'Clave');

$this->I['titulo-borrar'] = _('¿Borrar-caso?');
$this->I['alerta-borrar'] = _('Se-perderan-los-datos-de-este-caso');
$this->I['opcion-borrar'] = _('Si,-borrar-caso');
$this->I['opcion-cancelar'] = _('No,-cancelar');
$this->I['cancelar'] = _('Cancelar');
$this->I['elegir-imagen'] = _('Elegir-nueva-imagen');
$this->I['imagen-cambiada'] = _('La-imagen-fue-cambiada');
$this->I['cambiar-imagen'] = _('Cambiar-imagen');
$this->I['subir'] = _('Subir');
$this->I['opcion-continuar'] = _('Si,-continuar');
$this->I['espere'] = _('Espere');
$this->I['guardar'] = _('Guardar');
$this->I['funcion-sin-casos'] = _('No-hay-casos-elegidos-para-ejecutar-la-funcion');
$this->I['funcion-no-elegida'] = _('No-se-ha-elegido-ninguna-funcion-para-ejecutar');
$this->I['titulo-registrar'] = _('¿Realizar-cambio?');
$this->I['sin-conexión'] = _('Error-de-conexion,-vuelva-a-intentar-luego');
$this->I['respuesta-vacia'] = _('No-se-recibieron-datos');
$this->I['url-sin-datos'] = _('No-se-indico-una-url-para-abrir');
$this->T['caso-guardado'] = _('El-caso-fue-guardado');
$this->T['caso-no-guardado'] = _('El-caso-no-pudo-ser-guardado');
$this->T['caso-actualizado'] = _('El-caso-fue-actualizado');
$this->T['caso-no-actualizado'] = _('El-caso-no-pudo-ser-actualizado');
$this->T['caso-borrado'] = _('El-caso-fue-borrado');
$this->T['caso-no-borrado'] = _('El-caso-no-pudo-ser-borrado');
$this->T['caso-no-existe'] = _('No-se-encontro-el-caso-solicitado');
$this->T['leyenda-lista'] = _('(total)-casos.-Lista-del-(primero)-al-(ultimo)');
$this->T['leyenda-vacia'] = _('No-hay-casos');
$this->T['error-lista'] = _('Se-produjo-un-error-al-consultar-los-datos');
$this->T['casos-actualizados'] = _('Los-casos-fueron-actualizados');
$this->T['casos-no-actualizados'] = _('Los-casos-no-pudieron-actualizarse');
$this->T['archivo-cargado'] = _('El-archivo-fue-cargado');
$this->T['archivo-no-cargado'] = _('El-archivo-no-pudo-cargarse');
$this->T['imagen-no-asignada'] = _('La-imagen-no-pudo-ser-asignada');
$this->T['archivo-no-guardado'] = _('El-archivo-no-fue-guardado');
$this->T['archivo-guardado'] = _('El-archivo-fue-guardado');
$this->T['imagen-actual'] = _('Imagen-actual');
$this->T['nuevo-caso'] = _('Nuevo-caso');
$this->T['titulo-seccion'] = _('Administrar-casos');
$this->T['agregar-caso'] = _('Agregar-caso');
$this->T['ver-caso'] = _('Ver-caso');
$this->T['editar-caso'] = _('Editar-caso');
$this->T['borrar-caso'] = _('Borrar-caso');
$this->T['guardar-caso'] = _('Guardar-caso');
$this->T['adjuntar-archivo'] = _('Adjuntar-archivo');
$this->T['exportar-pdf'] = _('Exportar-PDF');
$this->T['buscar'] = _('Buscar');
$this->T['funcion'] = _('Funcion');
$this->T['hacer'] = _('Hacer');
$this->T['cambiar-estado'] = _('Cambiar-estado');
$this->T['cerrar'] = _('Cerrar');
$this->T['guardar-cambios'] = _('Guardar-cambios');
$this->T['editor-html'] = _('Editor-HTML');
$this->T['no-hay-items'] = _('No-hay-items-para-elegir');
$this->T['todo'] = _('TODO');
$this->T['desde'] = _('Desde');
$this->T['hasta'] = _('Hasta');
$this->I['claves-diferentes'] = _('Debe-escribir-dos-veces-la-nueva-contraseña');
$this->T['cambiar-clave'] = _('Cambiar-contraseña');
$this->T['cambiar-imagen'] = _('Cambiar-la-imagen');
$this->T['clave-actual'] = _('Contraseña-actual');
$this->T['clave-cambiada'] = _('La-contraseña-fue-cambiada');
$this->T['clave-no-cambiada'] = _('La-contraseña-no-pudo-cambiarse');
$this->T['clave-no-valida'] = _('La-contraseña-enviada-no-es-valida');
$this->T['clave-nueva'] = _('Nueva-contraseña');
$this->T['msg-clave-actual'] = _('Escriba-su-contraseña-actual');
$this->T['msg-clave-confirm'] = _('Vuelva-a-escribirla');
$this->T['msg-clave-nueva'] = _('Escriba-su-nueva-contraseña');

?>