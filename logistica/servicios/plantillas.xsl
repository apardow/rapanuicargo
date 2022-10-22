<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" encoding="utf-8" indent="yes" />

	<xsl:template name="form_personalizado">
		<xsl:param name="campo" />
		<xsl:param name="valor" />
		<xsl:param name="etiqueta" />
		<xsl:param name="maximo" />
		<xsl:param name="regla" />
		<xsl:param name="ayuda" />
		<xsl:param name="id" />
		<xsl:choose>
			<xsl:when test="$campo='xxxxx'">
			</xsl:when>
		</xsl:choose>
	</xsl:template>

	<xsl:template name="filtro_personalizado">
		<xsl:param name="campo" />
		<xsl:param name="valor" />
		<xsl:param name="etiqueta" />
		<xsl:param name="texto" />
		<xsl:choose>
			<xsl:when test="$campo='xxxxx'">
			</xsl:when>
		</xsl:choose>
	</xsl:template>

</xsl:stylesheet>