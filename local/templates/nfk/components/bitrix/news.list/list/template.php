<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
    /** @var array $arParams */
    /** @var array $arResult */
    /** @global CMain $APPLICATION */
    /** @global CUser $USER */
    /** @global CDatabase $DB */
    /** @var CBitrixComponentTemplate $this */
    /** @var string $templateName */
    /** @var string $templateFile */
    /** @var string $templateFolder */
    /** @var string $componentPath */
    /** @var CBitrixComponent $component */
    
    $this -> setFrameMode(true);
?>

<div class="wrapper-blog">
    <div class="cols-blog">

        <? foreach ($arResult['ITEMS'] as $arItem): ?>

        <div class="col-blog" ontouchstart="this.classList.toggle('hover');">
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="container-blog">
                <div class="front" style="background-image: url('<?=$arItem['DISPLAY_PROPERTIES']['BG']['VALUE'];?>');">
                    <div class="inner">
                        <p><?=$arItem['NAME'];?></p>
                        <span><?=$arItem['PREVIEW_TEXT'];?></span>
                    </div>
                </div>
                <div class="back">
                    <div class="inner">
                        <p><?=$arItem['DETAIL_TEXT'];?></p>
                    </div>
                </div>
            </a>
        </div>

        <? endforeach; ?>

    </div>
</div>



