<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle("Главная");
?>

<?$APPLICATION->IncludeComponent("bitrix:system.auth.form","",Array(
        "REGISTER_URL" => "register.php",
        "FORGOT_PASSWORD_URL" => "",
        "PROFILE_URL" => "profile.php",
        "SHOW_ERRORS" => "Y"
    )
);?>

<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>