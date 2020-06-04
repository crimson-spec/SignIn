<?php

$logout = new Classes\ClassSessions;

$logout->destructSessions();

echo "
    <script>
        window.location.href='".DIRPAGE."';
    </script>
";