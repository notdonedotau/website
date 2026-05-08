<?php

namespace Database\Seeders;

use App\Models\DocArticle;
use App\Models\DocCategory;
use Illuminate\Database\Seeder;

class DocsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = collect([
            ['name' => 'Getting Started', 'slug' => 'getting-started', 'description' => 'Start here when setting up Not Done.', 'sort_order' => 10],
            ['name' => 'Status Pages', 'slug' => 'status-pages', 'description' => 'Configure public status pages and components.', 'sort_order' => 20],
            ['name' => 'Incidents', 'slug' => 'incidents', 'description' => 'Communicate outages and maintenance clearly.', 'sort_order' => 30],
            ['name' => 'Subscribers', 'slug' => 'subscribers', 'description' => 'Keep subscribers informed through updates.', 'sort_order' => 40],
            ['name' => 'Billing', 'slug' => 'billing', 'description' => 'Manage plans, trials, and billing details.', 'sort_order' => 50],
            ['name' => 'API', 'slug' => 'api', 'description' => 'Use the Not Done API where available.', 'sort_order' => 60],
        ])->mapWithKeys(function (array $category): array {
            return [
                $category['slug'] => DocCategory::query()->updateOrCreate([
                    'slug' => $category['slug'],
                ], [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'sort_order' => $category['sort_order'],
                    'is_visible' => true,
                ]),
            ];
        });

        foreach ($this->articles() as $article) {
            DocArticle::query()->updateOrCreate([
                'slug' => $article['slug'],
            ], [
                'doc_category_id' => $categories[$article['category']]->id,
                'title' => $article['title'],
                'excerpt' => $article['excerpt'],
                'content' => $article['content'],
                'sort_order' => $article['sort_order'],
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => $article['title'],
                'meta_description' => $article['excerpt'],
                'last_reviewed_at' => now(),
            ]);
        }
    }

    /**
     * @return array<int, array{title: string, slug: string, category: string, excerpt: string, content: string, sort_order: int}>
     */
    private function articles(): array
    {
        $rollingOut = 'This feature may still be rolling out. If it is important to your setup, contact Not Done before relying on it.';

        return [
            [
                'title' => 'Getting Started',
                'slug' => 'getting-started',
                'category' => 'getting-started',
                'excerpt' => 'Set up your first Not Done status page and understand the basic workflow.',
                'sort_order' => 10,
                'content' => <<<MD
## Create your account

Start by creating your Not Done account and choosing a status page name. Public status page URLs use:

`your-status-page.status.notdone.cloud`

Choose a short, recognizable name your customers or team can identify quickly.

## Configure the basics

Add your service name, public status page details, and the components you want to communicate about. Keep the initial setup simple and add more detail over time.

## Review before sharing

Before sharing your page publicly, check that the page name, component labels, and contact information are clear.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Status Pages',
                'slug' => 'status-pages',
                'category' => 'status-pages',
                'excerpt' => 'Learn how status pages are structured in Not Done.',
                'sort_order' => 10,
                'content' => <<<MD
## What a status page does

A status page gives your customers and team one place to check service health, active incidents, and recent updates.

Not Done status pages are designed around simple public URLs like:

`your-status-page.status.notdone.cloud`

## Keep status clear

Use direct component names and update language that customers can understand. Avoid internal labels unless your audience already knows them.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Components',
                'slug' => 'components',
                'category' => 'status-pages',
                'excerpt' => 'Use components to show which parts of your service are operational or affected.',
                'sort_order' => 20,
                'content' => <<<MD
## What components represent

Components are the parts of your service that customers care about. Examples include an API, dashboard, email delivery, billing, or support portal.

## Start with customer-facing labels

Use labels that make sense outside your company. A clear component list makes incident updates easier to understand.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Incidents',
                'slug' => 'incidents',
                'category' => 'incidents',
                'excerpt' => 'Create incident updates that explain what happened and what users should expect.',
                'sort_order' => 10,
                'content' => <<<MD
## When to create an incident

Create an incident when users need a clear public update about degraded performance, downtime, maintenance, or an investigation.

## Write useful updates

Good updates explain the current state, expected impact, and next step. Keep updates brief and publish new information as it becomes available.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Custom Domains',
                'slug' => 'custom-domains',
                'category' => 'status-pages',
                'excerpt' => 'Use a branded custom domain for your Not Done status page.',
                'sort_order' => 30,
                'content' => <<<MD
## Custom domain example

Growth plan customers can use custom domains such as:

`status.example.com`

Custom domains may be available once the trial converts to a paid plan or when the free trial ends.

If custom domains are important or urgent for your team, contact Not Done so we can help you plan the setup.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Subscribers',
                'slug' => 'subscribers',
                'category' => 'subscribers',
                'excerpt' => 'Understand how subscribers can follow updates from your status page.',
                'sort_order' => 10,
                'content' => <<<MD
## Subscriber updates

Subscribers are people who want to receive updates when your status page changes or an incident is updated.

Use subscriber messaging carefully. Keep updates relevant and avoid sending unnecessary noise.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Notifications',
                'slug' => 'notifications',
                'category' => 'subscribers',
                'excerpt' => 'Plan how notifications should be used during incidents and maintenance.',
                'sort_order' => 20,
                'content' => <<<MD
## Notification planning

Notifications help keep people informed without requiring them to constantly refresh your status page.

Before relying on notifications for critical workflows, test the path end to end and confirm it matches your team expectations.

{$rollingOut}
MD,
            ],
            [
                'title' => 'Billing',
                'slug' => 'billing',
                'category' => 'billing',
                'excerpt' => 'Understand plans, trials, and billing-related setup.',
                'sort_order' => 10,
                'content' => <<<MD
## Plans and trials

Not Done plans are designed around the level of status page functionality your team needs.

If a specific plan feature matters to your team, confirm it before relying on it in production.

{$rollingOut}
MD,
            ],
            [
                'title' => 'API',
                'slug' => 'api',
                'category' => 'api',
                'excerpt' => 'Use API documentation as the integration surface becomes available.',
                'sort_order' => 10,
                'content' => <<<MD
## API usage

The Not Done API is intended for teams that want to integrate status page workflows with their existing tools.

Plan API usage around stable operational needs, such as incident creation, component updates, or internal automation.

{$rollingOut}
MD,
            ],
        ];
    }
}
