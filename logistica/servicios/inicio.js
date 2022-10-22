ME_Ejecutor.prototype.Iniciar = function() {
	M.max = 25;
	M.intervalo = 180000;
	jQuery( 'body' ).on( 'contextmenu', function(e) { return false; });
	M.salir = false;
	toastr.options = { 
		showDuration: 300,
		hideDuration: 1000,
		timeOut: 5000,
		preventDuplicates: true,
		closeButton: true
	};
	jQuery.getScript( M.dir + '/base-atributos?M_IDIOMA=' + M.idioma );
	jQuery.getScript( M.dir + '/usuarios-atributos?M_IDIOMA=' + M.idioma );
	toastr.options.positionClass = 'toast-bottom-center';
	M.Ejecutor.actualizarMenu();
	M.Ejecutor.consultarSeccion();
	M.opciones['datepicker'] = { format: 'yyyy-mm-dd', weekStart: 1, language: 'es', autoclose: true, clearBtn: true, forceParse: false, todayBtn: "linked", todayHighlight: true };
	M.opciones['dates'] = {
		days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
		daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
		daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
		months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
		monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
		today: "Hoy",
		clear: "Borrar"
	}
	jQuery.fn.datepicker.dates.es = M.opciones['dates'];
	jQuery.fn.datepicker.defaults.language = 'es';
};
ME_Ejecutor.prototype.consultarSeccion = function() {
	switch ( M.seccion ) {
		case 'usuarios': M.Usuarios.Consultar(1); break;
		default:
			M.Vista.mostrarZona( 'VISTA_BASE .ME_ESPERE', false );
			break;
	}
};
