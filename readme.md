<h4>Promenjeni fajlovi</h4>

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
<a href="https://github.com/kovmisa/dspace-kg/blob/master/input-forms.xml#L119">/dspace/config/input-forms.xml</a>

<hr>
<h4>PHP skripte</h4>
<p>
<a href="https://github.com/kovmisa/dspace-kg/tree/master/php-scopus">Scopus</a>
</p>
<p>
<a href="https://github.com/kovmisa/dspace-kg/tree/master/php-dspace-api">Dspace-rest-api</a>
</p>
<p>
<a href="https://github.com/kovmisa/dspace-kg/tree/master/php-excell-dspace">Skupljanje podataka iz excell-a</a>
</p>
<hr>
