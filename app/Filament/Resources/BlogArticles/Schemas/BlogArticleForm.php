<?php

namespace App\Filament\Resources\BlogArticles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BlogArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Article')
                    ->schema([
                        Select::make('blog_category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Category'),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state ?? ''))),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Textarea::make('excerpt')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        FileUpload::make('og_image')
                            ->label('OG image')
                            ->helperText('Used at the top of the article and on the blog listing page.')
                            ->disk('public')
                            ->directory('blog/og-images')
                            ->image()
                            ->imageEditor()
                            ->imagePreviewHeight('180')
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        MarkdownEditor::make('body')
                            ->label('Markdown')
                            ->helperText('Write blog posts in Markdown. Raw HTML is stripped on the public site.')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Publishing')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Published'),
                        DateTimePicker::make('published_at')
                            ->seconds(false),
                    ])
                    ->columns(2),
            ]);
    }
}
