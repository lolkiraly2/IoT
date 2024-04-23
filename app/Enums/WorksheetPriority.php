<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum WorksheetPriority: string implements HasLabel, HasColor, HasIcon
{
  case NORMAL = 'Normál';
  case SURGOS = 'Sürgős';
  case LEALLASKOR = 'Leálláskor';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::NORMAL => 'Normál',
      self::SURGOS => 'Sürgős',
      self::LEALLASKOR => 'Leálláskor',
    };
  }

  public function getColor(): string|array|null
  {
    return match ($this) {
      self::NORMAL => 'warning',
      self::SURGOS => 'danger',
      self::LEALLASKOR => 'gray',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::NORMAL => 'heroicon-m-exclamation-circle',
      self::SURGOS => 'heroicon-m-exclamation-triangle',
      self::LEALLASKOR => 'heroicon-m-sun',
    };
  }
}