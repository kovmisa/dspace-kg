Dspace SCIDAR KG

Promenjeni fajlovi

<a href="https://github.com/kovmisa/dspace-kg/blob/master/MetadataImport.java#L1177">/build/dspace-6.3-src-release/dspace-api/src/main/java/org/dspace/app/bulkedit/MetadataImport.java#L1177</a>
<p>
zamenjeno 
</p>
  
<code>String mdf = StringUtils.substringAfter(md, ":");</code>
<p>
sa
</p>
<code>String mdf = md.contains(":") ? StringUtils.substringAfter(md, ":") : md;</code>
<hr>
<p>
Line 119-152 dodata polja za submitovanje issn, doi, scopus:
</p>
<a href="https://github.com/kovmisa/dspace-kg/blob/master/input-forms.xml">/dspace/config/input-forms.xml</a>

<hr>

