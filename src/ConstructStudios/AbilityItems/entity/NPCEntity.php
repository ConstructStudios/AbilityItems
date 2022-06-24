<?php

declare(strict_types=1);

namespace ConstructStudios\AbilityItems\entity;

use ConstructStudios\AbilityItems\Items\BoneAbility;
use ConstructStudios\AbilityItems\Items\CloseCallAbility;
use ConstructStudios\AbilityItems\Items\CobwebEggAbility;
use ConstructStudios\AbilityItems\Items\EffectDisablerAbility;
use ConstructStudios\AbilityItems\Items\FairFightAbility;
use ConstructStudios\AbilityItems\Items\FocusModeAbility;
use ConstructStudios\AbilityItems\Items\FreezerAbility;
use ConstructStudios\AbilityItems\Items\InventoryCloggerAbility;
use ConstructStudios\AbilityItems\Items\NinjaStarAbility;
use ConstructStudios\AbilityItems\Items\PocketBardAbility;
use ConstructStudios\AbilityItems\Items\PotionRefillAbility;
use ConstructStudios\AbilityItems\Items\PrePearAbility;
use ConstructStudios\AbilityItems\Items\PumpkinAbility;
use ConstructStudios\AbilityItems\Items\RageBrickAbility;
use ConstructStudios\AbilityItems\Items\ResistanceAbility;
use ConstructStudios\AbilityItems\Items\RocketAbility;
use ConstructStudios\AbilityItems\Items\RottenEggAbility;
use ConstructStudios\AbilityItems\Items\SamuraiAbility;
use ConstructStudios\AbilityItems\Items\SoupBowlAbility;
use ConstructStudios\AbilityItems\Items\StarvingFleshAbility;
use ConstructStudios\AbilityItems\Items\StrengthAbility;
use ConstructStudios\AbilityItems\Items\StormBreakerAbility;
use ConstructStudios\AbilityItems\Items\SwitcherAbility;
use ConstructStudios\AbilityItems\Items\ThorAbility;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\entity\Human;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class NPCEntity extends Human
{

    /** @var int|null */

    /**
     * @param Player $player
     *
     * @return \ConstructStudios\AbilityItems\entity\NPCEntity
     */
    public static function create(Player $player): self
    {
        $nbt = CompoundTag::create()
            ->setTag("Pos", new ListTag([
                new DoubleTag($player->getLocation()->x),
                new DoubleTag($player->getLocation()->y),
                new DoubleTag($player->getLocation()->z)
            ]))
            ->setTag("Motion", new ListTag([
                new DoubleTag($player->getMotion()->x),
                new DoubleTag($player->getMotion()->y),
                new DoubleTag($player->getMotion()->z)
            ]))
            ->setTag("Rotation", new ListTag([
                new FloatTag($player->getLocation()->yaw),
                new FloatTag($player->getLocation()->pitch)
            ]));
        return new self($player->getLocation(), $player->getSkin(), $nbt);
    }

    /**
     * @param int $currentTick
     *
     * @return bool
     */
    public function onUpdate(int $currentTick): bool
    {
        $parent = parent::onUpdate($currentTick);

        $this->setNameTag(TextFormat::colorize("§l§5*NEW*§r\n§r§ePartner items§r\n§7Map 1"));
        $this->setNameTagAlwaysVisible(true);

        return $parent;
    }

    /**
     * @param EntityDamageEvent $source
     */
    public function attack(EntityDamageEvent $source): void
    {
        $source->cancel();

        if (!$source instanceof EntityDamageByEntityEvent) {
            return;
        }

        $damager = $source->getDamager();

        if (!$damager instanceof Player) {
            return;
        }

        if ($damager->getInventory()->getItemInHand()->getId() === 276) {
            if ($damager->hasPermission('removenpc.ability')) {
                $this->kill();
            }
            return;
        }


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
        $menu->send($damager);
    }
}
