<?php

namespace ConstructStudios\AbilityItems\Listener;

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
use ConstructStudios\AbilityItems\Items\StormBreakerAbility;
use ConstructStudios\AbilityItems\Items\StrengthAbility;
use ConstructStudios\AbilityItems\Items\SwitcherAbility;
use ConstructStudios\AbilityItems\Items\ThorAbility;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\utils\TextFormat;


class PartnerPackageListener implements Listener
{
    public function onItemUse(PlayerItemUseEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();

        switch ($item->getCustomName()) {
            case TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Partner Package":
                $items = [
                    new RottenEggAbility(),
                    new StrengthAbility(),
                    new ResistanceAbility(),
                    new RocketAbility(),
                    new CloseCallAbility(),
                    new EffectDisablerAbility(),
                    new InventoryCloggerAbility(),
                    new StarvingFleshAbility(),
                    new SoupBowlAbility(),
                    new NinjaStarAbility(),
                    new RageBrickAbility(),
                    new SwitcherAbility(),
                    new BoneAbility(),
                    new FreezerAbility(),
                    new PotionRefillAbility(),
                    new StormBreakerAbility(),
                    new PrePearAbility(),
                    new ThorAbility(),
                    new CobwebEggAbility(),
                    new PumpkinAbility(),
                    new FairFightAbility(),
                    new FocusModeAbility(),
                    new PocketBardAbility(),
                    new SamuraiAbility(),
                ];
                $randomItem = $items[array_rand($items)];
                $player->getInventory()->addItem($randomItem);
                $player->sendMessage("§6Package Abierta");
                $item->pop();
                $player->getInventory()->setItemInHand($item);
                break;

        }
    }
}
