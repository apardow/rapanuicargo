<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="utf-8" indent="yes" />
	<xsl:include href="plantillas.xsl"/>

	<xsl:template match="/">
		<xsl:variable name="interaccion" select="//modelo[@id='Usuarios']/permisos[@operacion=//entorno/OPERACION]/@para" />
		<xsl:choose>
			<xsl:when test=" $interaccion = 'Consultar' ">
				<xsl:call-template name="ConsultarLista" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'Nuevo' ">
				<xsl:call-template name="NuevoCaso" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'Abrir' or $interaccion = 'Agregar' ">
				<xsl:call-template name="AbrirCaso" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'Refrescar' ">
				<xsl:call-template name="FilaCaso">
					<xsl:with-param name="fila" select="//resultados[@grupo='caso']" />
				</xsl:call-template>
			</xsl:when>
			<xsl:when test=" $interaccion = 'Ver' ">
				<xsl:call-template name="VerCaso" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'Exportar' ">
				<xsl:call-template name="ExportarCaso" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'Adjuntar' ">
				<xsl:call-template name="AdjuntarArchivo" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'nuevoAvatar' ">
				<xsl:call-template name="VentanaAvatar" />
			</xsl:when>
			<xsl:when test=" $interaccion = 'nuevaClave' ">
				<xsl:call-template name="VentanaClave" />
			</xsl:when>
			<!--[PERSONALIZADAS]-->
		</xsl:choose>
    </xsl:template>

	<xsl:template name="ConsultarLista">
		<xsl:variable name="nav" select="//resultados[@grupo='usuarios']/resumen/nav"/>
		<xsl:variable name="paginas" select="//resultados[@grupo='usuarios']/resumen/paginas"/>
		<xsl:variable name="total" select="//resultados[@grupo='usuarios']/resumen/total"/>
		<xsl:variable name="max" select="//resultados[@grupo='usuarios']/resumen/max"/>
		<div id="titulo_seccion" class="row wrapper white-bg page-heading">
			<div class="col-lg-12 text-left text-success animated fadeInLeft">
				<h2 class="font-bold"><i class="fa fa-user-circle"></i>&#160;((Administrar-casos))</h2>
			</div>
		</div>
		<div id="panel_listado" class="wrapper wrapper-content animated fadeInUp m-t-xs" style="padding: 0">
			<form action="javascript:void(0)" role="form" id="form_buscar">
				<div class="row">
					<div class="col-sm-3">
					</div>
					<div class="col-sm-9 text-right">
						<div class="input-group mb-3">
							<xsl:for-each select="//f/*">
								<xsl:sort select="pos" data-type="number" order="descending" />
								<xsl:sort select="position()" data-type="number" order="descending" />
								<xsl:variable name="nombre" select="name()" />
								<xsl:call-template name="campo_filtro">
									<xsl:with-param name="campo" select="$nombre" />
									<xsl:with-param name="tipo" select="tipo" />
									<xsl:with-param name="etiqueta" select="etiqueta" />
									<xsl:with-param name="forma" select="forma" />
								</xsl:call-template>
							</xsl:for-each>
							<div class="input-group-append">
								<button class="btn btn-xs btn-success" type="button" onclick="M.Usuarios.Consultar(1)" title="((Buscar))">&#160;&#160;<i class="fa fa-search"></i>&#160;&#160;</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-lg-12" style="padding-right:0; padding-left:0">
					<div class="ibox">
						<div class="ibox-content">
							<div class="container">
								<div class="row">
									<div class="col-sm-8 text-left">
										<xsl:if test="$total > 1">
											<xsl:value-of select="//resultados[@grupo='usuarios']/resumen/leyenda"/>
										</xsl:if>
									</div>
									<div class="col-sm-4 text-right">
										<xsl:if test= "//modelo[@id='Usuarios']/permisos[@para='Agregar']">
											<button class="btn btn-success" type="button" onclick="M.Usuarios.Nuevo()" title="((Agregar-caso))"><i class="fa fa-plus"></i>&#160;&#160;<span class="bold">((Agregar-caso))</span></button>
										</xsl:if>
									</div>
								</div>
							</div>
							<div>
								<form action="javascript:void(0)" role="form" id="form_casos">
									<div id="panel_funciones" style="display: none">
										<xsl:if test="//modelo[@id='Usuarios']/funcion">
											<div class="row" style="padding-bottom: 6px;">
												<div class="rbo" style="margin-left: 6px;">
													<input type="checkbox" class="i-lista" value="" id="i-lista" onclick="M.Interactor.marcarTodos(this, 'i-caso')" />
													<label for="i-lista">&#160;&#160;</label>
												</div>
												<select name="funcion" class="form-control" style="width: auto" onchange="M.Interactor.mostrarParametros(this)">
													<option value="" selected="true" disabled="true" class="me-filtro">((Funcion))</option>
													<xsl:for-each select="//modelo[@id='Usuarios']/funcion">
														<option value="{@id}"><xsl:value-of select="@etiqueta" /></option>
													</xsl:for-each>
												</select>
												<xsl:for-each select="//modelo[@id='Usuarios']/funcion">
													<xsl:call-template name="campo_param">
														<xsl:with-param name="funcion" select="@id" />
														<xsl:with-param name="forma" select="@forma" />
														<xsl:with-param name="campo" select="@campo" />
													</xsl:call-template>
												</xsl:for-each>
												<button class="btn btn-xs btn-default" type="button" onclick="M.Usuarios.Ejecutar()" title="((Hacer))">((Hacer))<big>&#160;&#160;<i class="fa fa-play"></i>&#160;&#160;</big></button>
											</div>
										</xsl:if>
									</div>
									<xsl:if test="$total=0">
										<big><p class="text-danger font-bold">
										<br/><xsl:value-of select="//resultados[@grupo='usuarios']/resumen/leyenda"/>
										</p></big>
									</xsl:if>
									<table class="table table-hover text-left">
										<tbody>
										<xsl:for-each select="//resultados[@grupo='usuarios']/coleccion/elemento">
											<xsl:variable name="fila" select="." />
											<tr id="caso_{$fila/id}">
												<xsl:call-template name="FilaCaso">
													<xsl:with-param name="fila" select="$fila" />
												</xsl:call-template>
											</tr>
										</xsl:for-each>
										</tbody>
									</table>
								</form>
							</div>
							<div class="text-center">
								<div class="btn-group">
									<xsl:if test="$nav > 1">
										<button class="btn btn-white" type="button" onclick="M.Usuarios.Consultar({$nav - 1})"><i class="fa fa-chevron-left"></i></button>
									</xsl:if>
									<xsl:for-each select="//resultados[@grupo='usuarios']/paginador/item">
										<xsl:variable name="p" select="."/>
										<button onclick="M.Usuarios.Consultar({$p})">
											<xsl:attribute name="class">
												<xsl:choose>
													<xsl:when test="$nav=$p">btn btn-white active</xsl:when>
													<xsl:otherwise>btn btn-white </xsl:otherwise>
												</xsl:choose>
											</xsl:attribute>
											<xsl:value-of select="$p"/>
										</button>
									</xsl:for-each>
									<xsl:if test="$nav &lt; $paginas">
										<button class="btn btn-white" type="button" onclick="M.Usuarios.Consultar({$nav + 1})"><i class="fa fa-chevron-right"></i></button>
									</xsl:if>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			jQuery(document).ready( function() {
				M.Usuarios.Atributos();
			});
		</script>
	</xsl:template>
	<xsl:template name="FilaCaso">
		<xsl:param name="fila" />
		<xsl:if test="count($fila/imagen)>0">
			<td style="width: 64px">
				<img src="{$fila/imagen}" class="rounded-circle img-md" />
			</td>
		</xsl:if>
		<td>
			<xsl:choose>
				<xsl:when test="//modelo[@id='Usuarios']/funcion">
					<div class="rbo">
						<input type="checkbox" class="i-caso" value="{$fila/id}" name="caso[]" id="l{$fila/id}" onclick="M.Interactor.marcarItem('{$fila/id}')" />
						<label for="l{$fila/id}">
							<big><xsl:value-of select="$fila/alias" /></big><br/>
							<xsl:if test="string-length($fila/email)>0">
								<span class="d-none d-sm-none d-md-inline"><xsl:choose><xsl:when test="string-length($fila/email)>30"><xsl:value-of select="substring($fila/email,1,29)" />…</xsl:when><xsl:otherwise><xsl:value-of select="$fila/email" /></xsl:otherwise></xsl:choose></span>
							</xsl:if>
						</label>
					</div>
				</xsl:when>
				<xsl:otherwise>
					<div>
						<big><xsl:value-of select="$fila/alias" /></big><br/>
						<xsl:if test="string-length($fila/email)>0">
							<span class="d-none d-sm-none d-md-inline"><xsl:choose><xsl:when test="string-length($fila/email)>30"><xsl:value-of select="substring($fila/email,1,29)" />…</xsl:when><xsl:otherwise><xsl:value-of select="$fila/email" /></xsl:otherwise></xsl:choose></span>
						</xsl:if>
					</div>
				</xsl:otherwise>
			</xsl:choose>
			<span>
				<xsl:choose>
					<xsl:when test="$fila/estado='0'">
						<xsl:attribute name="class">badge badge-warning</xsl:attribute>
					</xsl:when>
					<xsl:when test="$fila/estado='1'">
						<xsl:attribute name="class">badge badge-primary</xsl:attribute>
					</xsl:when>
					<xsl:when test="$fila/estado='2'">
						<xsl:attribute name="class">badge</xsl:attribute>
					</xsl:when>
				</xsl:choose>
				<xsl:value-of select="//d/estado/valor[id=$fila/estado]/etiqueta" />
			</span>
			<xsl:if test="string-length(//d/clase/valor[id=$fila/clase]/etiqueta)>0">
				&#160;<span class="badge"><xsl:value-of select="//d/clase/valor[id=$fila/clase]/etiqueta" /></span>
			</xsl:if>
		</td>
		<td style="vertical-align: middle; text-align: right; width: 25%;">
			<xsl:if test="//modelo[@id='Usuarios']/permisos[@para='Ver']">
				<a href="javascript:void(0)" class="btn btn-white" 
					onclick="M.Usuarios.Ver('{$fila/id}')" 
					title="((Ver-caso))">
					&#160;<big><i class="fa fa-eye"></i></big>&#160;
				</a>
			</xsl:if>
			<xsl:if test="//modelo[@id='Usuarios']/permisos[@para='Editar']">
				<a href="javascript:void(0)" class="btn btn-white" 
					onclick="M.Usuarios.Abrir('{$fila/id}', 'General')" 
					title="((Editar-caso))">
					&#160;<big><i class="fa fa-pencil"></i></big>&#160;
				</a>
			</xsl:if>
			<xsl:if test="//modelo[@id='Usuarios']/permisos[@para='Borrar']">
				<span class="d-none d-sm-none d-md-inline">
				<a href="javascript:void(0)" class="btn btn-white" 
					onclick="M.Usuarios.Borrar('{$fila/id}')" 
					title="((Borrar-caso))">
					&#160;<big><i class="fa fa-trash"></i></big>&#160;
				</a>
				</span>
			</xsl:if>
		</td>
    </xsl:template>
	<xsl:template name="NuevoCaso">
		<xsl:variable name="caso" select="//resultados[@grupo='caso']"/>
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span>
						<span class="sr-only">((Cerrar))</span>
					</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> &#160;((Agregar-caso))</h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" role="form" id="form_agregar">
						<div class="row">
							<div class="col-lg-12" style="width:100%">
								<xsl:for-each select="//a/*[forma!='']">
									<xsl:sort select="pos" data-type="number" order="ascending" />
									<xsl:variable name="nombre" select="name()" />
									<xsl:variable name="validar" select="validar" />
									<xsl:if test="contains(concat(',',validar,','), ',Agregar,')">
										<xsl:call-template name="campo_form">
											<xsl:with-param name="campo" select="$nombre" />
											<xsl:with-param name="valor" select="$caso/*[name()=$nombre]/text()" />
											<xsl:with-param name="id" select="$caso/id" />
											<xsl:with-param name="maximo" select="''" />
										</xsl:call-template>
									</xsl:if>
								</xsl:for-each>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer" id="pie_agregar">
					<button type="button" class="btn btn-white" data-dismiss="modal">((Cancelar))</button>
					<button type="button" class="btn btn-success" onclick="M.Usuarios.Agregar()">((Guardar-caso))</button>
				</div>
				<div class="me-ocultar h1 text-success text-center" id="img_agregar">
					<img src="/webme/img/espere.gif" />
				</div>
			</div>
		</div>
    </xsl:template>
	<xsl:template name="AbrirCaso">
		<xsl:variable name="caso" select="//resultados[@grupo='caso']"/>
		<xsl:variable name="tab">
			<xsl:choose>
				<xsl:when test="string-length($seccion)>0"><xsl:value-of select="$seccion" /></xsl:when>
				<xsl:otherwise>General</xsl:otherwise>
			</xsl:choose>
		</xsl:variable>
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span>
						<span class="sr-only">((Cerrar))</span>
					</button>
					<h4 class="modal-title"><i class="fa fa-pencil"></i> &#160;((Editar-caso))</h4>
				</div>
				<div class="modal-body">
					<xsl:if test="string-length($mensaje)>0">
						<div class="alert alert-success text-center"><xsl:value-of select="$mensaje" /></div>
					</xsl:if>
					<div class="row">
						<div class="col-sm-6 text-left">
							<big><b><xsl:value-of select="$caso/nombre" /></b></big>
						</div>
						<div class="col-sm-6 text-right">
							<button type="button" class="btn btn-success" onclick="M.Usuarios.Editar({$caso/id})">((Guardar-cambios))</button>
						</div>
					</div>
					<br/>
					<form action="javascript:void(0)" role="form" id="form_editar">
						<div class="row">
							<div class="col-lg-12" style="width:100%">
								<div class="tabs-container">
									<ul class="nav nav-tabs" role="tablist">
										<xsl:for-each select="//d/area/valor">
											<li><a data-toggle="tab" href="#tab-{id}" class="nav-link">
												<xsl:choose>
													<xsl:when test="id=$tab">
														<xsl:attribute name="class">nav-link active</xsl:attribute>
													</xsl:when>
													<xsl:otherwise>
														<xsl:attribute name="class">nav-link</xsl:attribute>
													</xsl:otherwise>
												</xsl:choose>
												<xsl:if test="etiqueta!='General'"><xsl:value-of select="etiqueta" /></xsl:if>
											</a></li>
										</xsl:for-each>
									</ul>
									<div class="tab-content">
										<xsl:for-each select="//d/area/valor">
											<xsl:variable name="area" select="id" />
											<div role="tabpanel" id="tab-{$area}">
												<xsl:choose>
													<xsl:when test="$area=$tab">
														<xsl:attribute name="class">tab-pane active</xsl:attribute>
													</xsl:when>
													<xsl:otherwise>
														<xsl:attribute name="class">tab-pane</xsl:attribute>
													</xsl:otherwise>
												</xsl:choose>
												<div class="panel-body">
													<xsl:for-each select="//a/*[area=$area][forma!='']">
														<xsl:sort select="pos" data-type="number" order="ascending" />
														<xsl:variable name="nombre" select="name()" />
														<xsl:variable name="validar" select="validar" />
														<xsl:if test="contains(concat(',',validar,','), ',Editar,')">
															<xsl:call-template name="campo_form">
																<xsl:with-param name="campo" select="$nombre" />
																<xsl:with-param name="maximo" select="maximo" />
																<xsl:with-param name="valor" select="$caso/*[name()=$nombre]/text()" />
																<xsl:with-param name="id" select="$caso/id" />
															</xsl:call-template>
														</xsl:if>
													</xsl:for-each>
												</div>
											</div>
										</xsl:for-each>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">((Cancelar))</button>
					<button type="button" class="btn btn-success"  onclick="M.Usuarios.Editar({$caso/id})">((Guardar-cambios))</button>
				</div>
			</div>
		</div>
		<xsl:if test="string-length($caso/clase)>0 and 'Usuarios'='Actividades'">
			<script type="text/javascript">
				jQuery(document).ready( function() {
					M.Usuarios.Atributos('<xsl:value-of select="$caso/clase" />');
				});
			</script>
		</xsl:if>
    </xsl:template>
	
	<xsl:template name="VentanaAvatar">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span>
						<span class="sr-only">((Cerrar))</span>
					</button>
					<h4 class="modal-title">((Cambiar-imagen))</h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" role="form" id="form_avatar">
						<div class="me-centrar">
							<xsl:choose>
								<xsl:when test="string-length($usu_imagen)>0">
									<big><p>((Imagen-actual))</p></big>
									<div><img src="{$usu_imagen}" id="imagen_avatar" /></div>
								</xsl:when>
								<xsl:otherwise>
									<div><img id="imagen_avatar" /></div>
								</xsl:otherwise>
							</xsl:choose>
							<br/>
							<div id="upload_avatar"></div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal">((Cerrar))</button>
				</div>
			</div>
		</div>
    </xsl:template>

	<xsl:template name="VentanaClave">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						<span aria-hidden="true">&#215;</span>
						<span class="sr-only">((Cerrar))</span>
					</button>
					<h4 class="modal-title">((Cambiar-contraseña))</h4>
				</div>
				<div class="modal-body">
					<form action="javascript:void(0)" role="form" id="form_clave">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">((Contraseña-actual))</label>
							<div class="col-sm-8 col-form-label text-left">
								<input type="password" name="clave" class="form-control" placeholder="((Escriba-su-contraseña-actual))" required="required" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">((Nueva-contraseña))</label>
							<div class="col-sm-8 col-form-label text-left">
								<input type="password" name="nueva" class="form-control" placeholder="((Escriba-su-nueva-contraseña))" required="required" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">((Confirmar))</label>
							<div class="col-sm-8 col-form-label text-left">
								<input type="password" name="nueva2" class="form-control" placeholder="((Vuelva-a-escribirla))" required="required" />
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">((Cancelar))</button>
					<button type="button" class="btn btn-success"  onclick="M.Usuarios.Clave()">((Guardar-cambios))</button>
				</div>
			</div>
		</div>
    </xsl:template>


	<xsl:template name="mostrar_caso">
		<xsl:variable name="caso" select="//resultados[@grupo='caso']"/>
    </xsl:template>

</xsl:stylesheet>