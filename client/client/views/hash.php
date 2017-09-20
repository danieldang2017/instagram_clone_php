<?php
  //  echo password_hash("rasmuslerdorf", PASSWORD_DEFAULT)."\n";

function hashString($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function hashCheckPassword($password, $secrect)
{
  return password_verify($password, $secrect);
}
?>