<?php

namespace ConstructStudios\AbilityItems\Listener;

use ConstructStudios\AbilityItems\entity\NPCEntity;
use ConstructStudios\AbilityItems\entity\PortableBardEntity;
use ConstructStudios\AbilityItems\entity\RottenEggEntity;
use ConstructStudios\AbilityItems\entity\SwitcherEntity;
use ConstructStudios\AbilityItems\Items\JumpBoostAbility;
use ConstructStudios\AbilityItems\Items\RegenerationAbility;
use ConstructStudios\AbilityItems\Items\ResistanceAbility;
use ConstructStudios\AbilityItems\Items\SpeedAbility;
use ConstructStudios\AbilityItems\Items\StrengthAbility;
use ConstructStudios\AbilityItems\Main;
use ConstructStudios\AbilityItems\task\NinjaStarTask;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Location;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemFactory;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\sound\AnvilFallSound;
use pocketmine\world\sound\BellRingSound;
use pocketmine\world\sound\BlazeShootSound;
use pocketmine\world\sound\DoorCrashSound;
use pocketmine\world\sound\GhastShootSound;
use pocketmine\world\sound\GhastSound;
use pocketmine\world\sound\TotemUseSound;
use pocketmine\world\sound\XpCollectSound;


class ItemUseListener implements Listener
{
    private array $blocks = [];
    private array $times = [];
    private array $focus = [];

