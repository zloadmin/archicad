<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
												xmlns:fo="http://www.w3.org/1999/XSL/Format"
												xmlns:database="http://www.graphisoft.com/archicad/qe/database">

<xsl:output method="html" version="4.0" encoding="UTF-8"/>

<xsl:template match="/">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
			<link rel="stylesheet" href="ie4.css"/>
			<title>Схема базы данных<xsl:value-of select="database:DatabaseMetaData/database:Name"/></title>
		</head>
		<body>
			<h2>База данных:<xsl:value-of select="database:DatabaseMetaData/database:Name"/></h2>
			<br/><br/>
			<xsl:apply-templates select="database:DatabaseMetaData"/>
		</body>
	</html>
</xsl:template>

<xsl:template match="database:DatabaseMetaData">
	<h3>Таблицы <xsl:value-of select="database:Name"/></h3>
	<ul>
		<xsl:for-each select="database:Tables/database:Table">
			<li><a><xsl:attribute name="href">#<xsl:value-of select="@name"/></xsl:attribute><xsl:value-of select="@name"/></a></li>
		</xsl:for-each>
	</ul>
	<br/><br/>
	<h3>Виды <xsl:value-of select="database:Name"/></h3>
	<ul>
		<xsl:for-each select="database:Views/database:View">
			<li/><a><xsl:attribute name="href">#<xsl:value-of select="@name"/></xsl:attribute><xsl:value-of select="@name"/></a>
		</xsl:for-each>
	</ul>
	<br/><br/>
	<xsl:apply-templates select="database:Tables"/>
	<xsl:apply-templates select="database:Views"/>
</xsl:template>

<xsl:template match="database:Tables">
	<xsl:for-each select="database:Table">
		<xsl:apply-templates select="."/>
	</xsl:for-each>
</xsl:template>

<xsl:template match="database:Table">
	<h3><a><xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute><xsl:value-of select="@name"/></a></h3>
	<br/>
	<table>
		<thead>
			<tr>
				<th colspan="6"><xsl:value-of select="@name"/></th>
			</tr>
			<tr>
				<th width="30%" nowrap="true">Имя Столбца</th>
				<th width="30%" nowrap="true">Метка Столбца</th>
				<th width="10%" nowrap="true">Тип Столбца</th>
				<th width="10%" nowrap="true">Первичный ключ</th>
				<th width="10%" nowrap="true">Отсутствие зна</th>
				<th width="10%" nowrap="true">Только для чтения</th>
			</tr>
		</thead>
		<tbody>
			<xsl:apply-templates select="database:RecordMetaData"/>
		</tbody>
	</table>
    <xsl:call-template name="list-embedded-recordsets"/>
</xsl:template>

<xsl:template match="database:Views">
	<xsl:for-each select="database:View">
		<xsl:apply-templates select="."/>
	</xsl:for-each>
</xsl:template>

<xsl:template match="database:View">
	<h3><a><xsl:attribute name="name"><xsl:value-of select="@name"/></xsl:attribute><xsl:value-of select="@name"/></a></h3>
	<br/>
	<table>
		<thead>
			<tr>
				<th colspan="6"><xsl:value-of select="@name"/></th>
			</tr>
			<tr>
				<th width="30%" nowrap="true">Column Name</th>
				<th width="30%" nowrap="true">Column Label</th>
				<th width="10%" nowrap="true">Column Type</th>
				<th width="10%" nowrap="true">Primary Key</th>
				<th width="10%" nowrap="true">Nullable</th>
				<th width="10%" nowrap="true">Read-only</th>
			</tr>
		</thead>
		<tbody>
			<xsl:apply-templates select="database:RecordMetaData"/>
		</tbody>
	</table>
    <xsl:call-template name="list-embedded-recordsets"/>
</xsl:template>

<xsl:template match="database:RecordMetaData">
	<xsl:for-each select="database:Column">
			<xsl:apply-templates select="."/>
	</xsl:for-each>
</xsl:template>

<xsl:template match="database:Column">
    <xsl:choose>
        <xsl:when test="database:Type/@type-id='SQL_RECORDSET'">
            <tr>
                <td width="30%" nowrap="true"><a><xsl:attribute name="href">#<xsl:value-of select="../../@name"/>.<xsl:value-of select="database:Name"/></xsl:attribute><xsl:value-of select="database:Name"/></a></td>
                <td width="30%" nowrap="true"><xsl:value-of select="database:Label"/></td>
                <td width="10%" nowrap="true"><xsl:value-of select="database:Type/database:Description"/></td>
                <td width="10%" nowrap="true"><xsl:value-of select="@primary-key"/></td>
                <td width="10%" nowrap="true"><xsl:value-of select="@nullable"/></td>
                <td width="10%" nowrap="true"><xsl:value-of select="@read-only"/></td>
            </tr>
        </xsl:when>
        <xsl:otherwise>
            <tr>
	<td width="30%" nowrap="true"><xsl:value-of select="database:Name"/></td>
	<td width="30%" nowrap="true"><xsl:value-of select="database:Label"/></td>
	<td width="10%" nowrap="true"><xsl:value-of select="database:Type/database:Description"/></td>
	<td width="10%" nowrap="true"><xsl:value-of select="@primary-key"/></td>
	<td width="10%" nowrap="true"><xsl:value-of select="@nullable"/></td>
	<td width="10%" nowrap="true"><xsl:value-of select="@read-only"/></td>
            </tr>
        </xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template name="list-embedded-recordsets">
    <xsl:variable name="table" select="@name"/>
    <xsl:for-each select="database:RecordMetaData/database:Column[database:Type/@type-id='SQL_RECORDSET']">
        <h4><a><xsl:attribute name="name"><xsl:value-of select="$table"/>.<xsl:value-of select="database:Name"/></xsl:attribute></a><xsl:value-of select="$table"/>.<xsl:value-of select="database:Name"/></h4>
        <br/>
        <table>
            <thead>
                <tr>
                    <th colspan="6"><xsl:value-of select="$table"/>.<xsl:value-of select="database:Name"/></th>
                </tr>
                <tr>
                    <th width="30%" nowrap="true">Column Name</th>
                    <th width="30%" nowrap="true">Column Label</th>
                    <th width="10%" nowrap="true">Column Type</th>
                    <th width="10%" nowrap="true">Primary Key</th>
                    <th width="10%" nowrap="true">Nullable</th>
                    <th width="10%" nowrap="true">Read-only</th>
                </tr>
            </thead>
            <tbody>
                <xsl:apply-templates select="database:RecordMetaData"/>
            </tbody>
        </table>
    </xsl:for-each>
</xsl:template>

</xsl:stylesheet>
