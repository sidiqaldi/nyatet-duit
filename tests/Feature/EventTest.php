<?php

namespace Tests\Feature;

use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Events\TransactionCreated;
use App\Events\TransactionDeleted;
use App\Events\TransactionUpdated;
use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function test_event_category_deleted_can_be_dispatch(): void
    {
        Event::fake();

        $category = Category::factory()->create();

        CategoryDeleted::dispatch($category->id);

        Event::assertDispatched(CategoryDeleted::class,  function ($event) use ($category) {
            return $event->categoryId === $category->id;
        });
    }

    public function test_event_category_updated_can_be_dispatch(): void
    {
        Event::fake();

        $category = Category::factory()->create();

        CategoryUpdated::dispatch($category, $category->type);

        Event::assertDispatched(CategoryUpdated::class,  function ($event) use ($category) {
            return $event->category->id === $category->id && $event->oldType === $category->type;
        });
    }

    public function test_event_transaction_created_can_be_dispatch(): void
    {
        Event::fake();

        $transaction = Transaction::factory()->create();

        TransactionCreated::dispatch($transaction);

        Event::assertDispatched(TransactionCreated::class,  function ($event) use ($transaction) {
            return $event->transaction->id === $transaction->id;
        });
    }

    public function test_event_transaction_updated_can_be_dispatch(): void
    {
        Event::fake();

        $transaction = Transaction::factory()->create();

        TransactionUpdated::dispatch($transaction);

        Event::assertDispatched(TransactionUpdated::class,  function ($event) use ($transaction) {
            return $event->transaction->id === $transaction->id;
        });
    }

    public function test_event_transaction_deleted_can_be_dispatch(): void
    {
        Event::fake();

        $transaction = Transaction::factory()->create();

        TransactionDeleted::dispatch($transaction->date);

        Event::assertDispatched(TransactionDeleted::class,  function ($event) use ($transaction) {
            return $event->date->equalTo($transaction->date);
        });
    }
}
