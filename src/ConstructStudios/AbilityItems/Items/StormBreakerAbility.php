<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class StormBreakerAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::GOLD_AXE, 0), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Storm Breaker", ["\n§r§7Give a hit to a player with\nthis item and in 3 seconds \nthe helmet will be removed!\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }
}