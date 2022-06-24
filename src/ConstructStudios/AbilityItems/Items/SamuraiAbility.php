<?php

namespace ConstructStudios\AbilityItems\Items;

use ConstructStudios\AbilityItems\Main;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

class SamuraiAbility extends AbilityItems
{

    public function __construct()
    {
        $config = Main::getInstance()->getConfig();
        parent::__construct(new ItemIdentifier(ItemIds::DIAMOND_SWORD, 0), TextFormat::RESET . TextFormat::GOLD . TextFormat::BOLD . "Samurai", ["\n§r§7Right click to start a teleportation process into\nthe body of the player who last hit you. Once\nyou are teleported, you will receive Strength II\nand Speed III, and the player will be under the\nExotic Bone effect, on Pearl Cooldown, and on\nPartner Item cooldown for 15 seconds\n\n§ePurchase at §6" . $config->get("store")], [new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1, )]);
    }

    public function getMaxStackSize(): int
    {
        return 1;
    }
}