    public function onItemUse(PlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $world = $player->getWorld();

        switch ($item->getCustomName()) {
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Strength II":
                $type = 'Strength';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->sendMessage("§4♥ §cYou have used the §6§lStrenght II §r§cand you are on cooldown.");
                $world->addSound($player->getPosition(), new BlazeShootSound(), [$player]);
                $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 8, 1));
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Resistance III":
                $type = 'Resistance';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->sendMessage("§4♥ §cYou have used the §6§lResistance III §r§cand you are on cooldown.");
                $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 8, 2));
                $world->addSound($player->getPosition(), new AnvilFallSound(), [$player]);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Speed III":
                $type = 'Speed';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->sendMessage("§4♥ §cYou have used the §6§lSpeed III §r§cand you are on cooldown.");
                $world->addSound($player->getPosition(), new BlazeShootSound(), [$player]);
                $player->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 20 * 8, 2));
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Regeneration III":
                $type = 'Regeneration';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->sendMessage("§4♥ §cYou have used the §6§lRegeneration III §r§cand you are on cooldown.");
                $world->addSound($player->getPosition(), new BlazeShootSound(), [$player]);
                $player->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 20 * 8, 2));
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "JumpBoost VII":
                $type = 'JumpBoost';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->sendMessage("§4♥ §cYou have used the §6§lJumpBoost VII §r§cand you are on cooldown.");
                $world->addSound($player->getPosition(), new BlazeShootSound(), [$player]);
                $player->getEffects()->add(new EffectInstance(VanillaEffects::JUMP_BOOST(), 20 * 8, 6));
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rocket":
                $type = 'Rocket';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->sendMessage("§4♥ §cYou have used the §6§lRocket §r§cand you are on cooldown.");
                $player->setMotion($player->getDirectionVector()->multiply(0.5)->add(0, 1.8, 0));
                $world->addSound($player->getPosition(), new GhastShootSound(), [$player]);
                $item = $event->getItem();
                $item->pop();
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Close Call":
                if ($player->getHealth() > 7) {
                    $player->sendMessage("§cYou do not have 4 hearts §4♥ §cor less!");
                    return;
                }
                $type = 'CloseCall';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                $player->getInventory()->setItemInHand($item);
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage("§4♥ §cYou have used the §6§lClose Call §r§cand you are on cooldown.");
                $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 6, 2));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 20 * 6, 4));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 6, 1));
                $world->addSound($player->getPosition(), new GhastSound(), [$player]);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                return;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rage Brick":
                $type = 'RageBrick';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                foreach (Server::getInstance()->getOnlinePlayers() as $online_player) {
                    if ($player->getPosition()->distance($online_player->getPosition()) <= 8) {
                        $duration[] = $online_player;
                        $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), count($duration) * 20, 1));
                        $world->addSound($player->getPosition(), new XpCollectSound(), [$player]);
                        $item = clone $event->getItem();
                        $item->pop();
                        $player->getInventory()->setItemInHand($item);
                    }
                }
                return;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Soup Bowl":
                $type = 'SoupBowl';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $player->setHealth(20);
                $player->sendMessage("§4♥ §cSoup Bowl Ability Activated.");
                $player->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 20 * 6, 4));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 20 * 6, 4));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::ABSORPTION(), 20 * 60, 1));
                $world->addSound($player->getPosition(), new TotemUseSound(), [$player]);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Potion Refill":
                $type = 'PotionRefill';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage("§4♥ §cPotion Refill Ability Activated.");
                $player->getInventory()->addItem(ItemFactory::getInstance()->get(438, 22, 36));
                $world->addSound($player->getPosition(), new BellRingSound(), [$player]);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Ninja Star":
                if ($player->getLastDamageCause() === null) {
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                $type = 'NinjaStar';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if ($player->getLastDamageCause() instanceof Player)
                    $item = $event->getItem();
                    $cause = $player->getLastDamageCause();
                if ($player->getLastDamageCause() === null) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                }
                if (!$cause instanceof EntityDamageByEntityEvent) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                $damager = $cause->getDamager();
                if (!$damager instanceof Player) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                if ($player->getLastDamageCause() === null) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 100);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $damager->sendMessage("§l§4WARNING - §r§cPlayer teleporting!");
                $player->sendMessage("§4♥ §cYou are teleporting to the other player in 3 seconds.");
                $player->sendMessage("§4♥ §cYou are now on a cooldown for 10 seconds");
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new NinjaStarTask($player, $damager), 20);
                $world->addSound($player->getPosition(), new DoorCrashSound(), [$player]);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Switcher":
                $event->cancel();
                $type = 'Switcher';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 100);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $entity = new SwitcherEntity(Location::fromObject($player->getEyePos(), $player->getWorld(), $player->getLocation()->getYaw(), $player->getLocation()->getPitch()), $player);
                $entity->setMotion($event->getDirectionVector()->multiply(1.5));
                $entity->spawnToAll();
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rotten Egg":
                $event->cancel();
                $type = 'RottenEgg';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 15);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $entity = new RottenEggEntity(Location::fromObject($player->getEyePos(), $player->getWorld(), $player->getLocation()->getYaw(), $player->getLocation()->getPitch()), $player);
                $entity->setMotion($event->getDirectionVector()->multiply(1.5));
                $entity->spawnToAll();
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Cobweb Egg":
                $event->cancel();
                $type = 'CobwebEgg';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 120);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage("§4♥ §c§6§lCobweb Egg Ability §r§cActivated!");

                $handler = null;
                $playerName = $player->getName();

                $this->times[$playerName] = 20;
                $this->blocks[$playerName] = [];

                $handler = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new  ClosureTask(function () use (&$handler, $player, $playerName): void {
                    $this->times[$playerName]--;

                    if ($this->times[$playerName] === 0) {
                        foreach ($this->blocks[$playerName] as $block) {
                            $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::AIR());
                        }
                        unset($this->times[$playerName], $this->blocks[$playerName]);
                        $handler->cancel();
                        return;
                    }

                    if ($player->isOnline() && $this->times[$playerName] >= 10) {
                        $block = $player->getWorld()->getBlock($player->getPosition());

                        if ($block->getId() === 0) {
                            $player->getWorld()->setBlock($player->getPosition(), VanillaBlocks::COBWEB());
                            $this->blocks[$playerName][] = $block;
                        }
                    }
                }), 20);
                return;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "PrePearl":
                $event->cancel();
                $type = 'PrePearl';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 120);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $prepearl = $player->getPosition();
                $player->sendMessage("§4♥ §cYou just used the §6§lPrePearl Ability §r§cin 16 seconds you will return to this position!");
                Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($player, $prepearl): void {
                    if ($player->isOnline()) {
                        $player->teleport($prepearl);
                        $player->sendMessage("§4♥ §cYou just returned to your position!");
                    }
                }), 20 * 16);
                return;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Samurai":
                if ($player->getLastDamageCause() === null) {
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                $type = 'Samurai';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if ($player->getLastDamageCause() instanceof Player)
                    $item = $event->getItem();
                $cause = $player->getLastDamageCause();
                if ($player->getLastDamageCause() === null) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                }
                if (!$cause instanceof EntityDamageByEntityEvent) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                $damager = $cause->getDamager();
                if (!$damager instanceof Player) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Ninja Star but we couldn't find the player.");
                    return;
                }
                if ($player->getLastDamageCause() === null) {
                    if (Main::getInstance()->inCooldown($global, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    if (Main::getInstance()->inCooldown($type, $player->getName())) {
                        $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                        $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                        return;
                    }
                    $player->sendMessage("§4♥ §cYou tried using the Samurai Star but we couldn't find the player.");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 100);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $type = 'AntiTrapperTag';
                Main::getInstance()->addCooldown($type, $damager->getName(), 10);
                $damager->sendMessage("§l§4WARNING - §r§cPlayer teleporting!");
                $player->sendMessage("§4♥ §cYou are teleporting to the other player in 3 seconds.");
                $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 20 * 8, 1));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 20 * 8, 2));
                $player->sendMessage("§4♥ §cYou are now on a cooldown for 10 seconds");
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new NinjaStarTask($player, $damager), 20);
                $world->addSound($player->getPosition(), new DoorCrashSound(), [$player]);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Pocket Bard":
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
                $purple = ItemFactory::getInstance()->get(241, 2)->setCustomName("§r ")->setLore(["§r "])->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(1), 1));
                $menu->setName("§r§6Pocket Bard");
                $menu->getInventory()->setContents([
                    0 => $purple,
                    1 => $purple,
                    7 => $purple,
                    8 => $purple,
                    9 => $purple,
                    17 => $purple,
                    18 => $purple,
                    19 => $purple,
                    25 => $purple,
                    26 => $purple,
                    11 => VanillaItems::BLAZE_POWDER()->setCustomName(TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Strength II")->setLore(["§r§7Click to select this bard buff"]),
                    12 => VanillaItems::SUGAR()->setCustomName(TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Speed III")->setLore(["§r§7Click to select this bard buff"]),
                    13 => VanillaItems::IRON_INGOT()->setCustomName(TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Resistance III")->setLore(["§r§7Click to select this bard buff"]),
                    14 => VanillaItems::GHAST_TEAR()->setCustomName(TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Regeneration III")->setLore(["§r§7Click to select this bard buff"]),
                    15 => VanillaItems::FEATHER()->setCustomName(TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "JumpBoost VII")->setLore(["§r§7Click to select this bard buff"]),

                ]);

                $menu->setListener(function (InvMenuTransaction $transaction): InvMenuTransactionResult {
                    $player = $transaction->getPlayer();
                    if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Strength II") {
                        $player->getInventory()->addItem(new StrengthAbility());
                        $player->getInventory()->addItem(new StrengthAbility());
                        $player->getInventory()->addItem(new StrengthAbility());
                        $player->removeCurrentWindow();
                    }
                    if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Speed III") {
                        $player->getInventory()->addItem(new SpeedAbility());
                        $player->getInventory()->addItem(new SpeedAbility());
                        $player->getInventory()->addItem(new SpeedAbility());
                        $player->removeCurrentWindow();
                    }
                    if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Resistance III") {
                        $player->getInventory()->addItem(new ResistanceAbility());
                        $player->getInventory()->addItem(new ResistanceAbility());
                        $player->getInventory()->addItem(new ResistanceAbility());
                        $player->removeCurrentWindow();
                    }
                    if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Regeneration III") {
                        $player->getInventory()->addItem(new RegenerationAbility());
                        $player->getInventory()->addItem(new RegenerationAbility());
                        $player->getInventory()->addItem(new RegenerationAbility());
                        $player->removeCurrentWindow();
                    }
                    if ($transaction->getItemClicked()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "JumpBoost VII") {
                        $player->getInventory()->addItem(new JumpBoostAbility());
                        $player->getInventory()->addItem(new JumpBoostAbility());
                        $player->getInventory()->addItem(new JumpBoostAbility());
                        $player->removeCurrentWindow();
                    }
                    return $transaction->discard();

                });
                $menu->send($player);
                return;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Focus Mode":
                $event->cancel();
                $type = 'FocusMode';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage("§4♥ §cHas activated §l§6Focus Mode§r§c, will do 30% more damage for 10 seconds");
                $playerName = $player->getName();
                $this->focus[$playerName] = true;

                Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask (function () use ($playerName): void {
                    unset($this->focus[$playerName]);
                }), 10 * 20);
                break;
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Portable Bard":
                $event->cancel();
                $type = 'PortableBard';
                $global = 'PartnerItems';
                if (Main::getInstance()->inCooldown($type, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                if (Main::getInstance()->inCooldown($global, $player->getName())) {
                    $cooldown = (Main::getInstance()->getCooldown($global, $player->getName()));
                    $player->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                    return;
                }
                Main::getInstance()->addCooldown($type, $player->getName(), 45);
                Main::getInstance()->addCooldown($global, $player->getName(), 15);
                $item = $event->getItem();
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                $player->sendMessage("§4♥ §cHas activated §l§6Portable Bard§r§c, will do 30% more damage for 10 seconds");
                $entity = PortableBardEntity::create($player);
                $entity->spawnToAll();
                break;

        }
    }
    public function onEntity(EntityDamageEvent $event): void
    {
        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if (isset($this->focus[$damager->getName()])) {
                    $event->setBaseDamage($event->getBaseDamage() + (($event->getBaseDamage() / 100) * 30));
                }
            }
        }
    }
}
