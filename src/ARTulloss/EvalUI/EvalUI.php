<?php
declare(strict_types=1);

namespace ARTulloss\EvalUI;

use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

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

class EvalCommand extends Command
{
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		$server = $sender->getServer();

		if($sender instanceof Player) {

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
			array_shift($args);
			$toBeEvaled = '';
			foreach ($args as $arg)
				$toBeEvaled .= ' ' . $arg;
			try {
				eval($toBeEvaled);
			} catch (\ParseError $exception) {
				$sender->sendMessage(TextFormat::RED . 'You made an oopsie but we caught it! . Error: ' . $exception->getMessage());
			}
		}
	}
}