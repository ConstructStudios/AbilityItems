<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class CobwebEggAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::SPAWN_EGG, 35), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Cobweb Egg", ["\n§r§7Right click to leave a trail of cobwebs behind\nyou for period of 10 seconds. All cobwebs\nwill despawn after 20 seconds or can be broken.\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }
}
