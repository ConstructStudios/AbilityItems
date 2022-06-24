<?php

namespace ConstructStudios\AbilityItems\entity;

use ConstructStudios\AbilityItems\Listener\ItemUseListener;
use pocketmine\data\bedrock\EffectIds;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Human;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class PortableBardEntity extends Human
{

    private string $player;

    private array $effectsHold = [
        EffectIds::REGENERATION => [5 * 20, 2],
        EffectIds::STRENGTH => [5 * 20, 1],
        EffectIds::RESISTANCE => [5 * 10, 2]
    ];

    private int $duration = 20;

    /** @var int|null */

    /**
     * @param Player $player
     *
     * @return \ConstructStudios\AbilityItems\entity\PortableBardEntity
     */
    public static function create(Player $player): self
    {
        $nbt = CompoundTag::create()
            ->setTag("Pos", new ListTag([
                new DoubleTag($player->getLocation()->x),
                new DoubleTag($player->getLocation()->y),
                new DoubleTag($player->getLocation()->z)
            ]))
            ->setTag("Motion", new ListTag([
                new DoubleTag($player->getMotion()->x),
                new DoubleTag($player->getMotion()->y),
                new DoubleTag($player->getMotion()->z)
            ]))
            ->setTag("Rotation", new ListTag([
                new FloatTag($player->getLocation()->yaw),
                new FloatTag($player->getLocation()->pitch)
            ]));
        return new self($player->getLocation(),$nbt);
    }

    private function getBardFunction(): void
    {
        $player = ItemUseListener::getInstance()->getPlayer($this->player);

        if ($player instanceof Player) {
            if ($player->getPosition()->distance($player) <= 10) {
                $player->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 20 * 5, 0));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::STRENGTH(), 5 * 20, 0));
                $player->getEffects()->add(new EffectInstance(VanillaEffects::RESISTANCE(), 5 * 20, 0));
            }
        }
    }

    private function holdEffect(): void
    {
        $player = Main::getInstance()->getPlayer($this->player);
        if ($player instanceof Player) {
            if ($player->getPosition()->distance($player) <= 10) {
                $random = [VanillaEffects::REGENERATION(), VanillaEffects::STRENGTH(), VanillaEffects::RESISTANCE()];
                $effectId = $random[mt_rand(0, 2)];
                $data = $this->effectsHold[$effectId];

                $player->getEffects()->add(new EffectInstance(EffectIds::add($effectId), (int) $data[0], (int) $data[1]));
            }
        }
    }

    public function onUpdate(int $currentTick): bool
    {
        if ($this->player == null) {
            $this->kill();
            return false;
        }

        if ($currentTick % 20 == 0) {
            $this->duration--;
            $this->getBardFunction();

            if ($this->duration == 0)
                $this->kill();
        }

        if ($currentTick % 120 == 0)
            $this->holdEffect();

        $parent = parent::onUpdate($currentTick);

        $this->setNameTag(TextFormat::colorize("§l§6Portable Bard§r"));
        $this->setNameTagAlwaysVisible(true);

        $this->getArmorInventory()->setHelmet(VanillaItems::DIAMOND_HELMET()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
        $this->getArmorInventory()->setChestplate(VanillaItems::DIAMOND_CHESTPLATE()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
        $this->getArmorInventory()->setLeggings(VanillaItems::DIAMOND_LEGGINGS()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
        $this->getArmorInventory()->setBoots(VanillaItems::DIAMOND_BOOTS()->addEnchantment(new EnchantmentInstance(EnchantmentIdMap::getInstance()->fromId(0), 1)));
        $this->getEffects()->add(new EffectInstance(VanillaEffects::SPEED(), 99999, 1));
        $this->getEffects()->add(new EffectInstance(VanillaEffects::REGENERATION(), 99999, 1));
        return $parent;

    }

    public function getDrops(): array
    {
        return [];
    }

    public function getXpDropAmount(): int
    {
        return 0;
    }
}
