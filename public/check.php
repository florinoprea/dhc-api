<?php

if (in_array('exec', preg_split('/\s*,\s*/', ini_get('disable_functions')))) {
  echo "exec is disabled";
}else{
    exec("/home/ec2-user/.nvm/versions/node/v16.20.2/bin/node -v 2>&1", $ret);
    var_dump($ret);
}

