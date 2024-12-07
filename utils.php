<?php

// Une fonction qui permet de renvoyer des réponses JSON
function jsonResponse($data, $status = 200)
{
    header('Content-Type: application/json; charset=UTF-8');
    http_response_code($status);
    echo json_encode($data);
    exit(); // Arrêter l'exécution du script après avoir envoyé la réponse
}

function formatDateForSql(string $dateString): string
{
    return (new DateTimeImmutable($dateString))->format("Y-m-d");
}
