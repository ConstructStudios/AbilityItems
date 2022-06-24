<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class StarvingFleshAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::ROTTEN_FLESH, 0), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Starving Flesh", ["\n§r§7Hit another player with this rotten flesh to \n§7set the hunger of the player to 1!\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }
}