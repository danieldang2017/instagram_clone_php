<?php
 
function hashString($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function hashCheckPassword($password, $secrect)
{
  return password_verify($password, $secrect);
}
?>