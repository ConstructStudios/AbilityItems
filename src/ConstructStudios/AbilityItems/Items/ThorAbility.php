<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class ThorAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::BLAZE_ROD, 0), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Thor", ["\n§r§7Give a hit with this item to a player to\nmake Thor launch 3 lightning bolts at them\nfor a period of 6 seconds!\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }
}