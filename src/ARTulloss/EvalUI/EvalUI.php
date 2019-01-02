<?php
declare(strict_types=1);

namespace ARTulloss\EvalUI;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI\CustomForm;

/**
 * Class EvalUI
 * @package ARTulloss\PvPUI
 */
class EvalUI extends PluginBase implements Listener
{
    public function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register('EvalUI', new EvalCommand('eval', 'Eval as a UI!'));
    }
}

/**
 * Class EvalCommand
 * @package ARTulloss\EvalUI
 */
class EvalCommand extends Command
{
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $server = $sender->getServer();

        if($sender instanceof Player) {

            /**
             * @param Player $sender
             * @param $data
             */
            $closure = function (Player $sender, $data) use ($server): void
            {
                if(isset($data)) {
                    try {
                        eval($data[0]);
                    } catch (\ParseError $exception) {
                        $sender->sendMessage(TextFormat::RED . 'You made an oopsie but we caught it! . Error: ' . $exception->getMessage());
                    }
                }
            };

            $form = new CustomForm($closure);

            $form->addInput('What do you want to eval?', '$sender = You, $server = Server, Enjoy!');

            $sender->sendForm($form);


        } else {
            try {
                eval(implode(" ", $args));
            } catch (\ParseError $exception) {
                $sender->sendMessage(TextFormat::RED . 'You made an oopsie but we caught it! . Error: ' . $exception->getMessage());
            }
        }
    }
}