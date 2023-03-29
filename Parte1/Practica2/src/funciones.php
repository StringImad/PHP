<?php
function LetraNIF($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}

function dni_bien_escrito($texto)
{
    $dni = strtoupper($texto);
    return strlen($dni) == 9 && is_numeric(substr($dni, 0, 8)) && substr($dni, 8, 1) >= "A" && substr($dni, 8, 1) <= "Z";
}
function dni_valido($dni)
{
    return LetraNIF(substr($dni, 0, 8)) == strtoupper(substr($dni, -1));
}


?>