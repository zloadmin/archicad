<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
												xmlns:fo="http://www.w3.org/1999/XSL/Format"
												xmlns:database="http://www.graphisoft.com/archicad/qe/database">

<xsl:output method="html" version="4.0" encoding="UTF-8"/>

<xsl:template match="/">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<title>Результирующий набор записей запроса SQL, выполненного по отношению к ACDB</title>
			<link rel="stylesheet" href="ie4.css"/>
		</head>
		<body>
			<h2>Запрос:</h2>
			<br/>
			<code><xsl:value-of select="database:QueryResult/database:Query"/></code>
			<h2>Результат:</h2>
			<br/>
			<xsl:apply-templates select="database:QueryResult/database:Result/database:RecordSet"/>
		</body>
	</html>
</xsl:template>

<xsl:template match="database:RecordSet">
	<table>
		<thead>
			<tr>
				<xsl:apply-templates select="database:RecordMetaData"/>
			</tr>
		</thead>
		<tbody>
			<xsl:apply-templates select="database:Records"/>
		</tbody>
	</table>
</xsl:template>

<xsl:template match="database:RecordMetaData">
	<xsl:for-each select="database:Column">
		<th><xsl:value-of select="database:Label"/></th>
	</xsl:for-each>
</xsl:template>

<xsl:template match="database:Records">
	<xsl:for-each select="database:Record">
		<tr>
			<xsl:apply-templates select="."/>
		</tr>
	</xsl:for-each>
</xsl:template>

<xsl:template match="database:Record">
	<xsl:for-each select="database:Field">
		<xsl:choose>
			<xsl:when test="@null">
				<!-- NULL field -->
				<td></td>
			</xsl:when>
			<xsl:when test="./database:RecordSet">
				<td style="margin:0px;padding:0px;"><xsl:apply-templates select="./database:RecordSet"/></td>
			</xsl:when>
			<xsl:when test="./database:ImageValue">
				<td><img><xsl:attribute name="src"><xsl:value-of select="./database:ImageValue/@image"/></xsl:attribute></img></td>
			</xsl:when>
			<xsl:otherwise>
				<td><xsl:value-of select="."/></td>
			</xsl:otherwise>
		</xsl:choose>
	</xsl:for-each>
</xsl:template>

</xsl:stylesheet>
