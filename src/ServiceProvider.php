<?php

namespace GeoffTech\FilamentTimezone;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {

        TextColumn::configureUsing(
            modifyUsing: fn(TextColumn $c): TextColumn => $c
                ->timezone(fn() => Auth::user()->timezone)
        );

        DatePicker::configureUsing(
            modifyUsing: fn(DatePicker $c): DatePicker => $c
                ->timezone(fn() => Auth::user()->timezone)
                ->format('jS M Y g:ia')
        );

        TextInput::configureUsing(
            modifyUsing: fn(TextInput $c) => $c->maxLength(
                fn(TextInput $component) => $component->isNumeric()
                    ? null
                    : 255
            )
        );

        Table::configureUsing(
            modifyUsing: fn(Table $table) => $table
                ->persistSearchInSession()
                ->persistFiltersInSession()
        );

        // ! temp fix: disableToolbarButtons broken
        // RichEditor::configureUsing(
        //     modifyUsing: fn($c) => $c->disableToolbarButtons(['attachFiles'])
        // );

        // ! temp fix: disableToolbarButtons broken
        // MarkdownEditor::configureUsing(
        //     modifyUsing: fn($c) => $c->disableToolbarButtons(['attachFiles'])
        // );

        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-timezone');
    }
}
