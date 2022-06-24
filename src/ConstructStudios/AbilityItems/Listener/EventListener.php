<?php

namespace ConstructStudios\AbilityItems\Listener;

use ConstructStudios\AbilityItems\Main;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\utils\TextFormat;


class EventListener implements Listener
{
    public function onBreak(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $type = 'AntiTrapperTag';
        if (Main::getInstance()->inCooldown($type, $player->getName()) > 0) {
            $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
            $player->sendMessage("§4♥ §cYou cannot break, place, or open anything! §l" . $cooldown . " seconds!");
            $event->cancel();
        }
    }
    public function onInteract(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $type = 'AntiTrapperTag';
        if (Main::getInstance()->inCooldown($type, $player->getName()) > 0) {
            $cooldown = (Main::getInstance()->getCooldown($type, $player->getName()));
            $player->sendMessage("§4♥ §cYou cannot break, place, or open anything! §l" . $cooldown . " seconds!");
            $event->cancel();
        }
        if ($player->getInventory()->getItemInHand()->getCustomName() === TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Freezer") {
            $player->sendMessage("§4♥ §cThis is an Ability Item, you can't place this block");
            $event->cancel();
        }
    }
}
