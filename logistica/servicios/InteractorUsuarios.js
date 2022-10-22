function ME_Usuarios() {
	this.I = {};
	this.A = {};
}
ME_Usuarios.prototype.Consultar = function( nav ) {
	M.seccion = 'usuarios';
	if ( typeof nav==="undefined" || nav == null ) { nav = M.nav; }
	if ( nav === 0 ) { jQuery('.navbar-collapse').collapse('hide'); nav = 1; }
	M.nav = nav;
	M.uid = 0;
	var campos = jQuery( '#form_buscar' ).serialize();
	M.Vista.Despejar();
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios?' + M.Interactor.anexarValores(true),
		method		: 'GET', 
		data		: campos, 
		cache		: false
	});
	peticion.done( function( respuesta ) {
		M.Vista.Actualizar( respuesta );
		M.Interactor.activarBuscador();
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarZona( 'VISTA_BASE .ME_CONTENIDO', true );
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.Nuevo = function( id ) {
	if ( id == null || typeof id==="undefined" ) { id = ''; }
	var base = 'base=' + encodeURIComponent(id);
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios-nuevo?' + M.Interactor.anexarValores(),
		method		: 'GET', 
		data		: base, 
		cache		: false
	});
	peticion.done( function( respuesta ) {
		M.Vista.abrirVentana( respuesta );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.Agregar = function( modulo ) {
	if ( !M.Interactor.validarFormulario( 'form_agregar', 'Agregar', M.Usuarios.A ) ) { return false; }
	if ( typeof modulo==="undefined" || modulo == null ) { modulo = ''; }
	M.Vista.mostrarZona( 'pie_agregar', false );
	M.Vista.mostrarZona( 'img_agregar', true );
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios?' + M.Interactor.anexarValores(),
		method		: 'POST', 
		contentType	: 'application/json',
		dataType	: 'json',
		cache		: false,
		data		: JSON.stringify( M.Interactor.empacarFormulario( 'form_agregar' ) )
	});
	peticion.done( function( respuesta ) {
		M.Vista.cerrarVentana();
		M.Vista.mostrarRespuesta( respuesta );
		if ( modulo.length > 0 ) {
			M.Usuarios.Consultar( modulo );
		} else {
			M.Usuarios.Consultar(1);
		}
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
		M.Vista.mostrarZona( 'img_agregar', false );
		M.Vista.mostrarZona( 'pie_agregar', true );
	});
	return true;
};
ME_Usuarios.prototype.Abrir = function( id, tab ) {
	if ( typeof tab==="undefined" || tab == null ) { tab = 'General'; }
	var datos = 'seccion=' + encodeURIComponent(tab);
	var caso = jQuery( 'tr#caso_'+ id );
	caso.removeClass( 'me-destacar' );
	caso.addClass( 'me-destacar' );
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios/' + id + '?' + M.Interactor.anexarValores(),
		method		: 'GET', 
		data		: datos, 
		cache		: false
	});
	peticion.done( function( respuesta ) {
		M.Vista.abrirVentana( respuesta );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.Editar = function( id ) {
	if ( !M.Interactor.validarFormulario( 'form_editar', 'Editar', M.Usuarios.A ) ) { return false; }
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios/' + id + '?' + M.Interactor.anexarValores(),
		method		: 'PUT', 
		contentType	: 'application/json',
		dataType	: 'json',
		cache		: false,
		data		: JSON.stringify( M.Interactor.empacarFormulario( 'form_editar' ) )
	});
	peticion.done( function( respuesta ) {
		M.Vista.cerrarVentana();
		M.Vista.mostrarRespuesta( respuesta );
		M.Usuarios.Refrescar( id );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.Borrar = function( id ) {
	swal({
		title: M.Usuarios.I['titulo-borrar'],
		text: M.Usuarios.I['alerta-borrar'],
		confirmButtonText: M.Usuarios.I['opcion-borrar'],
		cancelButtonText: M.Usuarios.I['opcion-cancelar'],
		type: "warning",
		confirmButtonColor: "#ed5565",
		showCancelButton: true,
		closeOnConfirm: true,
		closeOnCancel: true
		}, function( confirma ) {
			if ( confirma) {
				var peticion = jQuery.ajax({
					url			: M.dir + '/usuarios/' + id + '?' + M.Interactor.anexarValores(),
					method		: 'DELETE', 
					contentType	: 'application/json',
					dataType	: 'json',
					cache		: false
				});
				peticion.done( function( respuesta ) {
					M.Vista.mostrarRespuesta( respuesta );
					jQuery( 'tr#caso_' + id ).fadeOut( 'slow' );
					jQuery( 'div#modulo_' + id ).fadeOut( 'slow' );
				});
				peticion.fail( function( jqXHR, estado, mensaje ) {
					M.Vista.mostrarError( jqXHR, estado, mensaje );
				});
			}
		}
	);
};
ME_Usuarios.prototype.Imagen = function( div, img, ancho, id ) {
	M.subir = jQuery( '#' + div ).uploadFile({
		url: M.url + '/usuarios/' + id + '-imagen', 
		acceptFiles: 'image/*', 
		allowedTypes: 'jpg,jpeg,png', 
		method: 'POST', 
		enctype: 'multipart/form-data', 
		returnType: 'json', 
		fileName: 'file',
		previewWidth: ancho, 
		dragDrop: false, 
		showPreview: true, 
		showCancel: true,
		showAbort: false,
		showDone: false,
		showFileCounter: false,
		multiple: false, 
		autoSubmit: false,
		uploadStr: M.Usuarios.I['cambiar-imagen'], 
		cancelStr: M.Usuarios.I['cancelar'],
		extraHTML: function() {
			return '<div class="ajax-file-upload-green" onclick="M.subir.startUpload()">' + M.Usuarios.I['subir'] + '</div>';
		},
		onSelect: function( files ) {
			jQuery( '.ajax-file-upload-statusbar' ).remove();
			return true; 
		},
		onSuccess: function( files, data, xhr, pd ) {
			jQuery( '#' + img ).attr( 'src', data );
			jQuery( '.ajax-file-upload-statusbar' ).remove();
		}
	});
};
ME_Usuarios.prototype.Atributos = function( clase ) {
	if ( typeof clase==="undefined" || clase == null ) { clase = ''; }
	jQuery.getScript( M.dir + '/usuarios-atributos?M_IDIOMA=' + M.idioma + '&clase=' + encodeURIComponent(clase) );
};
ME_Usuarios.prototype.Refrescar = function( id ) {
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios/' + id + '-refrescar?' + M.Interactor.anexarValores(),
		method		: 'GET', 
		cache		: false
	});
	peticion.done( function( respuesta ) {
		jQuery( 'tr#caso_' + id ).html( respuesta );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.nuevoAvatar = function() {
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios-nuevoavatar?' + M.Interactor.anexarValores(),
		method		: 'GET', 
		cache		: false
	});
	peticion.done( function( respuesta ) {
		M.Vista.abrirVentana( respuesta );
		M.Usuarios.Avatar( 'upload_avatar', 'imagen_avatar', '300px' );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.Avatar = function( div, img, ancho ) {
	M.subir = jQuery( '#' + div ).uploadFile({
		url: M.url + '/usuarios-avatar',
		acceptFiles: 'image/*', 
		allowedTypes: 'jpg,jpeg,png', 
		method: 'POST', 
		enctype: 'multipart/form-data', 
		returnType: 'json', 
		fileName: 'file',
		previewWidth: ancho, 
		dragDrop: false, 
		showPreview: true, 
		showCancel: true,
		showAbort: false,
		showDone: false,
		showFileCounter: false,
		multiple: false, 
		autoSubmit: false,
		uploadStr: M.Usuarios.I['elegir-imagen'], 
		cancelStr: M.Usuarios.I['cancelar'],
		extraHTML: function() {
			return '<div class="ajax-file-upload-green" onclick="M.subir.startUpload()">' + M.Usuarios.I['subir'] + '</div>';
		},
		onSelect: function( files ) {
			jQuery( '.ajax-file-upload-statusbar' ).remove();
			return true; 
		},
		onSuccess: function( files, data, xhr, pd ) {
			jQuery( 'img#' + img ).attr( 'src', data );
			jQuery( 'img.' + img ).attr( 'src', data );
			jQuery( '#avatar_usuario' ).attr( 'src', data );
			jQuery( '.ajax-file-upload-statusbar' ).remove();
			M.Vista.cerrarVentana();
			M.Vista.verMensaje( 'exito', M.Usuarios.I['imagen-cambiada'] );
		}
	});
};
ME_Usuarios.prototype.nuevaClave = function() {
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios-nuevaclave?' + M.Interactor.anexarValores(),
		method		: 'GET', 
		cache		: false
	});
	peticion.done( function( respuesta ) {
		M.Vista.abrirVentana( respuesta );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
	});
};
ME_Usuarios.prototype.Clave = function() {
	if ( !M.Interactor.validarFormulario( 'form_clave', 'Clave', M.Usuarios.A ) ) { return false; }
	var campo1 = jQuery( "#form_clave input[name='nueva']" );
	var campo2 = jQuery( "#form_clave input[name='nueva2']" );
	var nueva = campo1.val() || '';
	var nueva2 = campo2.val() || '';
	if ( nueva !== nueva2 ) {
		M.Vista.verMensaje( 'error', M.Usuarios.I['claves-diferentes'] );
		campo2.val('');
		campo1.val('');
		campo1.focus();
		return false;
	}
	var peticion = jQuery.ajax({
		url			: M.dir + '/usuarios-clave?' + M.Interactor.anexarValores(),
		method		: 'POST', 
		contentType	: 'application/json',
		dataType	: 'json',
		cache		: false,
		data		: JSON.stringify( M.Interactor.empacarFormulario( 'form_clave' ) )
	});
	peticion.done( function( respuesta ) {
		M.Vista.cerrarVentana();
		M.Vista.mostrarRespuesta( respuesta );
	});
	peticion.fail( function( jqXHR, estado, mensaje ) {
		M.Vista.mostrarError( jqXHR, estado, mensaje );
		jQuery( "#form_clave input[name='clave']" ).focus();
	});
};

M.Usuarios = new ME_Usuarios();
