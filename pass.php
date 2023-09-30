<?php

$pass = $argv[1];

echo password_hash($pass,PASSWORD_DEFAULT)."\n";

