<?php


function apiResponse(
    $data = null,
    $message = null,
    $code = null,
    $codeName = null
) {}


function success($data = null, $message = null, $status = "success")
{
    return compact('data', 'message');
}

function error(int $code, string $codeName, $message = null, $status = "error")
{
    return compact('data', 'message');
}
