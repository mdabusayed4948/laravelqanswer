<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewAnswerSubmitted extends Notification
{
    use Queueable;

    public $answer;
    public $question;
    public $name;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($answer, $question, $name)
    {
        $this->answer   = $answer;
        $this->question = $question;
        $this->name     = $name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'nexmo', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('A new answer was submitted to yuor question!')
                    ->line("$this->name just suggested: ". $this->answer->ans)
                    ->action('View All Answers', route('questions.show', $this->question->id))
                    ->line('Thank you for using LaravelqAnswers!');
    }

    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
            ->content("$this->name just submitted an answer to your question! Check it out now at LaravelAnswers.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
