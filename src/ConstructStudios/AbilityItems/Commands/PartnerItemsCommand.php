<?php

namespace ConstructStudios\AbilityItems\Commands;

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
use ConstructStudios\AbilityItems\Items\PrePearAbility;
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
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;


class PartnerItemsCommand extends Command
{
    public function __construct()
    {
        parent::__construct("partneritems", "Use this for look all Ability Items");

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof Player) {
            return;
        }

        if (!isset($args[0])) {
            $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
            $menu->setName("§r§eAbility Items");
            $menu->getInventory()->setContents([
                0 => new RottenEggAbility(),
                1 => new StrengthAbility(),
                2 => new ResistanceAbility(),
                3 => new RocketAbility(),
                4 => new CloseCallAbility(),
                5 => new EffectDisablerAbility(),
                6 => new InventoryCloggerAbility(),
                7 => new StarvingFleshAbility(),
                8 => new SoupBowlAbility(),
                9 => new NinjaStarAbility(),
                10 => new RageBrickAbility(),
                11 => new SwitcherAbility(),
                12 => new BoneAbility(),
                13 => new FreezerAbility(),
                14 => new PotionRefillAbility(),
                15 => new StormBreakerAbility(),
                16 => new PrePearAbility(),
                17 => new ThorAbility(),
                18 => new CobwebEggAbility(),
                19 => new PumpkinAbility(),
                20 => new FairFightAbility(),
                21 => new FocusModeAbility(),
                22 => new PocketBardAbility(),
                23 => new SamuraiAbility(),

            ]);

            $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
                $player = $transaction->getPlayer();
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rotten Egg") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new RottenEggAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Strength II") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new StrengthAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Resistance III") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new ResistanceAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rocket") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new RocketAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Close Call") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new CloseCallAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Effect Disabler") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new EffectDisablerAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Inventory Clogger") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new InventoryCloggerAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Starving Flesh") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new StarvingFleshAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Soup Bowl") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new SoupBowlAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Ninja Star") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new NinjaStarAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rage Brick") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new RageBrickAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Switcher") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new SwitcherAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Bone") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new BoneAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Freezer") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new FreezerAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Potion Refill") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new PotionRefillAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Storm Breaker") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new StormBreakerAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "PrePearl") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new PrePearAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Thor") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new ThorAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Cobweb Egg") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new CobwebEggAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Pumpkin") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new PumpkinAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Fair Fight") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new FairFightAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Focus Mode") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new FocusModeAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Pocket Bard") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new PocketBardAbility());
                }
                if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Samurai") {
                    if (!$player->hasPermission("ability.command")) {
                        return $transaction->discard();
                    }
                    $player->getInventory()->addItem(new SamuraiAbility());
                }
                return $transaction->discard();

            });
            $menu->send($sender);
        }
    }
}
