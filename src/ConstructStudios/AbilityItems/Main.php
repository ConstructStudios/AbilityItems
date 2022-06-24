<?php

namespace ConstructStudios\AbilityItems;

use ConstructStudios\AbilityItems\Commands\AbilitysCommand;
use ConstructStudios\AbilityItems\Commands\PartnerItemsCommand;
use ConstructStudios\AbilityItems\Commands\PartnerPackageCommand;
use ConstructStudios\AbilityItems\entity\NPCEntity;
use ConstructStudios\AbilityItems\entity\PortableBardEntity;
use ConstructStudios\AbilityItems\entity\RottenEggEntity;
use ConstructStudios\AbilityItems\entity\SwitcherEntity;
use ConstructStudios\AbilityItems\Listener\DamageListener;
use ConstructStudios\AbilityItems\Listener\EntityListener;
use ConstructStudios\AbilityItems\Listener\EventListener;
use ConstructStudios\AbilityItems\Listener\ItemUseListener;
use ConstructStudios\AbilityItems\Listener\PartnerPackageListener;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use pocketmine\world\World;

class Main extends PluginBase
{
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    /** @var Item[] */
    private array $saved_items = [];

    private array $cooldowns = [
        'Strength' => [],
        'Resistance' => [],
        'Rocket' => [],
        'CloseCall' => [],
        'RageBrick' => [],
        'SoupBowl' => [],
        'NinjaStar' => [],
        'EffectDisabler' => [],
        'StarvingFlesh' => [],
        'InventoryClogger' => [],
        'Bone' => [],
        'Freezer' => [],
        'PotionRefill' => [],
        'PrePearl' => [],
        'CobwebEgg' => [],
        'StormBreaker' => [],
        'Pumpkin' => [],
        'FairFight' => [],
        'FocusMode' => [],
        'Thor' => [],
        'Regeneration' => [],
        'Speed' => [],
        'JumpBoost' => [],
        'Switcher' => [],
        'RottenEgg' => [],
        'Samurai' => [],

        'AntiTrapperTag' => [],
        'FreezerTag' => [],

        'PartnerItems' => []
    ];

    protected function onEnable(): void
    {

        $this->saveResource("config.yml");

        $this->getServer()->getCommandMap()->register("abilitys", new AbilitysCommand());
        $this->getServer()->getCommandMap()->register("partneritems", new PartnerItemsCommand());
    $this->getServer()->getCommandMap()->register("partnerpackages", new PartnerPackageCommand());

        EntityFactory::getInstance()->register(NPCEntity::class, function (World $world, CompoundTag $nbt): NPCEntity {
            return new NPCEntity(EntityDataHelper::parseLocation($nbt, $world), NPCEntity::parseSkinNBT($nbt), $nbt);
        }, ['AbilityNPCEntity']);

        EntityFactory::getInstance()->register(SwitcherEntity::class, function (World $world, CompoundTag $nbt): SwitcherEntity {
            return new SwitcherEntity(EntityDataHelper::parseLocation($nbt, $world), null, $nbt);
        }, ['SwitcherEntity']);

        EntityFactory::getInstance()->register(RottenEggEntity::class, function (World $world, CompoundTag $nbt): RottenEggEntity {
            return new RottenEggEntity(EntityDataHelper::parseLocation($nbt, $world), null, $nbt);
        }, ['RottenEggEntity']);

        if (!InvMenuHandler::isRegistered()) {
            InvMenuHandler::register($this);
        }

        $this->registerListener(new ItemUseListener());
        $this->registerListener(new DamageListener());
        $this->registerListener(new EventListener());
        $this->registerListener(new EntityListener());
        $this->registerListener(new PartnerPackageListener());

    }

    private function registerListener(Listener $listener): void
    {
        $this->getServer()->getPluginManager()->registerEvents($listener, $this);
    }

    public function inCooldown(string $type, string $player): bool
    {
        if (isset($this->cooldowns[$type]) && isset($this->cooldowns[$type][$player])) {
            return $this->cooldowns[$type][$player] > time();
        }
        return false;
    }

    public function getCooldown(string $type, string $player): int
    {
        return $this->cooldowns[$type][$player] - time();
    }

    public function addCooldown(string $type, string $player, int $time): void
    {
        $this->cooldowns[$type][$player] = time() + $time;
    }
    /**
     * @return Item[]
     */
    public function getSavedItems(): array {
        return $this->saved_items;
    }

    public function getSavedItemByCustomName(string $custom_name): ?Item {
        return $this->saved_items[$custom_name] ?? null;
    }

    public function addSavedItem(Item $item): void {
        $this->saved_items[$item->getCustomName()] = $item;
    }
}
