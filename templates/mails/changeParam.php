<?php
$trackPart = '';
if($trackTask){
    $trackPart = "Link do śledzenia Twojego zgłoszenia:<br/> <a href='$trackTask'>Śledź zgłoszenie</a>";
};
return "
<html lang='pl'>
<img class='mb-4' src='cid:logo' alt='logo' width='300' height='151' style='display: block; margin-left: auto; margin-right: auto'>
<br/>
<b>". $taskData['details']['actionMessage']." o numerze: ". $taskData['number']." </b>
<br/><br/>
". $taskData['details']['actionMessage']." z: <b>". $taskData['details']['previousValue']." </b> na:  <b>". $taskData['details']['updatedValue']." </b><br/>"
.($taskData['details']['comment'] ? 'Dodatkowe informacje: ' . $taskData['details']['comment'] : '').
"
<br/><br/>
$trackPart
</html>
";
