<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use App\TaskStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                Select::make('status')
                    ->label('Status')
                    ->options(TaskStatus::labels())
                    ->required()
                    ->reactive()
                    ->default(TaskStatus::TODO->value),
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('status')->sortable(),
                TextColumn::make('start_date')->sortable(),
                TextColumn::make('end_date')->sortable(),
                TextColumn::make('project.name')->label('Project')->sortable(),
                TextColumn::make('user.name')->label('Assigned User')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(TaskStatus::labels()),
                SelectFilter::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable(),
                SelectFilter::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable(),
                Filter::make('start_date')
                    ->form([
                        DatePicker::make('start_from')->label('Start Date From'),
                        DatePicker::make('start_to')->label('Start Date To'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['start_from'],
                                fn ($query, $date) => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['start_to'],
                                fn ($query, $date) => $query->whereDate('start_date', '<=', $date),
                            );
                    }),
                Filter::make('end_date')
                    ->form([
                        DatePicker::make('end_from')->label('End Date From'),
                        DatePicker::make('end_to')->label('End Date To'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['end_from'],
                                fn ($query, $date) => $query->whereDate('end_date', '>=', $date),
                            )
                            ->when(
                                $data['end_to'],
                                fn ($query, $date) => $query->whereDate('end_date', '<=', $date),
                            );
                    }),
                ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
