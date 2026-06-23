<?php

namespace App\Contracts;

interface NotificationServiceInterface
{
    /**
     * Send a notification to a recipient.
     *
     * @param string $channel   The notification channel (e.g., 'whatsapp', 'email')
     * @param string $recipient The recipient identifier (phone number, email, etc.)
     * @param string $message   The notification message
     * @param array  $data      Additional context data
     */
    public function send(string $channel, string $recipient, string $message, array $data = []): void;
}
