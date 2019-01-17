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
 * @package ARTulloss\PvPUI
 */
class EvalUI extends PluginBase implements Listener
{
    public function onEnable(): void
    {
    	$class = new class('eval', $this) extends PluginCommand
	    {
	    	public function __construct(string $name, Plugin $owner)
		    {
			    parent::__construct($name, $owner);
			    $this->setDescription('Eval as a UI!');
		    }

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
							    $this->getPlugin()->evaluate($data[0]);
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
					    $this->getPlugin()->evaluate(implode(" ", $args));
				    } catch (\ParseError $exception) {
					    $sender->sendMessage(TextFormat::RED . 'You made an oopsie but we caught it! . Error: ' . $exception->getMessage());
				    }
			    }
		    }
	    };

        $this->getServer()->getCommandMap()->register('EvalUI', $class);
    }

	/**
	 * @param string $eval
	 */
    public function evaluate(string $eval): void
    {
	    eval($eval);
    }
}
