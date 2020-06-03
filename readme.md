Dspace SCIDAR KG

Promenjeni fajlovi

<a href="https://github.com/kovmisa/dspace-kg/blob/master/MetadataImport.java">/build/dspace-6.3-src-release/dspace-api/src/main/java/org/dspace/app/bulkedit/MetadataImport.java#1177</a>
<p>
zamenjeno 
</p>
  
<code>String mdf = StringUtils.substringAfter(md, ":");</code>
<p>
sa
</p>
<code>String mdf = md.contains(":") ? StringUtils.substringAfter(md, ":") : md;</code>




