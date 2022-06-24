<?php

namespace ConstructStudios\AbilityItems\Commands;

use ConstructStudios\AbilityItems\entity\NPCEntity;
use ConstructStudios\AbilityItems\Items\BoneAbility;
use ConstructStudios\AbilityItems\Items\CloseCallAbility;
use ConstructStudios\AbilityItems\Items\CobwebEggAbility;
use ConstructStudios\AbilityItems\Items\EffectDisablerAbility;
use ConstructStudios\AbilityItems\Items\FairFightAbility;
use ConstructStudios\AbilityItems\Items\FocusModeAbility;
use ConstructStudios\AbilityItems\Items\FreezerAbility;
use ConstructStudios\AbilityItems\Items\InventoryCloggerAbility;
use ConstructStudios\AbilityItems\Items\PocketBardAbility;
use ConstructStudios\AbilityItems\Items\PotionRefillAbility;
use ConstructStudios\AbilityItems\Items\PumpkinAbility;
use ConstructStudios\AbilityItems\Items\RottenEggAbility;
use ConstructStudios\AbilityItems\Items\SamuraiAbility;
use ConstructStudios\AbilityItems\Items\SoupBowlAbility;
use ConstructStudios\AbilityItems\Items\NinjaStarAbility;
use ConstructStudios\AbilityItems\Items\RageBrickAbility;
use ConstructStudios\AbilityItems\Items\ResistanceAbility;
use ConstructStudios\AbilityItems\Items\RocketAbility;
use ConstructStudios\AbilityItems\Items\StarvingFleshAbility;
use ConstructStudios\AbilityItems\Items\StrengthAbility;
use ConstructStudios\AbilityItems\Items\StormBreakerAbility;
use ConstructStudios\AbilityItems\Items\SwitcherAbility;
use ConstructStudios\AbilityItems\Items\ThorAbility;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;


class AbilitysCommand extends Command
{
    public function __construct()
    {
        parent::__construct("abilitys", "Use this command to get all the special items or to spawn the NPC");
        $this->setPermission('ability.command');
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
            $sender->sendMessage('§r§7---------------------------------------------');
            $sender->sendMessage('§r ');
            $sender->sendMessage('§r§4§lConstructStudios AbilityItems');
            $sender->sendMessage('§r§4Version:§r§f 1.0.0');
            $sender->sendMessage('§r§4Author:§r§f ConstructStudios');
            $sender->sendMessage('§r§r ');
            $sender->sendMessage('§r§f/abilitys npc - §4Use this command to spawn the NPC from AbilityItems.');
            $sender->sendMessage('§r§f/abilitys giveall - §4Use this command to get all AbilityItems.');
            $sender->sendMessage('§r§f/partneritems - §4Use this command to open a menu so you can see all available AbilityItems.');
            $sender->sendMessage('§r  ');
            $sender->sendMessage('§r§7---------------------------------------------');
            return;
        }
        if (strtolower($args[0]) === 'giveall') {
            if (!isset($args[1])) {
                $sender->getInventory()->addItem(new StrengthAbility());
                $sender->getInventory()->addItem(new ResistanceAbility());
                $sender->getInventory()->addItem(new RocketAbility());
                $sender->getInventory()->addItem(new CloseCallAbility());
                $sender->getInventory()->addItem(new EffectDisablerAbility());
                $sender->getInventory()->addItem(new InventoryCloggerAbility());
                $sender->getInventory()->addItem(new StarvingFleshAbility());#ya
                $sender->getInventory()->addItem(new SoupBowlAbility());
                $sender->getInventory()->addItem(new NinjaStarAbility());
                $sender->getInventory()->addItem(new RageBrickAbility());
                $sender->getInventory()->addItem(new SwitcherAbility());
                $sender->getInventory()->addItem(new BoneAbility());
                $sender->getInventory()->addItem(new FreezerAbility());
                $sender->getInventory()->addItem(new RottenEggAbility());
                $sender->getInventory()->addItem(new PotionRefillAbility());
                $sender->getInventory()->addItem(new StormBreakerAbility());
                $sender->getInventory()->addItem(new ThorAbility());
                $sender->getInventory()->addItem(new CobwebEggAbility());
                $sender->getInventory()->addItem(new PumpkinAbility());
                $sender->getInventory()->addItem(new FairFightAbility());
                $sender->getInventory()->addItem(new FocusModeAbility());
                $sender->getInventory()->addItem(new PocketBardAbility());
                $sender->getInventory()->addItem(new SamuraiAbility());
                $sender->sendMessage(TextFormat::colorize('§r§aAbility items give successfully!'));
                return;
            }
        }
        if (strtolower($args[0]) === 'npc') {
            if (!isset($args[1])) {
                $entity = NPCEntity::create($sender);
                $entity->spawnToAll();
                $sender->sendMessage(TextFormat::colorize('§r§aNPC created successfully!'));
            }
        }
    }
}
