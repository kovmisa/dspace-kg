<?php 


$author_array=explode("\n",file_get_contents('./izvrsi-dspace.out'));
echo '<select class="form-control" multiple="multiple" name="eperson_id" size="10">
<option value="196af48f-0db3-4aa1-b9e1-c7efaba9fe13">Milos Ivanovic (imilos@gmail.com)</option>
<option value="6c6b4ad9-323e-4bb3-9202-f9b4acb4f352">Ivan Zivic (i.zivic@kg.ac.rs)</option>
';
foreach ($author_array as $value)
{
	echo '<option value="'.$value.'">user</option><br>';


}
echo '</select>';