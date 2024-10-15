<?php
session_start();
session_destroy();
session_unset();
session_abort();

header("Location: ../?page=login");
exit();