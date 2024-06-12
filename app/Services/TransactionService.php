<?php

namespace App\Services;

use App\Models\{Transaction, User};
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\UnauthorizedException;

class TransactionService
{

    /**
     * @param UserService           $userService
     */
    public function __construct(private UserService $userService)
    {
    }

    /**
     * @param array $data
     * @return Transaction
     * @throws UnauthorizedException
     * @throws GuzzleException
     */
    public function createTransaction(array $data): Transaction
    {
        $sender = $data['payer'];
        $receiver = $data['payee'];
        
        $this->userService->validatePayerTransaction($sender, $data['value']);
        
        $this->authorizeTransaction();
        
        $this->saveUserBalance($sender, $receiver, $data['value']);
        
        Notification::send($sender, new \App\Notifications\TransactionNotification());
        Notification::send($receiver, new \App\Notifications\TransactionNotification());

        return $this->saveTransaction($sender, $receiver, $data['value']);
    }

    /**
     * @throws GuzzleException
     */
    private function authorizeTransaction(): void
    {

        $authorizationResponse = \Illuminate\Support\Facades\Http::get('https://util.devi.tools/api/v2/authorize');
        $authorizationData = json_decode($authorizationResponse->body(), true);

        if ($authorizationData['data']['authorization'] === false || $authorizationResponse->status() !== 200 || $authorizationResponse['status'] === 'fail') {
            throw new Exception('Transaction not authorized by external service', $authorizationResponse->status());
        }
    }

    /**
     * @param User $sender
     * @param User $receiver
     * @param float $value
     * @return Transaction
     */
    private function saveTransaction(User $sender, User $receiver, float $value): Transaction
    {
        return Transaction::create([
            'payer' => $sender->id,
            'payee' => $receiver->id,
            'value' => $value
        ]);
    }

    /**
     * @param User $sender
     * @param User $receiver
     * @param float $value
     * @return void
     */
    private function saveUserBalance(User $sender, User $receiver, float $value): void
    {
        $sender->balance -= $value;
        $receiver->balance += $value;

        $sender->save();
        $receiver->save();
    }
}
