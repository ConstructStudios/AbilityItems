<?php

namespace ConstructStudios\AbilityItems\Listener;

use ConstructStudios\AbilityItems\Main;
use pocketmine\block\VanillaBlocks;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\Entity;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemFactory;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\world\particle\BlockBreakParticle;
use pocketmine\world\sound\AnvilBreakSound;
use pocketmine\world\sound\AnvilUseSound;
use pocketmine\world\sound\BellRingSound;
use pocketmine\world\sound\BucketFillLavaSound;
use pocketmine\world\sound\BucketFillWaterSound;
use pocketmine\world\sound\PotionFinishBrewingSound;
use pocketmine\world\sound\ShulkerBoxOpenSound;


class DamageListener implements Listener
{
    private array $armors = [];

    public function onDamage(EntityDamageByEntityEvent $event)
    {
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        $world = $entity->getWorld();
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Effect Disabler") {
            $type = 'EffectDisabler';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 60);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $entity->getEffects()->clear();
            $name = $entity->getName();
            $entity->sendMessage("§4♥ §cYour effects were cleared since someone used the §6§lEffect Disabler§r§c item against you.");
            $damager->sendMessage("§4♥ §cYou have cleared the effects of §6§l$name.");
            $world->addSound($damager->getPosition(), new AnvilUseSound(), [$damager]);
            $world->addSound($entity->getPosition(), new AnvilUseSound(), [$entity]);
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Starving Flesh") {
            $type = 'StarvingFlesh';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 60);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $entity->getHungerManager()->setFood(1);
            $world->addSound($damager->getPosition(), new BucketFillWaterSound(), [$damager]);
            $world->addSound($entity->getPosition(), new BucketFillLavaSound(), [$entity]);
            $name = $entity->getName();
            $entity->sendMessage("§4♥ §cYour hunger was removed since someone used the §6§lStarving Flesh§r§c item against you.");
            $damager->sendMessage("§4♥ §cYou have cleared the hunger of §6§l$name.");
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Inventory Clogger") {
            $type = 'InventoryClogger';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 60);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $entity->getInventory()->addItem(ItemFactory::getInstance()->get(270, 0, 36));
            $world->addSound($damager->getPosition(), new ShulkerBoxOpenSound(), [$damager]);
            $world->addSound($entity->getPosition(), new ShulkerBoxOpenSound(), [$entity]);
            $entity->sendMessage("§4♥ §cYour inventory was clogged since someone used the §6§lInventory Clogger§r§c item against you.");
            $name = $entity->getName();
            $damager->sendMessage("§4♥ §cYou have clogged the inventory of §6§l$name.");
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Bone") {
            $type = 'Bone';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 60);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $type = 'AntiTrapperTag';
            Main::getInstance()->addCooldown($type, $entity->getName(), 10);
            $entity->sendMessage("§4♥ §cYou can no longer place, break, open anything for 10 seconds since someone used the §6§lBone§r§c item against you.");
            $world->addSound($damager->getPosition(), new BellRingSound(), [$damager]);
            $world->addSound($entity->getPosition(), new BellRingSound(), [$entity]);
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Freezer") {
            $type = 'Freezer';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 60);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $entity->setImmobile(true);
            $entity->sendMessage("§4♥ §cYou just got frozen for 5 seconds.");
            $name = $entity->getName();
            $damager->sendMessage("§4♥ §cYou just froze §6§l$name.");
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
            $world->addSound($damager->getPosition(), new PotionFinishBrewingSound(), [$damager]);
            $world->addSound($entity->getPosition(), new PotionFinishBrewingSound(), [$entity]);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $entity->setImmobile(false);
                }
            }), 20 * 5);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Storm Breaker") {
            $type = 'StormBreaker';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 100);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $name = $entity->getName();
            $damager->sendMessage("§4♥ §cIn 3 seconds §6§l$name's §r§chelmet will be removed");
            $entity->sendMessage("§4♥ §cYour helmet will be removed in §l3 seconds§r§c!");
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
            $world->addSound($damager->getPosition(), new AnvilBreakSound(), [$damager]);
            $world->addSound($entity->getPosition(), new AnvilBreakSound(), [$entity]);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $hand = $entity->getInventory()->getItemInHand();
                    $inventory = $entity->getArmorInventory();
                    $helmet = $inventory->getHelmet();
                    $entity->getArmorInventory()->setHelmet($hand);
                    $entity->getInventory()->setItemInHand($helmet);

                }
            }), 20 * 3);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Thor") {
            $type = 'Thor';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 100);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $entity->sendMessage("§4♥ §cYou have §l§6Thor Ability§r§c!");
            $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, 5));
            $pos = $entity->getPosition();
            $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $entity->getPosition()->asVector3(), null, $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch(), 0.0, [], [], []);
            $block = $entity->getWorld()->getBlock($entity->getPosition()->floor()->down());
            $particle = new BlockBreakParticle($block);
            $entity->getWorld()->addParticle($pos, $particle);
            $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
            Server::getInstance()->broadcastPackets($entity->getWorld()->getPlayers(), [$light2, $sound2]);
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, 5));
                    $pos = $entity->getPosition();
                    $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $entity->getPosition()->asVector3(), null, $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch(), 0.0, [], [], []);
                    $block = $entity->getWorld()->getBlock($entity->getPosition()->floor()->down());
                    $particle = new BlockBreakParticle($block);
                    $entity->getWorld()->addParticle($pos, $particle);
                    $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
                    Server::getInstance()->broadcastPackets($entity->getWorld()->getPlayers(), [$light2, $sound2]);

                }
            }), 20 * 3);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, 5));
                    $pos = $entity->getPosition();
                    $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $entity->getPosition()->asVector3(), null, $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch(), 0.0, [], [], []);
                    $block = $entity->getWorld()->getBlock($entity->getPosition()->floor()->down());
                    $particle = new BlockBreakParticle($block);
                    $entity->getWorld()->addParticle($pos, $particle);
                    $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
                    Server::getInstance()->broadcastPackets($entity->getWorld()->getPlayers(), [$light2, $sound2]);

                }
            }), 20 * 6);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, 5));
                    $pos = $entity->getPosition();
                    $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $entity->getPosition()->asVector3(), null, $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch(), 0.0, [], [], []);
                    $block = $entity->getWorld()->getBlock($entity->getPosition()->floor()->down());
                    $particle = new BlockBreakParticle($block);
                    $entity->getWorld()->addParticle($pos, $particle);
                    $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
                    Server::getInstance()->broadcastPackets($entity->getWorld()->getPlayers(), [$light2, $sound2]);

                }
            }), 20 * 9);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, 5));
                    $pos = $entity->getPosition();
                    $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $entity->getPosition()->asVector3(), null, $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch(), 0.0, [], [], []);
                    $block = $entity->getWorld()->getBlock($entity->getPosition()->floor()->down());
                    $particle = new BlockBreakParticle($block);
                    $entity->getWorld()->addParticle($pos, $particle);
                    $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
                    Server::getInstance()->broadcastPackets($entity->getWorld()->getPlayers(), [$light2, $sound2]);

                }
            }), 20 * 12);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if ($entity->isOnline()) {
                    $entity->attack(new EntityDamageEvent($entity, EntityDamageEvent::CAUSE_FALL, 5));
                    $pos = $entity->getPosition();
                    $light2 = AddActorPacket::create(Entity::nextRuntimeId(), 1, "minecraft:lightning_bolt", $entity->getPosition()->asVector3(), null, $entity->getLocation()->getYaw(), $entity->getLocation()->getPitch(), 0.0, [], [], []);
                    $block = $entity->getWorld()->getBlock($entity->getPosition()->floor()->down());
                    $particle = new BlockBreakParticle($block);
                    $entity->getWorld()->addParticle($pos, $particle);
                    $sound2 = PlaySoundPacket::create("ambient.weather.thunder", $pos->getX(), $pos->getY(), $pos->getZ(), 1, 1);
                    Server::getInstance()->broadcastPackets($entity->getWorld()->getPlayers(), [$light2, $sound2]);

                }
            }), 20 * 15);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Pumpkin") {
            $type = 'Pumpkin';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 100);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $name = $entity->getName();
            $damager->sendMessage("§4♥ §l§6$name's §r§chelmet will turn into a pumpkin for 6 seconds!");
            $entity->sendMessage("§4♥ §cYour helmet will be a pumpkin for 6 seconds!");
            $helmet = $entity->getArmorInventory()->getHelmet();
            $entity->getArmorInventory()->setHelmet(VanillaBlocks::PUMPKIN()->asItem());
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity, $helmet): void {
                if ($entity->isOnline()) {
                    $entity->getArmorInventory()->setHelmet($helmet);
                    $entity->sendMessage("§4♥ §cYour helmet is back to normal!");

                }
            }), 20 * 6);
        }
        if ($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Fair Fight") {
            $type = 'FairFight';
            $global = 'PartnerItems';
            if (Main::getInstance()->inCooldown($type, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($type, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §6§l" . $type . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            if (Main::getInstance()->inCooldown($global, $damager->getName())) {
                $cooldown = (Main::getInstance()->getCooldown($global, $damager->getName()));
                $damager->sendMessage("§4♥ §cYou have §5§l" . $global . " §r§ccooldown, you need wait §l" . $cooldown . " seconds!");
                return;
            }
            Main::getInstance()->addCooldown($type, $damager->getName(), 100);
            Main::getInstance()->addCooldown($global, $damager->getName(), 15);
            $name = $entity->getName();
            $damager->sendMessage("§4♥ §cAll of §l§6$name's §r§carmor is now Protection I!");
            $entity->sendMessage("§4♥ §cAll your armor is now Protection I!");
            $this->armors[$entity->getName()] = $entity->getArmorInventory()->getContents();
            $entity->getArmorInventory()->setHelmet(VanillaItems::DIAMOND_HELMET()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
            $entity->getArmorInventory()->setChestplate(VanillaItems::DIAMOND_CHESTPLATE()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
            $entity->getArmorInventory()->setLeggings(VanillaItems::DIAMOND_LEGGINGS()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
            $entity->getArmorInventory()->setBoots(VanillaItems::DIAMOND_BOOTS()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
            $item = $damager->getInventory()->getItemInHand();
            $item->pop();
            $damager->getInventory()->setItemInHand($item);
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
                if (isset($this->armors[$entity->getName()]) && $entity->isOnline()) {
                    $entity->getArmorInventory()->setContents($this->armors[$entity->getName()]);
                    $entity->sendMessage("§4♥ §cYour armor is back to normal!");

                }
            }), 20 * 8);
        }
        $type = 'Rocket';
        if (Main::getInstance()->inCooldown($type, $entity->getName()) > 0) {
            if ($entity instanceof Player and $event->getCause() === EntityDamageEvent::CAUSE_FALL) {
                $event->cancel();
            }
        }
    }
    public function handleDeath(PlayerDeathEvent $event): void {
        $player = $event->getPlayer();
        $drops = $event->getDrops();

        if (isset($this->armors[$player->getName()])) {
            $drops = $this->armors[$player->getName()] + $player->getInventory()->getContents();
            unset($this->armors[$player->getName()]);
        }
        $event->setDrops($drops);
    }
}

