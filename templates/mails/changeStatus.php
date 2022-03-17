<?php
return "
<img class='mb-4' src='cid:logo' alt='logo' width='300' height='151' style='display: block; margin-left: auto; margin-right: auto'>
<br/>
<b>Zmiana statusu zgłoszenia o numerze: ". $taskData['number']." </b>
<br/><br/>
". $taskData['details']['actionMessage']." z: <b>". $taskData['details']['previousValue']." </b> na:  <b>". $taskData['details']['updatedValue']." </b><br/>
<br/><br/>

";
?>


