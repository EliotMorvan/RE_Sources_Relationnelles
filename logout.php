<?php

require 'boot.php';

use Security\Security;
use Http\Response;

unset($_SESSION[Security::KEY]);

Response::redirect('index.php');
