<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleType extends Enum
{
    const ADMIN = 'ADMIN';
    const PHARMA = 'PHARMA';
    const FINANCE = 'FINANCE';
    const FINANCE_RECIPES = 'FINANCE_RECIPES';
    const FINANCE_EXPENSES = 'FINANCE_EXPENSES';
    const RECEPTION = 'RECEPTION';
    const NURSE = 'NURSE';
    const DOCTOR = 'DOCTOR';
    const MONEY_BOX = 'MONEY_BOX';
    const DEPOSIT_PHARMA = 'DEPOSIT_PHARMA';
    const AG = 'AG';
    const RADIO = 'RADIO';
    const LABO = 'LABO';
    const EMERGENCY = 'EMERGENCY';
    const IT = 'IT';
    const CHIEF_NURSE = 'CHIEF_NURSE';
}
