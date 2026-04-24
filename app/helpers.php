<?php

function estado($valor, $grupo = 'general')
{
    $estados = config("estados.$grupo");

    return $estados[$valor] ?? [
        'class' => 'is-unknown',
        'icon' => 'question',
        'text' => 'Desconocido',
    ];
}