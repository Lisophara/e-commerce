<?php

namespace App\Providers;

use Carbon\Laravel\ServiceProvider;
use Filament\Forms\Components\Builder;

class QueryBuilderProvider extends ServiceProvider
{
    public function boot() : void
    {
        Builder::macro('whereActiveRange', function ($colum_start_date = null, $colum_end_date = null, $start_date = null, $end_date = null) {
            $colum_start_date = $colum_start_date ?? 'start_date';
            $colum_end_date = $colum_end_date ?? 'end_date';
            $start_date = $start_date ?? now();
            $end_date = $end_date ?? now();
            return $this->where(function (Builder $builder) use ($colum_start_date, $colum_end_date, $start_date, $end_date) {
                $builder->where($colum_start_date, '>=', $start_date)
                    ->where($colum_end_date, '<=', $end_date);
            });
        });

        Builder::macro('whereActive', function ($active = true) {
            return $this->where('active', $active);
        });
    }
}
