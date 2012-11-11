<?php
/*
simple update script for the production server to pull update code from the central git repo.

Requires several permissions to be adjusted so that the apache has write permission in the  target directory.
Followed instructions here:
http://stackoverflow.com/questions/5144039/shell-exec-and-git-pull

Specifically:
addgroup gitwriters

adduser ubuntu gitwriters
adduser www-data gitwriters

# Recursively, set the group ownership of every file and directory of your repository:
chgrp -R gitwriters /path/to/your/repo

# Recursively, make every file and directory of your repository readable and writable
# by the group:
chmod -R g+rw /path/to/your/repo

# Recursively, set the setgid of every directory in the repository.  The setgid bit
# on directories means that files created in the directory will have the same group
# ownership as the directory.  
find /path/to/your/repo -type d -print0 | xargs -0 chmod g+s

*/

$output = shell_exec('git pull');
echo "<pre>$output</pre>";
?>

