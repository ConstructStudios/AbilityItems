<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class RegenerationAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::GHAST_TEAR, 0), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Regeneration III", ["\n§r§7Right-Click to receive\n§r§7Regeneration III for 8 seconds\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }
}