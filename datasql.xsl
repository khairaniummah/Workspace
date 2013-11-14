<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="database">
  <html>
  <body>
  <h2>database</h2>
    <table border="1">
      <tr bgcolor="#9acd32">
        <th>ID Pegawai</th>
        <th>Nama</th>
      </tr>
      <xsl:for-each select="row">
      <tr>
        <td><xsl:value-of select="ID"/></td>
        <td><xsl:value-of select="NAME"/></td>
      </tr>
      </xsl:for-each>
    </table>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>
