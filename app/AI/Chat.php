<?php

namespace App\AI;

use OpenAI\Laravel\Facades\OpenAI;

class Chat
{
    /**
     * All messages
     * @var array
     */
    protected array $messages = [];

    /**
     * Add a system message
     * @param mixed $message
     * @return static
     */
    public function systemMessage($message): static
    {
        $this->addMessage('system', $message);

        return $this;
    }

    /**
     * Add message
     * @param string $role
     * @param string $content
     * @return void
     */
    public function addMessage(string $role, string $content)
    {
        $this->messages[] = [
            'role' => $role,
            'content' => $content,
        ];
    }

    /**
     * Return all messages
     * @return array
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * Send a message to the ai model
     * @param string $message
     * @return string
     */
    public function send(string $message): null|string
    {
        $this->addMessage('user', $message);

        $response = OpenAI::chat()->create([
            "model" => config('services.openai.model'),
            "messages" => $this->messages
        ])->choices[0]->message->content;

        if ($response) {
            $this->addMessage('assistant', $response);
        }

        return $response;
    }

    /**
     * Reply
     * @param string $message
     * @return string
     */
    public function reply(string $message): null|string
    {
        return $this->send($message);
    }

    /**
     * Get the last response if exists
     * @return null|string
     */
    public function response(): null|string
    {
        $messages = collect($this->messages);

        if ($messages->count()) {
            return $messages->last()['content'];
        }

        return null;
    }

    /**
     * Clear chat data
     * @return void
     */
    public function clearChat()
    {
        $this->messages = [];
    }
}
