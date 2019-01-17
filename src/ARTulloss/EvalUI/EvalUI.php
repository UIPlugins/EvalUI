<?php
declare(strict_types=1);

namespace ARTulloss\EvalUI;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

use jojoe77777\FormAPI\CustomForm;

/**
 * Class EvalUI
 * @package ARTulloss\EvalUI
 */
class EvalUI extends PluginBase implements Listener
{
    public const PERMISSION = 'eval';

    public function onEnable(): void
    {
        $this->saveDefaultConfig();
        $class = new class('eval', $this) extends PluginCommand
        {
            public function __construct(string $name, Plugin $owner)
            {
                parent::__construct($name, $owner);
                $this->setDescription('Eval as a UI!');
            }

            public function execute(CommandSender $sender, string $commandLabel, array $args)
            {
                if ($sender->hasPermission(EvalUI::PERMISSION)) {
                    if ($sender instanceof Player) {
                        /**
                         * @param Player $sender
                         * @param        $data
                         */
                        $closure = function (Player $sender, $data): void {
                            if (isset($data))
                                $this->getPlugin()->evaluate($sender, $data[0]);
                        };
                        $form = new CustomForm($closure);
                        $form->addInput('What do you want to eval?', '$s = You, $srv = Server, Enjoy!');
                        $sender->sendForm($form);
                    } else {
                        $this->getPlugin()->evaluate($sender, implode(" ", $args));
                    }

                } else
                    $sender->sendMessage('%commands.generic.permission');
            }
        };
        $this->getServer()->getCommandMap()->register('EvalUI', $class);
    }

    /**
     * @param CommandSender $s
     * @param string        $eval
     */
    public function evaluate(CommandSender $s, string $eval): void
    {
        try { // Don't crash the server!
            $svr = $this->getServer(); // Forms have limited characters, so short variables are useful
            eval($eval);
        } catch (\ParseError $exception) {
            $this->oops($s, $exception);
        } catch (\UndefinedConstantException $exception) {
            $this->oops($s, $exception);
        } catch (\UndefinedVariableException $exception) {
            $this->oops($s, $exception);
        }
    }

    /**
     * @param CommandSender $sender
     * @param \Throwable    $exception
     */
    public function oops(CommandSender $sender, \Throwable $exception): void
    {
        $sender->sendMessage(TextFormat::RED . 'You made an oopsie but we caught it! . Error: ' . $exception->getMessage());
    }
}
