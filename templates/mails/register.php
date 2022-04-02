<?php
$trackPart = '';
if($trackTask){
    $trackPart = "Link do śledzenia Twojego zgłoszenia:<br/> <a href='$trackTask'>Śledź zgłoszenie</a>";
};
return  "
<img class='mb-4' src='cid:logo' alt='logo' width='300' height='151' style='display: block; margin-left: auto; margin-right: auto'>
<br/>
<b>Zarejestrowano nowe zgłoszenie reklamacyjne o numerze: ". $taskData['entryNumber']." </b>
<br/><br/>
Dane dotyczące zgłoszenia: <br/><br/>
Zleceniodawca: <b>". $taskData['customer']."</b><br/>
Przedmiot zlecenia: <b>". $taskData['object']."</b><br/>
Opis: <b>". $taskData['description']."</b><br/>
Data utworzenia zgłoszenia: <b>". $taskData['created']."</b><br/>
<br/><br/>
Zgłoszenie zostało przyjęte. Nasz zespół dokona wszelkich starań, aby zrealizować je w jak najszybszym czasie.
<br/><br/>
$trackPart
";
?>