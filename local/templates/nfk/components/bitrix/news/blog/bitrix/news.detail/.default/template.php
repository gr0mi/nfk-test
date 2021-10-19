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

    $this->setFrameMode(true);

?>
<div class="blog-detail">
    <div class="blog-detail-img">
        <img src="<?=$arResult['PROPERTIES']['BG']['VALUE']?>" alt="img">
    </div>
    <div class="blog-info">
        <span><?=$arResult['NAME']?></span>
        <span class="blog-post-date"><?=FormatDateFromDB($arResult["TIMESTAMP_X"], 'SHORT');?></span>
    </div>
    <div class="blog-detail-text">
        <p><?=$arResult['DETAIL_TEXT']?></p>
    </div>

    <a href="#" id="blog-add-fav" data-id="<?=$arResult['ID']?>">Add to fav</a>
</div>

