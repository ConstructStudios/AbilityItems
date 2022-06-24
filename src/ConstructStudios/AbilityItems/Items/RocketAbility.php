<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class RocketAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::FIREWORKS, 0), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Rocket", ["\n§r§7Right-Click to receive\n§r§7and you will receive a boost of 8 blocks\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }
}