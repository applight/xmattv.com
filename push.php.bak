<?php

// cd to the fully qualified path (htdocs is a symlink,
// just in case we change the server later)
// then do a git pull
$result = shell_exec( "cd /home/bitnami/htdocs && git pull" );

echo "Pulled repo with shell result:<br/>"
     .  str_replace( "n", "<br/>", $result );
?>