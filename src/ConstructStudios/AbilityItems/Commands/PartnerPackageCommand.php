<?php

namespace ConstructStudios\AbilityItems\Commands;

use ConstructStudios\AbilityItems\Items\PartnerPackage;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;


class PartnerPackageCommand extends Command
{
    public function __construct()
    {
        parent::__construct("partnerpackages", "Use this command to get all the special items or to spawn the NPC");
        $this->setPermission('pp.command');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$this->testPermission($sender)) {
            return;
        }
        if (!$sender instanceof Player) {
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage('§r§c/ability [giveall/npc]');
            return;
        }
        if (strtolower($args[0]) === 'giveall') {
            if (!isset($args[1])) {
                $sender->getInventory()->addItem(new PartnerPackage());
            }
        }
    }
}
