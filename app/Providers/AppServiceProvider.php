<?php

namespace App\Providers;

use App\Services\Helpers\Export\Excel\ExcelExportAbstractService;
use App\Services\Helpers\Export\Excel\ExcelExportService;
use App\Services\Helpers\Export\Pdf\PdfExportAbstractService;
use App\Services\Helpers\Export\Pdf\PdfExportService;
use App\View\Components\FilterPartener;
use App\View\Components\operation;
use App\View\Components\OperationSelectComponent;
use App\View\Components\SousServicesSelect;
use App\View\Components\TypeOperation;
use App\View\Components\TypeOperationPhones;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PdfExportAbstractService::class,PdfExportService::class);
        $this->app->singleton(ExcelExportAbstractService::class,ExcelExportService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::component('partner', FilterPartener::class);
        Blade::component('operation', OperationSelectComponent::class);
        Blade::component('operation-phone', TypeOperationPhones::class);
        Blade::component('type-operation', TypeOperation::class);
        Blade::component('sous-service', SousServicesSelect::class);
    }
}
