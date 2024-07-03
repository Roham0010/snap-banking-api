<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Card;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardTransferTest extends TestCase
{
    use DatabaseTransactions;
    private User $user;
    private Account $account;
    private Card $sourceCard;
    private Card $destinationCard;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup initial data for testing
        $this->user = User::factory()->create();

        $this->account = Account::factory()->create([
            'user_id' => $this->user->id,
            'balance' => 100000, // Initial balance for testing
        ]);

        $this->sourceCard = Card::factory()->create([
            'account_id' => $this->account->id,
            'card_number' => '5490108501168162',
        ]);

        $this->destinationCard = Card::factory()->create([
            'account_id' => $this->account->id,
            'card_number' => '4556148943630670',
        ]);
    }

    /** @test */
    public function it_fails_if_source_and_destination_cards_are_the_same()
    {
        $response = $this->postJson('/api/cards/transfer', [
            'source_card_number' => $this->sourceCard->card_number,
            'destination_card_number' => $this->sourceCard->card_number,
            'amount' => 1000,
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'Source card should not be the same as the destication card.',
            'error_key' => 'same_card',
        ]);
    }
}
