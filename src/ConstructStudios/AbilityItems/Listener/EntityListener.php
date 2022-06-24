<?php

namespace ConstructStudios\AbilityItems\Listener;

use ConstructStudios\AbilityItems\entity\RottenEggEntity;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\Listener;
use ConstructStudios\AbilityItems\entity\SwitcherEntity;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\world\sound\PopSound;


class EntityListener implements Listener
{
    public function onHitByProjectile(ProjectileHitEntityEvent $event) : void
    {
        $hit = $event->getEntityHit();
        if ($hit instanceof Player) {
            $entity = $event->getEntity();
            $player = $entity->getOwningEntity();
            if ($player instanceof Player) {
                if ($entity instanceof SwitcherEntity) {
                    $player->sendMessage("§4♥ §cYou have switchered §6§l" . $hit->getName() . "§c!");
                    $pos1 = $player->getPosition();
                    $pos2 = $hit->getPosition();
                    $hit->teleport($pos1);
                    self::playSound($pos1, "mob.endermite.hit");
                    self::playSound($pos2, "mob.endermite.hit");
                    $hit->sendMessage("§4♥ §c§6§l" . $player->getName() . " §r§chas switchered you!");
                    $player->teleport($pos2);
                }
            }
        }
        if ($hit instanceof Player) {
            $entity = $event->getEntity();
            $player = $entity->getOwningEntity();
            if ($player instanceof Player) {
                if ($entity instanceof RottenEggEntity) {
                    $world = $player->getWorld();
                    $hit->sendMessage("§4♥ §cYou have §6§lRottenEgg§r§c effects by §6§l" . $player->getName() . "§c!");
                    $world->addSound($player->getPosition(), new PopSound(), [$player]);
                    $world->addSound($hit->getPosition(), new PopSound(), [$hit]);
                    $player->sendMessage("§4♥ §c§6§l" . $hit->getName() . " §r§chas give §6§lRottenEgg§r§c effects for you!");
                    $hit->getEffects()->add(new EffectInstance(VanillaEffects::SLOWNESS(), 20 * 5, 1));
                    $hit->getEffects()->add(new EffectInstance(VanillaEffects::NAUSEA(), 20 * 5, 1));
                    $hit->getEffects()->add(new EffectInstance(VanillaEffects::BLINDNESS(), 20 * 5, 1));
                }
            }
        }
    }
    protected static function playSound(Position $pos, string $soundName):void {
        $sPk = new PlaySoundPacket();
        $sPk->soundName = $soundName;
        $sPk->x = $pos->x;
        $sPk->y = $pos->y;
        $sPk->z = $pos->z;
        $sPk->volume = $sPk->pitch = 1;
        $pos->getWorld()->broadcastPacketToViewers($pos, $sPk);
    }
}
