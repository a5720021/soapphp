<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
<html> 
<body>
  <h2>Elder Data</h2>
  <table border="1">
    <tr bgcolor="gray">
      <th style="text-align:left">ID</th>
      <th style="text-align:left">Name</th>
      <th style="text-align:left">Age</th>
      <th style="text-align:left">Address</th>
    </tr>
    <xsl:for-each select="elderdata/elder">
    <tr bgcolor="yellow">
      <td><xsl:value-of select="e_id"/></td>
      <td><xsl:value-of select="e_name"/></td>
      <td><xsl:value-of select="e_age"/></td>
      <td><xsl:value-of select="e_addr"/></td>
    </tr>
    </xsl:for-each>
  </table>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
