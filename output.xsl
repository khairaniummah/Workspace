<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="rows">
  <html>
  <body>
  <h2>Chat Log</h2>
    <table border="1">
      <tr bgcolor="#9acd32">
        <th>Date</th>
        <th>From</th>
		<th>To</th>
		<th>Message</th>
      </tr>
      <xsl:for-each select="row">
      <tr>
        <td><xsl:value-of select="date"/></td>
        <td><xsl:value-of select="fr"/></td>
		<td><xsl:value-of select="to"/></td>
		<td><xsl:value-of select="message"/></td>
      </tr>
      </xsl:for-each>
    </table>
  </body>
  </html>
</xsl:template>
</xsl:stylesheet>
