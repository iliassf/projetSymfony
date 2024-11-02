<?php

namespace App\Enum;

enum Step : String
{
    case Preparation = "en préparation";
    case Expediee = "expédiée";
    case Livree = "livrée";
    case Annulee = "annulée";
}

?>