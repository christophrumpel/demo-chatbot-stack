<?php

namespace App\Http\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;

class MeetingsConversation extends Conversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askAboutRegion();
    }

    private function askAboutRegion()
    {
        $question = Question::create('Which region are you interested in?')->addButtons([
            Button::create('US')->value('us'),
            Button::create('EU')->value('eu'),
        ]);

        $this->ask($question, function (Answer $answer) {
            switch ($answer->getValue()) {
                case 'us':
                    return $this->showUsMeetings();
                case 'eu':
                    return $this->showEuMeetings();
                default:
                    $this->say('Sry, I am not sure what you meant');

                    return $this->repeat();
            }
        });
    }

    private function showUsMeetings()
    {
        $this->say('Adam Culp, August 23, 2018');
    }

    private function showEuMeetings()
    {
        if ($this->bot->getDriver()->getName() == 'Facebook') {

            $template = GenericTemplate::create('These are the upcoming EU Meetings')->addElements([
                Element::create('Christopher Pitt')
                    ->image('https://laracon.eu/2018/assets/img/speaker_christopher_v2.jpg')
                    ->subtitle('August 23, 2018')
                    ->addButton(ElementButton::create('Read More')
                        ->type('postback')
                        ->payload('cp')),
                Element::create('Andrew Caya')
                    ->image('https://media.licdn.com/dms/image/C5103AQGNkLzz0GaQkQ/profile-displayphoto-shrink_200_200/0?e=1537401600&v=beta&t=17fCLGvz2MvMkG094XV1xvyxSvUir4IwO0NCtStlxHk')
                    ->subtitle('September 20, 2018')
                    ->addButton(ElementButton::create('Read More')
                        ->type('postback')
                        ->payload('cp')),

            ]);

            return $this->say($template);
        }

        $this->say('Christopher Pitt, August 23, 2018');
    }

}
