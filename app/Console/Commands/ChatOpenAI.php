<?php

namespace App\Console\Commands;

use App\AI\Chat;
use Illuminate\Console\Command;

class ChatOpenAI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start a chat with open ai';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $chat = new Chat;

        $chat->systemMessage('You are a good programmer.');

        $answer = $this->ask('What would you like to say to Open AI?');

        $respone = null;

        while (true) {
            if ($respone) {
                $answer = $this->ask($respone);
            }

            if (!$answer) {
                break;
            }

            $respone = $chat->send($answer);
        }
    }
}
